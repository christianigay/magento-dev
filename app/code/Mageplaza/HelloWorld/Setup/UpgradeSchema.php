<?php
namespace Mageplaza\HelloWorld\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
		$installer = $setup;

		$installer->startSetup();

		if(version_compare($context->getVersion(), '1.3.0', '<')) {
			$installer->getConnection()->addColumn(
				$installer->getTable( 'mageplaza_helloworld_post' ),
				'price',
				[
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
					'nullable' => true,
					'length' => '12,4',
					'comment' => 'price',
					'after' => 'status'
				]
			);
		}

		$installer->endSetup();
	}
}