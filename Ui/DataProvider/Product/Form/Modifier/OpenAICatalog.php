<?php

namespace Alekseon\OpenAICatalog\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Tests\NamingConvention\true\resource;

class OpenAICatalog extends AbstractModifier
{
    public function __construct(
        protected readonly UrlInterface $urlBuilder,
        protected readonly LocatorInterface $locator
    ) {}

    public function modifyData(array $data)
    {
        return $data;
    }

    public function modifyMeta(array $meta)
    {

        $url = $this->urlBuilder->getUrl('catalog/product/downloadgpt', ['product_id' => $this->locator->getProduct()->getId()]);

        $meta['chatgpt']['children']['generate_by_GPT_AI'] =  [
                'arguments' => [
                    'data' => [
                        "config" => [
                            "formElement" => "container",
                            "componentType" => "container",
                            "breakLine" => false,
                            "label" => "Generate by GPT AI”",
                            "required" => "0",
                            "sortOrder" => 30,
                        ]

                    ]
                ],
                'children' => [
                    'generate_by_GPT_AI' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'formElement' => 'container',
                                    'componentType' => 'container',
                                    'component' => 'Alekseon_OpenAICatalog/js/components/getGPT',
                                    'urlForSendQuestionToGPT' => $url,
                                    'actions' => [
                                        [
                                            'targetName' => '${ $.name }',
                                            '__disableTmpl' => ['targetName' => false],
                                            'actionName' => 'sendQuestionToGPT'
                                        ]
                                    ],
                                    'title' => 'Generate by GPT AI',
                                    'provider' => null,
                                ]
                            ]
                        ]
                    ]
                ]
        ];

        return $meta;
    }
}