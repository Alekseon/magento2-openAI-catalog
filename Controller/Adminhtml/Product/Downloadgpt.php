<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\OpenAICatalog\Controller\Adminhtml\Product;

use Alekseon\OpenAICatalog\Api\DownloadGptAttributesInteface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Serialize\Serializer\Json;

class Downloadgpt extends Action
{

    /**
     * @param Context $context
     * @param ProductRepository $productRepository,
     * @param array $proccesors ,
     */
    public function __construct(
        Context $context,
        protected readonly ProductRepository $productRepository,
        protected readonly array $proccesors,
        protected readonly Json $json,
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $productId = (int)$this->getRequest()->getParam('product_id');
            $product = $this->productRepository->getById($productId);

            $result = [];
            /** @var DownloadGptAttributesInteface $processor */
            foreach ($this->proccesors as $processor) {
                $result[$processor->getName()] = $processor->execute($product);
            }
            
            return $this->jsonResponse($result);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->jsonResponse(['error' => $e->getMessage()]);
        }

    }

    private function returnResult(string $path = '', array $params = [])
    {
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath($path, $params);
    }

    private function jsonResponse(array $result)
    {
        $this->getResponse()->representJson(
            $this->json->serialize($result)
        );
    }
}
