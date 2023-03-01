<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\OpenAICatalog\Api;

use Magento\Catalog\Api\Data\ProductInterface;

interface DownloadGptAttributesInteface
{
    public function execute(ProductInterface $product): void;
}
