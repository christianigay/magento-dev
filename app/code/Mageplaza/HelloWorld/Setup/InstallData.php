<?php

namespace Mageplaza\HelloWorld\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\Customer;

class InstallData implements InstallDataInterface
{
	private $eavSetupFactory;
	public $eavConfig;

	public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig)
	{
		$this->eavSetupFactory = $eavSetupFactory;
		$this->eavConfig = $eavConfig;
	}

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
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
		// $data = [
		// 	'name'         => "How to Create SQL Setup Script in Magento 2",
		// 	'post_content' => "In this article, we will find out how to install and upgrade sql script for module in Magento 2. When you install or upgrade a module, you may need to change the database structure or add some new data for current table. To do this, Magento 2 provide you some classes which you can do all of them.",
		// 	'url_key'      => '/magento-2-module-development/magento-2-how-to-create-sql-setup-script.html',
		// 	'tags'         => 'magento 2,mageplaza helloworld',
		// 	'status'       => 1
		// ];
		// $post = $this->_postFactory->create();
		// $post->addData($data)->save();
	}
}