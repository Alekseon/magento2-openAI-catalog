<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\OpenAICatalog\Model\MappingAttributes;

class SEO
{
    public const ALEKSEON_CONFIG_GPT_SEO_QUESTION = [
        'description' => 'gpt_description',
        'short_description' => 'gpt_short_description',
        'seo_keywords' => 'gpt_seo_keywords'
    ];

    public const ALEKSEON_GPT_PRODUCTATTR_SEO = [
        'description' => 'gpt_description',
        'short_description' => 'gpt_short_description',
        'seo_keywords' => 'gpt_seo_keywords'
    ];
    public const ALEKSEON_MAP_GPT_PRODUCTATTR_TO_CONFIG_QUESTION= [
        self::ALEKSEON_GPT_PRODUCTATTR_SEO['description'] => self::ALEKSEON_CONFIG_GPT_SEO_QUESTION['description'],
        self::ALEKSEON_GPT_PRODUCTATTR_SEO['short_description'] => self::ALEKSEON_CONFIG_GPT_SEO_QUESTION['short_description'],
        self::ALEKSEON_GPT_PRODUCTATTR_SEO['seo_keywords'] => self::ALEKSEON_CONFIG_GPT_SEO_QUESTION['seo_keywords']
    ];
}
