<?php


namespace Kyriakos\MailPoetTask\Newsletters;


use Kyriakos\MailPoetTask\Dispatchers\Dispatcher;
use Kyriakos\MailPoetTask\DispatchResult;

/**
 * Class Newsletter
 * This abstract class represents an email newsletter. It is meant to be sub-classed by different types of newsletter
 * (Notification, Standard, Welcome and possibly others).
 * @package Kyriakos\MailPoetTask\Newsletters
 */
abstract class Newsletter
{

    /**
     * @var string
     */
    private $subject = '';
    /**
     * @var string
     */
    private $body = '';


    /**
     * Newsletter constructor.
     * @param $dispatcher
     */
    function __construct($dispatcher) {
        $this->setDispatcher($dispatcher);
    }


    /**
     * @return string
     */
    public function getSubject() {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject) {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body) {
        $this->body = $body;
    }

    /**
     * @return Dispatcher
     */
    public function getDispatcher() {
        return $this->dispatcher;
    }

    /**
     * @param Dispatcher $dispatcher
     */
    public function setDispatcher($dispatcher) {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @return DispatchResult
     */
    function send() {
        return $this->dispatcher->send($this);
    }
}