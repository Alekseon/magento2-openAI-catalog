<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\OpenAICatalog\Model\Product\DownloadGptAttributes;

use Alekseon\OpenAIApiClient\Model\OpenAIClient;
use Alekseon\OpenAICatalog\Api\DownloadGptAttributesInteface;
use Alekseon\OpenAICatalog\Model\Config\Product\Config;
use Alekseon\OpenAICatalog\Model\Config\Product\Source\SearchType;
use Alekseon\OpenAICatalog\Model\MappingAttributes\SEO;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory as AttributeCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Catalog\Model\Product;

class GptSEO implements DownloadGptAttributesInteface
{
    protected string $name = 'chatgpt';

    /**
     * @param OpenAIClient $AIClient
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     * @param AttributeCollectionFactory $collectionFactory
     * @param ProductRepositoryInterface $productRepository
     * @param CollectionFactory $productAttributeCollectionFactory
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        protected readonly OpenAIClient $AIClient,
        protected readonly Config $config,
        protected readonly StoreManagerInterface $storeManager,
        protected readonly AttributeCollectionFactory $collectionFactory,
        protected readonly ProductRepositoryInterface $productRepository,
        protected readonly CollectionFactory $productAttributeCollectionFactory,
        protected readonly AttributeRepositoryInterface $attributeRepository
    ) { }

    /**
     * @param ProductInterface $product
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function execute(ProductInterface $product): array
    {
        $attributesToQuestion = $this->getAttributesForQuestion($product);
        $result = [];

        foreach (SEO::ALEKSEON_GPT_PRODUCTATTR_SEO as $key => $attributeCode) {
            $question = $this->config->getValue(
                SEO::ALEKSEON_MAP_GPT_PRODUCTATTR_TO_CONFIG_QUESTION[$attributeCode],
                $this->storeManager->getStore()->getId()
            );

            $response = $this->AIClient->getCompletions($attributesToQuestion . '. ' . $question);
            $gptText = $response->getChoiceText();
            $result[$attributeCode] = $gptText ?: '';
        }

        return $result;
    }

    /**
     * @param ProductInterface $product
     * @return string
     */
    public function getAttributesForQuestion(ProductInterface $product): ?string
    {
        $searchType = $this->config->getSearchType($this->storeManager->getStore()->getId());
        $attributesToQuestion = '';

        if ($searchType === SearchType::SEARCH_TYPE_AUTOMATIC) {
            $attributesToQuestion = $this->getAttributesForAutomatic($product);
        } elseif ($searchType === SearchType::SEARCH_TYPE_MANUAL) {
            $attributesToQuestion = $this->getAttributesForManual($product);
        }

        return $attributesToQuestion;
    }

    public function getAttributesForAutomatic($product)
    {
        /** @var Collection $productAttributes */
        $productAttributes = $this->productAttributeCollectionFactory->create();
        $getAttributes = $productAttributes->addFieldToFilter(
            ['is_filterable', 'backend_type'], [1, 'text']
        );

        $result = '';
        foreach ($getAttributes as $attribute) {
            $attributeCode = $attribute->getAttributeCode();
            $value = $attribute->getFrontend()->getValue($product);

            if ($value) {
                $result .= $attribute->getFrontendLabel() . ': "' . $value . '", ';
            }
        }

        return $result;
    }

    public function getAttributesForManual($product)
    {
        $attributes = ($this->config->getProductAttributes($this->storeManager->getStore()->getId()));

        if (empty($attributes)) {
            throw new \Exception('Please choose attribures for search in config');
        }

        $result = '';

        foreach ($attributes as $attributeCode) {
            $attribute = $this->attributeRepository->get(Product::ENTITY, $attributeCode);
            $value = $attribute->getFrontend()->getValue($product);

            if ($value) {
                $result .= $attribute->getFrontendLabel() . ': "' . $value . '", ';
            }
        }

        return $result;
    }

    public function getName()
    {
        return $this->name;
    }
}
