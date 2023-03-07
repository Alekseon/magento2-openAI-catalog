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
    final public const ALEKSEON_OPENAICATALOG_PATH_SEARCH_TYPE = 'chat_gpt/product_catalog_seo/search_type';
    final public const ALEKSEON_OPENAICATALOG_PATH_PRODUCT_ATTRIBUTES = 'chat_gpt/product_catalog_seo/product_attrubutes';
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
            self::ALEKSEON_OPENAICATALOG_PATH . $value,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
    
    public function getSearchType(?string $storeId)
    {
        return $this->scopeConfig->getValue(
            self::ALEKSEON_OPENAICATALOG_PATH_SEARCH_TYPE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getProductAttributes(?string $storeId): array
    {
        $productAttributes = $this->scopeConfig->getValue(
            self::ALEKSEON_OPENAICATALOG_PATH_PRODUCT_ATTRIBUTES,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return $productAttributes ? explode(',', $productAttributes) : [];
    }
}
