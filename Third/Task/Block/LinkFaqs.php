<?php

namespace Third\Task\Block;

Class LinkFaqs extends \Magento\Framework\View\Element\Template
{
	protected $dataHelper;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Third\Task\Helper\Data $dataHelper
	){
		parent::__construct($context);
		$this->dataHelper = $dataHelper;
	}
	
	public function getNewsLink()
	{
		$newsLink = $this->dataHelper->getStorefrontConfig('faqs_link');
		
		return $newsLink;
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
}