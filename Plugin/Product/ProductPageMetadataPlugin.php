<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\OpenAICatalog\Plugin\Product;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Page\Config;
use Magento\Catalog\Helper\Product\View;
use Magento\Framework\View\Result\Page as ResultPage;
use Magento\Catalog\Model\ProductRepository;

class ProductPageMetadataPlugin
{

    /**
     * ProductMetaTitlePlugin constructor.
     * @param Config $pageConfig
     * @param ProductRepository $productRepository
     */
    public function __construct(
        protected readonly Config $pageConfig,
        protected readonly ProductRepository $productRepository
    ){}

    /**
     * @param View $productViewHelper
     * @param $result
     * @param ResultPage $resultPage
     * @param int $productId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function afterPrepareAndRender(View $productViewHelper, $result, ResultPage $resultPage, int $productId)
    {
        $product = $this->productRepository->getById($productId);

        if (!$product || !$product->getGptIsUse()) {
            return $result;
        }

        $pageConfig = $resultPage->getConfig();

        $keyword = $product->getGptSeoKeywords();
        if ($keyword) {
            $pageConfig->setKeywords($keyword);
        }

        $description = $product->getGptDescription();
        if ($description) {
            $pageConfig->setDescription($description);
        }

        $shortDescription = $product->getGptShortDescription();
        if ($shortDescription) {
            $pageConfig->setMetadata('short-description', $shortDescription);
        }

        return $result;
    }
}
