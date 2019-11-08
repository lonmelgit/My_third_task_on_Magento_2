<?php
namespace Third\Task\Setup;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;
class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface{
    public function install(SchemaSetupInterface $setup,ModuleContextInterface $context){
        $setup->startSetup();
        $conn = $setup->getConnection();
        $tableName = $setup->getTable('third_task');
        if($conn->isTableExists($tableName) != true){
            $table = $conn->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity'=>true,'unsigned'=>true,'nullable'=>false,'primary'=>true]
                )
                ->addColumn(
                    'question',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable'=>false,'default'=>'']
                )
                ->addColumn(
                    'answer',
                    Table::TYPE_TEXT,
                    '2M',
                    ['nullbale'=>false,'default'=>'']
                )
                ->addColumn(
                    'admin_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned'=>true,'nullable'=>false]
                )
                ->addColumn(
                    'cnt',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned'=>true,'default'=>'0']
                )
                ->addIndex(
                    $setup->getIdxName('third_task', ['question']),
                    ['question']
                )
                ->setOption('charset','utf8');
            $conn->createTable($table);
        }
        $setup->endSetup();
    }
}