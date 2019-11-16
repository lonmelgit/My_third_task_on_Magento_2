<?php

namespace Third\Task\Block;

Class LinkFaqs extends \Magento\Framework\View\Element\Template
{
	protected $configProvider;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Third\Task\Model\ConfigProvider $configProvider
	){
		parent::__construct($context);
		$this->configProvider = $configProvider;
	}
	
	public function getNewsLink()
	{
		$faqsLink = $this->configProvider->getStorefrontConfig('faqs_link');
		
		return $faqsLink;
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
}