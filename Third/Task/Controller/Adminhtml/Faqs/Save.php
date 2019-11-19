<?php

namespace Third\Task\Controller\Adminhtml\Faqs;

use Magento\Backend\App\Action;
use Third\Task\Model\Faqs;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Third\News\Model\AllfaqsFactory
     */
    private $faqsFactory;

    /**
     * @var \Third\News\Api\AllfaqsRepositoryInterface
     */
    private $faqsRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Third\News\Model\AllfaqsFactory $allfaqsFactory
     * @param \Third\News\Api\AllfaqsRepositoryInterface $allfaqsRepository
     */
    public function __construct(
        \Magento\Backend\Model\Auth\Session $authSession,
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Third\Task\Model\FaqsFactory $faqsFactory = null,
        \Third\Task\Api\FaqsRepositoryInterface $faqsRepository = null
    ) {
        $this->authSession = $authSession;
        $this->dataPersistor = $dataPersistor;
        $this->faqsFactory = $faqsFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Third\Task\Model\FaqsFactory::class);
        $this->faqsRepository = $faqsRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Third\Task\Api\FaqsRepositoryInterface::class);
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
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Faqs::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            /** @var \Third\Faqs\Model\Allfaqs $model */

            $adminId = $this->authSession->getUser()->getId();

            $data['admin_id'] = $adminId;

            $model = $this->faqsFactory->create();
            $model->setUserId($adminId);

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->faqsRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This faqs no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }


            $model->setData($data);

            $this->_eventManager->dispatch(
                'task_faqs_prepare_save',
                ['faqs' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->faqsRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the faqs.'));
                $this->dataPersistor->clear('task_faqs');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the faqs.'));
            }

            $this->dataPersistor->set('task_faqs', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
    public function getCurrentUser()
    {
        return $this->authSession->getUser()->getId();
    }

}
