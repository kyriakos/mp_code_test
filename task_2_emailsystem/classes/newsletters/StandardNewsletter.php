<?php

namespace Kyriakos\MailPoetTask\Newsletters;


use Kyriakos\MailPoetTask\Dispatchers\MultiListDispatcher;
use Kyriakos\MailPoetTask\DispatchResult;

/**
 * Class StandardNewsletter
 * The StandardNewsletter can be sent to subscribers at a particular time. Its send() function implementation checks if
 * the send time passed before attempting to send emails out.
 * @package Kyriakos\MailPoetTask\Newsletters
 */
class StandardNewsletter extends Newsletter
{
    /**
     * @var \DateTime
     */
    private $sendDateTime;

    /**
     * StandardNewsletter constructor.
     * @param MultiListDispatcher $dispatcher
     * @param \DateTime $sendOn
     */
    public function __construct($dispatcher, $sendOn) {
        $this->sendDateTime = $sendOn;
        parent::__construct($dispatcher);
    }

    /**
     * @return DispatchResult
     */
    function send() {
        if ($this->shouldSend()) {
            return parent::send();
        } else {
            return new DispatchResult();
        }
    }

    /**
     * Checks if the newsletter should be sent out by comparing current date with the send date.
     * @return bool
     */
    public function shouldSend() {
        $now = new \DateTime();
        return ($now->getTimestamp() >= $this->sendDateTime->getTimestamp());
    }

}