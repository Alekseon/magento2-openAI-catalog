<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\OpenAICatalog\Block\Adminhtml\Product;

use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;

class DownloadGptAttributesButton extends Generic
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $url = $this->getUrl('*/*/downloadgpt', ['product_id' => $this->context->getRequestParam('id')]);

        return [
            'label' => __('DownLoad GPT'),
            'class' => 'action-secondary',
            'on_click' =>  'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $url . '\')',
            'sort_order' => 10
        ];
    }
}
