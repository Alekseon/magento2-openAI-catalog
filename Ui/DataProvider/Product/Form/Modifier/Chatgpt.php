<?php

namespace Alekseon\OpenAICatalog\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Framework\Phrase;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form\Fieldset;

class Chatgpt extends AbstractModifier
{
    public const GROUP_CHARGPT = 'chatgpt';

    public function __construct(readonly protected LocatorInterface $locator) {}
    public function modifyData(array $data)
    {
        return $data;
    }

    public function modifyMeta(array $meta)
    {
        if (!$this->locator->getProduct()->getId()) {
            return $meta;
        }


        return $meta;
    }


}
