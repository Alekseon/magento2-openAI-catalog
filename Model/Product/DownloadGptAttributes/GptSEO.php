<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\OpenAICatalog\Model\Product\DownloadGptAttributes;

use Alekseon\OpenAIApiClient\Model\OpenAIClient;
use Alekseon\OpenAICatalog\Api\DownloadGptAttributesInteface;
use Alekseon\OpenAICatalog\Model\Config\Product\Config;
use Alekseon\OpenAICatalog\Model\MappingAttributes\SEO;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory as AttributeCollectionFactory;

class GptSEO implements DownloadGptAttributesInteface
{
    /**
     * @param OpenAIClient $AIClient
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     * @param AttributeCollectionFactory $collectionFactory
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        protected readonly OpenAIClient $AIClient,
        protected readonly Config $config,
        protected readonly StoreManagerInterface $storeManager,
        protected readonly AttributeCollectionFactory $collectionFactory,
        protected ProductRepositoryInterface $productRepository,
    ) { }

    /**
     * @param ProductInterface $product
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function execute(ProductInterface $product): void
    {
        $attributesToQuestion = $this->getAttributesForQuestion($product);

        foreach (SEO::ALEKSEON_GPT_PRODUCTATTR_SEO as $key => $attributeCode) {
            $question = $this->config->getValue(
                SEO::ALEKSEON_MAP_GPT_PRODUCTATTR_TO_CONFIG_QUESTION[$attributeCode],
                $this->storeManager->getStore()->getId()
            );

            $response = $this->AIClient->getCompletions($question . ' ' . $attributesToQuestion);
            $gptText = $response->getChoiceText();

            if ($gptText) {
                $product->setCustomAttribute($attributeCode, trim($gptText));
                $this->productRepository->save($product);
            }
        }

    }

    /**
     * @param ProductInterface $product
     * @return string
     */
    public function getAttributesForQuestion(ProductInterface $product): ?string
    {
        return strip_tags($product->getCustomAttribute('description')?->getValue());
    }
}
