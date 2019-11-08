<?php

namespace Third\Task\Model;

use Third\Task\Api\Data;
use Third\Task\Api\FaqsRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Third\Task\Model\ResourceModel\Faqs as ResourceFaqs;
use Third\Task\Model\ResourceModel\Faqs\CollectionFactory as FaqsCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class FaqsRepository implements FaqsRepositoryInterface
{
    protected $resource;

    protected $faqsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataFaqsFactory;

    private $storeManager;

    public function __construct(
        ResourceFaqs $resource,
        FaqsFactory $faqsFactory,
        Data\FaqsInterfaceFactory $dataFaqsFactory,
        DataObjectHelper $dataObjectHelper,
		DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
		$this->faqsFactory = $faqsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataFaqsFactory = $dataFaqsFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    public function save(\Third\Task\Api\Data\FaqsInterface $faqs)
    {
        if ($faqs->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $faqs->setStoreId($storeId);
        }
        try {
            $this->resource->save($faqs);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the faqs: %1', $exception->getMessage()),
                $exception
            );
        }
        return $faqs;
    }

    public function getById($Id)
    {
		$faqs = $this->faqsFactory->create();
        $faqs->load($Id);
        if (!$faqs->getId()) {
            throw new NoSuchEntityException(__('Faqs with id "%1" does not exist.', $Id));
        }
        return $faqs;
    }
	
    public function delete(\Third\Task\Api\Data\FaqsInterface $faqs)
    {
        try {
            $this->resource->delete($faqs);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the faqs: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($Id)
    {
        return $this->delete($this->getById($Id));
    }
}
