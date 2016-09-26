<?php

namespace Kyriakos\MailPoetTask\Dispatchers;


use Kyriakos\MailPoetTask\DispatchResult;
use Kyriakos\MailPoetTask\MailTransport;
use Kyriakos\MailPoetTask\Newsletters\Newsletter;
use Kyriakos\MailPoetTask\Subscriber;


/**
 * Class SingleSubscriberDispatcher
 * This Dispatcher strategy can send a newsletter to a single subscriber.
 * @package Kyriakos\MailPoetTask\Dispatchers
 */
class SingleSubscriberDispatcher implements Dispatcher
{
    /**
     * @var Subscriber
     */
    private $subscriber;

    /**
     * SingleSubscriberDispatcher constructor.
     * @param Subscriber $subscriber
     */
    public function __construct($subscriber) {
        $this->subscriber = $subscriber;
    }


    /**
     * @param Newsletter $newsletter
     * @return DispatchResult
     */
    function send($newsletter) {
        $result = new DispatchResult();

        $m = new MailTransport();
        $sendResult = $m->sendEmail($newsletter, $this->subscriber);

        if ($sendResult) {
            $result->success();
        } else {
            $result->failure();
        }
        return $result;
    }
}