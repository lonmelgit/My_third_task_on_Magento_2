<?php
namespace Third\Task\Model\ResourceModel\Faqs;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected $_eventPrefix = 'task_faqs_collection';

    protected $_eventObject = 'faqs_collection';

    protected function _construct()
    {
        $this->_init(
            'Third\Task\Model\Faqs',
            'Third\Task\Model\ResourceModel\Faqs'
        );
    }
}