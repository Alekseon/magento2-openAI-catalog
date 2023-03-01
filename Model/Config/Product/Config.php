<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\OpenAICatalog\Model\Config\Product;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    final public const ALEKSEON_OPENAICATALOG_PATH = 'chat_gpt/product_catalog_seo/';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(protected readonly ScopeConfigInterface $scopeConfig){}

    /**
     * @param string $value
     * @param string|null $storeId
     * @return string
     */
    public function getValue(string $value, ?string $storeId): string
    {
        return $this->scopeConfig->getValue(
            self::ALEKSEON_OPENAICATALOG_PATH . $value, ScopeInterface::SCOPE_STORE,$storeId);
    }
}
