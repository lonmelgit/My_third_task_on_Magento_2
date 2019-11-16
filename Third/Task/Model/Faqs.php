<?php

namespace Third\Task\Model;

use Third\Task\Api\Data\FaqsInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Faqs extends AbstractModel implements FaqsInterface, IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    const CACHE_TAG = 'third_task';

    //Unique identifier for use within caching
    protected $_cacheTag = self::CACHE_TAG;

    protected function _construct()
    {
        $this->_init('Third\Task\Model\ResourceModel\Faqs');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function getId()
    {
        return parent::getData(self::ID);
    }

    public function getQuestion()
    {
        return $this->getData(self::QUESTION);
    }

    public function getAnswer()
    {
        return $this->getData(self::ANSWER);
    }

    public function getAdminId()
    {
        return $this->getData(self::ADMIN_ID);
    }

    public function getCnt()
    {
        return $this->getData(self::CNT);
    }


    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function setQuestion($question)
    {
        return $this->setData(self::QUESTION, $question);
    }

    public function setAnswer($answer)
    {
        return $this->setData(self::ANSWER, $answer);
    }

    public function setAdminId($admin_id)
    {
        return $this->setData(self::ADMIN_ID, $admin_id);
    }

    public function setCnt($cnt)
    {
        return $this->setData(self::CNT, $cnt);
    }

}