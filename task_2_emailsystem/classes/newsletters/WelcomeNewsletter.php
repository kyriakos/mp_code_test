<?php

namespace Kyriakos\MailPoetTask\Newsletters;


use Kyriakos\MailPoetTask\Dispatchers\Dispatcher;

/**
 * Class WelcomeNewsletter
 * WelcomeNewsletter type is a predefined newsletter which is sent to new list subscribers.
 * @package Kyriakos\MailPoetTask\Newsletters
 */
class WelcomeNewsletter extends Newsletter
{
    /**
     * WelcomeNewsletter constructor.
     * @param Dispatcher $dispatcher
     * @param string $name
     */
    public function __construct($dispatcher, $name) {
        $this->setSubject('Welcome to ' . $name);
        $this->setBody('You are receiving this email because you subscribed to ' . $name . ' list.');

        parent::__construct($dispatcher);
    }


}