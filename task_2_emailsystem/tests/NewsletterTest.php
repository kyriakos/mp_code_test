<?php
use Kyriakos\MailPoetTask\Dispatchers\SingleSubscriberDispatcher;
use Kyriakos\MailPoetTask\DispatchResult;
use Kyriakos\MailPoetTask\Newsletters\NotificationNewsletter;
use Kyriakos\MailPoetTask\Subscriber;
use PHPUnit\Framework\TestCase;

class NewsletterTest extends TestCase
{

    /**
     * @var SingleSubscriberDispatcher
     */
    protected $dispatcher;

    protected function setUp() {
        $john = new Subscriber('John Doe', 'john@domain.ext');
        $this->dispatcher = new SingleSubscriberDispatcher($john);

    }

    public function testNewsletterConstructor() {
        $newsletter = new NotificationNewsletter($this->dispatcher);

        $this->assertTrue(
            $newsletter->getDispatcher() == $this->dispatcher);
    }

    public function testNewsletterGettersSetters() {
        $newsletter = new NotificationNewsletter($this->dispatcher);

        $actualBody = 'Hello World';
        $actualSubject = 'Hi';

        $newsletter->setBody($actualBody);
        $newsletter->setSubject($actualSubject);


        $this->assertEquals($actualBody, $newsletter->getBody());
        $this->assertEquals($actualSubject, $newsletter->getSubject());

    }

    public function testSend() {
        $newsletter = new NotificationNewsletter ($this->dispatcher);

        $newsletter->setBody('Hello World');
        $newsletter->setSubject('Hi');

        $result = $newsletter->send();

        $this->assertInstanceOf(DispatchResult::class, $result);

        $this->assertEquals(1, $result->totalSent);

    }

}