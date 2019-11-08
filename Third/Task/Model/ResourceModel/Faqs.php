<?php
namespace Third\Task\Model\ResourceModel;
use Magento\Framework\Model\AbstractModel;
class Faqs extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
    $this->_init('third_task', 'id');   //here "third_task" is table name and "id" is the primary key of custom table
    }
}