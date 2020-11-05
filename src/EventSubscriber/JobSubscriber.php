<?php

namespace App\EventSubscriber;

use App\Event\JobEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JobSubscriber implements EventSubscriberInterface
{
    public function onJobCreated($event)
    {
        $event->getJob();
    }

    public static function getSubscribedEvents()
    {
        return [
            JobEvent::NAME => 'onJobCreated',
        ];
    }
}
