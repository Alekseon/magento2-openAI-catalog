<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\OpenAICatalog\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(private readonly EavSetupFactory $eavSetupFactory) {}

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context): void
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $this->addGPTDescription($eavSetup);
        $this->addGPTShortDescription($eavSetup);
        $this->addGPTSEOKeywords($eavSetup);
        $this->addGPTUseValues($eavSetup);
    }

    /**
     * @param EavSetup $eavSetup
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    private function addGPTDescription(EavSetup $eavSetup): void
    {
        $eavSetup->addAttribute(
            Product::ENTITY,
            'gpt_description',
            [
                'type' => 'text',
                'label' => 'GPT Description',
                'input' => 'text',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'group' => 'ChatGPT',
            ]
        );
    }

    /**
     * @param EavSetup $eavSetup
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    private function addGPTShortDescription(EavSetup $eavSetup): void
    {
        $eavSetup->addAttribute(
            Product::ENTITY,
            'gpt_short_description',
            [
                'type' => 'text',
                'label' => 'GPT Short Description',
                'input' => 'text',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'group' => 'ChatGPT',
            ]
        );
    }

    /**
     * @param EavSetup $eavSetup
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    private function addGPTUseValues(EavSetup $eavSetup): void
    {
        $eavSetup->addAttribute(
            Product::ENTITY,
            'gpt_is_use',
            [
                'type' => 'int',
                'label' => 'Use ChatGPT values',
                'input' => 'select',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'default' => 0,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'group' => 'ChatGPT',
                'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            ]
        );
    }

    /**
     * @param EavSetup $eavSetup
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    private function addGPTSEOKeywords(EavSetup $eavSetup): void
    {
        $eavSetup->addAttribute(
            Product::ENTITY,
            'gpt_seo_keywords',
            [
                'type' => 'text',
                'label' => 'GPT SEO Keywords',
                'input' => 'text',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'group' => 'ChatGPT',
            ]
        );
    }
}
