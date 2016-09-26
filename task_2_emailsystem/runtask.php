<?php
/*
 * This is a script to run the scenario required by the MailPoet task. In a real-life email system the data would be
 * loaded from the database instead and the user would be initiating the process from the system's UI. For the sake of
 * simplicity and since this was a task to demonstrate OO design I left out any database / persistence functionality.
 */
include "vendor/autoload.php";

use Kyriakos\MailPoetTask\Dispatchers\MultiListDispatcher;
use Kyriakos\MailPoetTask\Newsletters\NotificationNewsletter;
use Kyriakos\MailPoetTask\Subscriber;
use Kyriakos\MailPoetTask\SubscriberList;

$subscriber1 = new Subscriber('Jack', 'jack@example.org');
$subscriber2 = new Subscriber('John', 'john@example.org');
$subscriber3 = new Subscriber('Jane', 'jane@example.org');
$subscriber4 = new Subscriber('Jake', 'jake@example.org');

$list1 = new SubscriberList('First List');
$list1->addSubscriber($subscriber1);
$list1->addSubscriber($subscriber2);

$list2 = new SubscriberList('Second List');
$list2->addSubscriber($subscriber3);
$list2->addSubscriber($subscriber4);

$newsletter = new NotificationNewsletter(new MultiListDispatcher([$list1, $list2]));

$newsletter->setSubject("Good Morning");
$newsletter->setBody("Good morning and have a nice day! \n- Jill");

$newsletter->send();
