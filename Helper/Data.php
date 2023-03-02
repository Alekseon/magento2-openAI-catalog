<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\OpenAICatalog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Catalog\Api\ProductRepositoryInterface;
class Data extends AbstractHelper
{
    public function __construct(
        protected readonly ProductRepositoryInterface $productRepository,
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @throws NoSuchEntityException
     * @throws CouldNotSaveException
     * @throws StateException
     * @throws InputException
     */
    public function setProductAttributeValue(int $productId, string $attributeCode, string $attributeValue): void
    {
        $product = $this->productRepository->getById($productId);

        $product->setCustomAttribute($attributeCode, trim($attributeValue));
        $this->productRepository->save($product);
    }
}
