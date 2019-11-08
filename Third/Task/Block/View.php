<?php

namespace Third\Task\Block;

use Magento\Framework\View\Element\Template\Context;
use Third\Task\Model\FaqsFactory;
use Magento\User\Model\UserFactory;
/**
 * Test List block
 */
class View extends \Magento\Framework\View\Element\Template
{
    protected $_userFactory;

    public function __construct(
        Context $context,
        FaqsFactory $faqs,
        UserFactory $userFactory
    ) {
        $this->_faqs = $faqs;
        $this->_userFactory = $userFactory;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Page with answers'));

        return parent::_prepareLayout();
    }

    public function getQuestion()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $id = $this->getRequest()->getParam('id');

        $_obj = $objectManager->create('Third\Task\Model\Faqs')->load($id);

        // update cnt
        if($_obj->getId()) {
            $_obj
                ->setCnt($_obj->getCnt() + 1)
                ->save();

            return $_obj;
        }


        return false;
    }

    public function getAuthorName($admin_id = null) {

        $user = $this->_userFactory->create()->load($admin_id);
        $name = $user->getName();
        return $name;
    }
}
