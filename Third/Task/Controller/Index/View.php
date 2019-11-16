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

        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}