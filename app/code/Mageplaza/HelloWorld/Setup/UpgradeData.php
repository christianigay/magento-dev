<?php

namespace Mageplaza\HelloWorld\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\Customer;

class UpgradeData implements UpgradeDataInterface
{
	private $eavSetupFactory;
	public $eavConfig;

	public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig)
	{
		$this->eavSetupFactory = $eavSetupFactory;
		$this->eavConfig = $eavConfig;
	}

	public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		$eavSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'sample_attribute',
			[
				'type' 				=> 'varchar',
				'label' 			=> 'Sample Attribute',
				'input' 			=> 'text',
				'required' 			=> false,
				'visible'			=> true,
				'user_defined'		=> true,
				'position'			=> 999,
				'system'			=> 0
			]
		);

		$sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'sample_attribute');

		$sampleAttribute->setData(
			'used_in_forms',
			['adminhtml_customer']
		);

		$sampleAttribute->save();
	}
}