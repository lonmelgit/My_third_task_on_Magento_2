<?php
namespace Third\Task\Controller\Adminhtml\Faqs;

use Magento\Backend\App\Action\Context;
use Third\Task\Api\FaqsRepositoryInterface as FaqsRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Third\Task\Api\Data\FaqsInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    protected $faqsRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    public function __construct(
        Context $context,
        FaqsRepository $faqsRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->faqsRepository = $faqsRepository;
        $this->jsonFactory = $jsonFactory;
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
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $faqsId) {
            $faqs = $this->faqsRepository->getById($faqsId);
            try {
                $faqsData = $postItems[$faqsId];
                $extendedFaqsData = $faqs->getData();
                $this->setFaqsData($faqs, $extendedFaqsData, $faqsData);
                $this->faqsRepository->save($faqs);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithFaqsId($faqs, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithFaqsId($faqs, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithFaqsId(
                    $faqs,
                    __('Something went wrong while saving the faqs.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    protected function getErrorWithFaqsId(FaqsInterface $faqs, $errorText)
    {
        return '[Faqs ID: ' . $faqs->getId() . '] ' . $errorText;
    }

    public function setFaqsData(\Third\Task\Model\Faqs $faqs, array $extendedFaqsData, array $faqsData)
    {
        $faqs->setData(array_merge($faqs->getData(), $extendedFaqsData, $faqsData));
        return $this;
    }
}
