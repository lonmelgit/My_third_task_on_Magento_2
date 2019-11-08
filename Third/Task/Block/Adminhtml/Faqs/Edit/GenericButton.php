<?php

namespace Third\Task\Block\Adminhtml\Faqs\Edit;

use Magento\Backend\Block\Widget\Context;
use Third\Task\Api\FaqsRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $faqsRepository;
    
    public function __construct(
        Context $context,
        FaqsRepositoryInterface $faqsRepository
    ) {
        $this->context = $context;
        $this->faqsRepository = $faqsRepository;
    }

    public function getId()
    {
        try {
            return $this->faqsRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        }
		catch (NoSuchEntityException $e) {
        
		}
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
