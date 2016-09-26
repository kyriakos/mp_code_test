<?php
use Kyriakos\MailPoetTask\Dispatchers\MultiListDispatcher;
use Kyriakos\MailPoetTask\Dispatchers\SingleSubscriberDispatcher;
use Kyriakos\MailPoetTask\DispatchResult;
use Kyriakos\MailPoetTask\Newsletters\NotificationNewsletter;
use Kyriakos\MailPoetTask\Subscriber;
use Kyriakos\MailPoetTask\SubscriberList;
use PHPUnit\Framework\TestCase;

class MultiListDispatcherTest extends TestCase
{

    /**
     * @var SingleSubscriberDispatcher
     */

    protected $subscribers = [];
    /**
     * @var SubscriberList
     */
    protected $firstList;
    /**
     * @var SubscriberList
     */
    protected $secondList;

    protected function setUp() {
        $this->subscribers['john'] = new Subscriber('John Doe', 'john@domain.ext');
        $this->subscribers['jane'] = new Subscriber('Jane Doe', 'jane@domain.ext');
        $this->subscribers['jack'] = new Subscriber('Jack Doe', 'jack@domain.ext');
        $this->subscribers['bob'] = new Subscriber('Bob Doe', 'bob@domain.ext');
        $this->subscribers['tony'] = new Subscriber('Tony Doe', 'tony@domain.ext');

        $this->firstList = new SubscriberList('First List');
        $this->secondList = new SubscriberList('Second List');


        $this->firstList->addSubscriber($this->subscribers['john']);
        $this->firstList->addSubscriber($this->subscribers['jane']);

        $this->secondList->addSubscriber($this->subscribers['jack']);
        $this->secondList->addSubscriber($this->subscribers['bob']);
        $this->secondList->addSubscriber($this->subscribers['tony']);

    }


    public function testDispatchedConstructor() {
        $dispatcher = new MultiListDispatcher([$this->firstList]);
        $this->assertEquals(1, count($dispatcher->getLists()));
        return $dispatcher;
    }

    /**
     * @depends testDispatchedConstructor
     * @param MultiListDispatcher $dispatcher
     */
    public function testAddList(MultiListDispatcher $dispatcher) {
        $dispatcher->addList($this->secondList);
        $this->assertEquals(2, count($dispatcher->getLists()));
    }


    /**
     * @depends testDispatchedConstructor
     * @param MultiListDispatcher $dispatcher
     */
    public function testSend(MultiListDispatcher $dispatcher) {

        $newsletter = new NotificationNewsletter($dispatcher);

        $newsletter->setBody('Hello World');
        $newsletter->setSubject('Hi');

        $result = $newsletter->send();


        $this->assertInstanceOf(DispatchResult::class, $result);

        $this->assertEquals(5, $result->totalSent);
    }


}