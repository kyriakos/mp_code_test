<?php
namespace Kyriakos\MailPoetTask;


/**
 * Class DispatchResult
 * A value object class that contains results of a newsletter dispatch.
 * @package Kyriakos\MailPoetTask
 */
class DispatchResult
{

    /**
     * @var int
     */
    public $totalSent;
    /**
     * @var int
     */
    public $successfullySent;
    /**
     * @var int
     */
    public $failed;

    /**
     * @var bool
     */
    public $sent = false;

    /**
     * Utility method to adjust the failed and totalSent values in a single call.
     */
    function failure() {
        $this->failed++;
        $this->totalSent++;
        $this->sent = true;
    }

    /**
     * Utility method to adjust the success and totalSent values in a single call.
     */
    function success() {
        $this->sent = true;
        $this->successfullySent++;
        $this->totalSent++;
    }
}