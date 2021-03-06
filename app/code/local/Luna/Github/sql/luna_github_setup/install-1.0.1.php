<?php

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('luna_github/log_request'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
        ])->addColumn('method', Varien_Db_Ddl_Table::TYPE_VARCHAR, 10, [
            'nullable' => false
        ])->addColumn('params', Varien_Db_Ddl_Table::TYPE_VARCHAR, 500, [
            'nullable' => false
        ])->addColumn('endpoint', Varien_Db_Ddl_Table::TYPE_VARCHAR, 200, [
            'nullable' => false
        ])->addColumn('client', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100, [
            'nullable' => false
        ])->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
            'nullable' => false
        ]);

if (!$installer->getConnection()->isTableExists($table->getName())) {
    $installer->getConnection()->createTable($table);
}