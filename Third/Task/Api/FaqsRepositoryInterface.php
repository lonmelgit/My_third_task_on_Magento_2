<?php

namespace Third\Task\Api;

interface FaqsRepositoryInterface
{
    public function save(\Third\Task\Api\Data\FaqsInterface $faqs);

    public function getById($id);

    public function delete(\Third\Task\Api\Data\FaqsInterface $faqs);

    public function deleteById($id);
}
