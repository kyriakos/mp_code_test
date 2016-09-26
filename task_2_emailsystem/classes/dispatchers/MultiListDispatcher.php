<?php

namespace Kyriakos\MailPoetTask\Dispatchers;

use Kyriakos\MailPoetTask\DispatchResult;
use Kyriakos\MailPoetTask\MailTransport;
use Kyriakos\MailPoetTask\Newsletters\Newsletter;
use Kyriakos\MailPoetTask\SubscriberList;


/**
 * Class MultiListDispatcher
 * This Dispatcher strategy can send a newsletter to subscribers of one or more lists.
 * @package Kyriakos\MailPoetTask\Dispatchers
 */
class MultiListDispatcher implements Dispatcher
{

    /**
     * @var SubscriberList[]
     */
    private $lists = [];

    /**
     * MultiListDispatcher constructor.
     * @param SubscriberList[] $lists
     */
    public function __construct(array $lists) {
        $this->lists = $lists;
    }

    /**
     * Sends the provided newsletter to the lists and returns a DispatchResult object with the send results.
     * @param Newsletter $newsletter
     * @return DispatchResult
     */
    function send($newsletter) {
        $result = new DispatchResult();
        $transport = new MailTransport();

        foreach ($this->lists as $list) {
            foreach ($list as $subscriber) {
                if ($transport->sendEmail($newsletter, $subscriber)) {
                    $result->success();
                } else {
                    $result->failure();
                }
            }
        }

        return $result;
    }

    /**
     * @param SubscriberList $list
     */
    public function addList($list) {
        $this->lists[] = $list;
    }

    /**
     * @return SubscriberList[]
     */
    public function getLists() {
        return $this->lists;
    }


}