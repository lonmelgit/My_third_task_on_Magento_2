<?php

namespace Third\Task\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    protected $date;
 
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        $this->date = $date;
    }
    
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $dataFaqsRows = [
            [
                'question' => 'New question',
                'answer' => 'New answer',
                'admin_id' => 1,
                'cnt' => '',

            ],
            [
                'question' => 'New question 2',
                'answer' => 'New answer 2',
                'admin_id' => 1,
                'cnt' => '',
            ]
        ];
        
        foreach($dataFaqsRows as $data) {
            $setup->getConnection()->insert($setup->getTable('third_task'), $data);
        }
    }
}

