<?php
namespace Kyriakos\MailPoetTask\Dispatchers;
use Kyriakos\MailPoetTask\DispatchResult;
use Kyriakos\MailPoetTask\Newsletters\Newsletter;


/**
 * Interface Dispatcher
 * This interface defines the method send that needs to be implemented by Dispatcher classes. Essentially a Dispatcher
 * sends emails depending on its strategy (e.g. single email or send to multiple lists of subscribers) and returns a
 * DispatchResult
 * @package Kyriakos\MailPoetTask
 */
interface Dispatcher
{

    /**
     * @param Newsletter $newsletter
     * @return DispatchResult
     */
    public function send($newsletter);
}