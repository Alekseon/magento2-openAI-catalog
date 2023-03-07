<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\OpenAICatalog\Model\Entity\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\Boolean as MageBoolean;

class Boolean extends MageBoolean
{
    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['label' => __('No'), 'value' => self::VALUE_NO],
                ['label' => __('Yes'), 'value' => self::VALUE_YES],
            ];
        }
        return $this->_options;
    }
}
