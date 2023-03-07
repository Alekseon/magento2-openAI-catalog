<?php

namespace Alekseon\OpenAICatalog\Model\Config\Product\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory as AttributeCollectionFactory;

class ProductAttributes implements ArrayInterface
{
    /**
     * Options array
     *
     * @var array
     */
    protected $options;

    public function __construct(
        protected readonly AttributeCollectionFactory $collectionFactory
    ) {}

    /**
     * Return options array
     * 
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $productAttributesFactory = $this->collectionFactory->create();

            $productAttributes = $productAttributesFactory->addFieldToFilter(['backend_type'], ['text']);

            foreach ($productAttributes->getItems() as $attribute) {
                $this->options[] = [
                    'label' => $attribute->getFrontendLabel(),
                    'value' => $attribute->getAttributeCode()
                ];
            }

        }
  
        return $this->options;
    }
}