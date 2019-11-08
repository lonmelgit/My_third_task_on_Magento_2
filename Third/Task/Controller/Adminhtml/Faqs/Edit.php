<?php

namespace Third\Task\Controller\Adminhtml\Faqs;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
	/**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Third_Task::save');
	}

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Allnews
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Allnews $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Third_Task::task_faqs')
            ->addBreadcrumb(__('Faqs'), __('Faqs'))
            ->addBreadcrumb(__('Manage All Faqs'), __('Manage All Faqs'));
        return $resultPage;
    }

    /**
     * Edit Allnews
     *
     * @return \Magento\Backend\Model\View\Result\Allnews|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create(\Third\Task\Model\Faqs::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This faqs no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('task_faqs', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Allnews $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Faqs') : __('Add Faqs'),
            $id ? __('Edit Faqs') : __('Add Faqs')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Faqs'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('Add Faqs'));

        return $resultPage;
    }
}
