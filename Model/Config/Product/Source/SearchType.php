<?php

namespace Alekseon\OpenAICatalog\Model\Config\Product\Source;

use Magento\Framework\Option\ArrayInterface;

class SearchType implements ArrayInterface
{
    const SEARCH_TYPE_MANUAL = 'manual';
    const SEARCH_TYPE_AUTOMATIC = 'automatic';
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::SEARCH_TYPE_MANUAL, 'label' => __('Manual')],
            ['value' => self::SEARCH_TYPE_AUTOMATIC, 'label' => __('Automatic')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::SEARCH_TYPE_MANUAL => __('Manual'),
            self::SEARCH_TYPE_AUTOMATIC => __('Automatic')
        ];
    }
}