<?php
/*
 * This class is where the actual mail sending should happen. For the sake of this demo, the emails are simply being
 * output to the browser instead.
 */

namespace Kyriakos\MailPoetTask;

use Kyriakos\MailPoetTask\Newsletters\Newsletter;

class MailTransport
{

    /**
     * @param Newsletter $newsletter
     * @param $subscriber
     * @return bool
     */
    function sendEmail($newsletter, $subscriber) {
        /*
         * In a real world scenario this would add the email to be sent in a queue and not return a result immediately
         * but for the sake of simplicity at this point it just returns true that the message was sent out successfully.
         */

        include __DIR__.'/../templates/sent-email.php';
        return true;
    }
}