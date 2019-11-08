<?php

namespace Third\Task\Controller\Index;

use Magento\Framework\App\Action\Context;


class View extends \Magento\Framework\App\Action\Action
{


    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);
    }

    public function execute()
    {

        /*
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $id = $this->getRequest()->getParam('id');

        $_obj = $objectManager->create('Third\Task\Model\Example')->load($id);


        $_obj
            ->setCnt($_obj->getCnt() + 1)
            ->save();

        //echo $_obj->getId();exit;
        */

        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}