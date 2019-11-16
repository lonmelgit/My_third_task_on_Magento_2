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
    private $userFactory;

    public function __construct(
        Context $context,
        FaqsFactory $faqs,
        UserFactory $userFactory
    )
    {
        $this->faqs = $faqs;
        $this->userFactory = $userFactory;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Page with answers'));

        return parent::_prepareLayout();
    }

    public function getQuestion()
    {
        $id = $this->getRequest()->getParam('id');

        $obj = $this->faqs->create()->load($id);

        // update cnt
        if ($obj->getId()) {
            $obj
                ->setCnt($obj->getCnt() + 1)
                ->save();

            return $obj;
        }


        return false;
    }

    public function getAuthorName($admin_id = null)
    {

        $user = $this->userFactory->create()->load($admin_id);
        $name = $user->getName();
        return $name;
    }
}
