<?php
namespace Kyriakos\MailPoetTask;


/**
 * Class Subscriber
 * Represents a newsletter subscriber. This would normally be persisted to the database.
 * @package Kyriakos\MailPoetTask
 */
class Subscriber
{

    /**
     * @var string
     */
    private $name = '';
    /**
     * @var string
     */
    private $email = '';

    /**
     * Subscriber constructor.
     * @param string $name
     * @param string $email
     */
    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }

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
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }


}