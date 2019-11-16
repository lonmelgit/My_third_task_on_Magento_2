<?php

namespace Third\Task\Block;

use Third\Task\Model\FaqsFactory;


class Block extends \Magento\Framework\View\Element\Template
{
    public function __construct(\Magento\Framework\View\Element\Template\Context $context, FaqsFactory $faqs)
    {
        $this->faqs = $faqs;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Page with questions'));

        return parent::_prepareLayout();
    }

    public function getQuestions()
    {
        $faqs = $this->faqs->create();
        $collection = $faqs->getCollection();
        return $collection;
    }

}