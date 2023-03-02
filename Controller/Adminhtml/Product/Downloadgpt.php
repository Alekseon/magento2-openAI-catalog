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
use Magento\Framework\Message\ManagerInterface;

class Downloadgpt extends Action
{

    /**
     * @param Context $context
     * @param ProductRepository $productRepository
     * @param array $proccesors ,
     * @param ManagerInterface $manager
     */
    public function __construct(
        Context $context,
        protected readonly ProductRepository $productRepository,
        protected readonly ManagerInterface $messageManager,
        protected readonly array $proccesors
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $productId = (int)$this->getRequest()->getParam('product_id');
            $product = $this->productRepository->getById($productId);

            /** @var DownloadGptAttributesInteface $processor */
            foreach ($this->proccesors as $processor) {
                $processor->execute($product);
            }

            return $this->returnResult('catalog/*/edit', ['id' => $productId, '_current' => true]);
        } catch (\Exception $e) {
            $message = __("Some error so not save dates from OpenAI");
            $this->messageManager->addErrorMessage($message);

            return $this->returnResult('catalog/*/edit', ['id' => $productId, '_current' => true, 'error' => true]);
        }

    }

    private function returnResult(string $path = '', array $params = [])
    {
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath($path, $params);
    }
}
