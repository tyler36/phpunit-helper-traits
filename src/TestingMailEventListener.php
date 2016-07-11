<?php

namespace tyler36\phpunitTraits;

use Swift_Events_EventListener;
use Swift_Events_SendEvent;

/**
 * Class TestingMailEventListener
 */
class TestingMailEventListener implements Swift_Events_EventListener
{
    protected $test;


    /**
     * TestingMailEventListener constructor.
     *
     * @param $test
     */
    public function __construct($test)
    {
        $this->test = $test;
    }


    /**
     * Run before actually sending email
     *
     * @param Swift_Events_SendEvent $event
     */
    public function beforeSendPerformed(Swift_Events_SendEvent $event)
    {
        $this->test->addEmail($event->getMessage());
    }
}
