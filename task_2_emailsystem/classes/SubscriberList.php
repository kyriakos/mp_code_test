<?php

namespace Kyriakos\MailPoetTask;


use Kyriakos\MailPoetTask\Dispatchers\SingleSubscriberDispatcher;
use Kyriakos\MailPoetTask\Newsletters\WelcomeNewsletter;

/**
 * Class SubscriberList
 * A list of subscribers with utility methods to manipulate the list. Is also an Interator for easier sequential access
 * to its contents.
 * @package Kyriakos\MailPoetTask
 */
class SubscriberList implements \Iterator, \Countable
{

    /**
     * @var Subscriber[]
     */
    private $subscribers;

    /**
     * @var int
     */
    private $index;

    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }


    /**
     * Indicates if new subscribers to this list should be sent a welcome newsletter.
     * @var bool
     */
    private $mustWelcome;

    /**
     * SubscriberList constructor.
     * @param string $name
     */
    public function __construct($name) {
        $this->subscribers = [];
        $this->index = 0;
        $this->name = $name;
    }

    /**
     * Changes the status flag indicating if newly added subscribers should receive a welcome email.
     * @param $status
     */
    public function setWelcome($status) {
        $this->mustWelcome = $status;
    }

    public function addSubscriber($subscriber) {
        $this->subscribers[] = $subscriber;

        if ($this->mustWelcome) {
            $this->welcome($subscriber);
        }
    }

    /**
     * @param  Subscriber $subscriber
     * @return bool
     */
    public function containsSubscriber($subscriber) {
        return ($this->getKeyByEmail($subscriber->getEmail()) !== false);
    }


    private function getKeyByEmail($email) {
        foreach ($this->subscribers as $k => $subscriber) {
            if ($subscriber->getEmail() == $email) {
                return $k;
            }
        }
        return false;
    }

    /**
     * @param Subscriber $subscriberToRemove
     * @return bool
     */
    public function removeSubscriber($subscriberToRemove) {
        $key = $this->getKeyByEmail($subscriberToRemove->getEmail());

        if ($key !== false) {
            unset ($this->subscribers[$key]);
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return int
     */
    public function count() {
        return count($this->subscribers);
    }

    /**
     * @return Subscriber
     */
    public function current() {
        return $this->subscribers[$this->index];
    }


    public function next() {
        $this->index++;
    }

    /**
     * @return int
     */
    public function key() {
        return $this->index;
    }

    /**
     * @return bool
     */
    public function valid() {
        return isset($this->subscribers[$this->index]);
    }

    public function rewind() {
        $this->index = 0;
    }

    /**
     * @param Subscriber $subscriber
     * @return DispatchResult
     */
    private function welcome($subscriber) {

        $dispatcher = new SingleSubscriberDispatcher($subscriber);
        $newsletter = new WelcomeNewsletter($dispatcher, $this->name);

        return $newsletter->send();
    }
}