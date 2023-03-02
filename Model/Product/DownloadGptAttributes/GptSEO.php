<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\OpenAICatalog\Model\Product\DownloadGptAttributes;

use Alekseon\OpenAIApiClient\Model\OpenAIClient;
use Alekseon\OpenAICatalog\Api\DownloadGptAttributesInteface;
use Alekseon\OpenAICatalog\Helper\Data;
use Alekseon\OpenAICatalog\Model\Config\Product\Config;
use Alekseon\OpenAICatalog\Model\MappingAttributes\SEO;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory as AttributeCollectionFactory;

class GptSEO implements DownloadGptAttributesInteface
{
    /**
     * @param OpenAIClient $AIClient
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     * @param AttributeCollectionFactory $collectionFactory
     * @param Data $data
     */
    public function __construct(
        protected readonly OpenAIClient $AIClient,
        protected readonly Config $config,
        protected readonly StoreManagerInterface $storeManager,
        protected readonly AttributeCollectionFactory $collectionFactory,
        protected readonly Data $data
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

        foreach (SEO::ALEKSEON_GPT_PRODUCTATTR_SEO as $key => $value) {
           $question = $this->config->getValue(
               SEO::ALEKSEON_MAP_GPT_PRODUCTATTR_TO_CONFIG_QUESTION[$value],
               $this->storeManager->getStore()->getId()
           );

           $response = $this->AIClient->getCompletions($question . ' ' . $attributesToQuestion);
           $gptText = $response->getChoiceText();

           if ($gptText) {
               $this->data->setProductAttributeValue($product->getId(), $value, $gptText);
           }
       }

    }

    /**
     * @param ProductInterface $product
     * @return string|null
     */
    public function getAttributesForQuestion(ProductInterface $product): ?string
    {
        return $product->getCustomAttribute('description')?->getValue();
    }
}
