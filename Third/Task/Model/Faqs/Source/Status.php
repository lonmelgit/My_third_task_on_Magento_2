<?php

namespace Third\Task\Model\Faqs\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    protected $allQuestions;

    public function __construct(\Third\Task\Model\Faqs $allQuestions)
    {
        $this->allQuestions = $allQuestions;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->allQuestions->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
