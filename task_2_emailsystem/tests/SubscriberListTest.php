<?php
use Kyriakos\MailPoetTask\Subscriber;
use Kyriakos\MailPoetTask\SubscriberList;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: Kyriakos
 * Date: 21/09/2016
 * Time: 10:08
 */
class SubscriberListTest extends TestCase
{

    /**
     * @var SubscriberList
     */
    protected $list;

    protected function setUp() {
        $this->list = new SubscriberList('Test List');
    }

    public function testAddSubscriber() {
        $john = new Subscriber('John Doe', 'john@domain.ext');
        $jane = new Subscriber('Jane Doe', 'jane@domain.ext');
        $notAdded = new Subscriber('Not To Be Added', 'no@domain.ext');

        $this->list->addSubscriber($john);
        $this->assertEquals(1, $this->list->count());

        $this->list->addSubscriber($jane);
        $this->assertEquals(2, $this->list->count());

        $this->assertTrue($this->list->containsSubscriber($jane));
        $this->assertTrue($this->list->containsSubscriber($john));

        $this->assertTrue(!$this->list->containsSubscriber($notAdded));

    }

    public function testRemoveSubscriber() {
        $john = new Subscriber('John Doe', 'john@domain.ext');

        $this->list->addSubscriber($john);

        $this->assertTrue($this->list->removeSubscriber($john));
        $this->assertTrue($this->list->count() == 0);

        $this->assertTrue(!$this->list->removeSubscriber($john));
    }

    public function testIterator() {
        $john = new Subscriber('John Doe', 'john@domain.ext');
        $jane = new Subscriber('Jane Doe', 'jane@domain.ext');
        $myList = [$john, $jane];

        $this->list->addSubscriber($john);
        $this->list->addSubscriber($jane);

        $i = 0;
        foreach ($this->list as $subscriber) {
            $this->assertTrue($subscriber->getEmail() == $myList[$i]->getEmail());
            $i++;
        }
    }
}