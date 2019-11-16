<?php

namespace Third\Task\Api\Data;

interface FaqsInterface
{
    const ID = 'id';
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const ADMIN_ID = 'admin_id';
    const CNT = 'cnt';


    public function getId();

    public function getQuestion();

    public function getAnswer();

    public function getAdminId();

    public function getCnt();


    public function setId($id);

    public function setQuestion($question);

    public function setAnswer($answer);

    public function setAdminId($admin_id);

    public function setCnt($cnt);

}
