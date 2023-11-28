<?php

namespace Core\Domain\Account\Event\Handler;

use Core\Domain\Shared\Event\EventHandlerInterface;
use Core\Domain\Shared\Event\EventInterface;
use Core\Infrastructure\Persistence\MongoDb\Helpers\MongoHelperSingleton;

class SendEmailWhenAccountIsCreated implements EventHandlerInterface
{

    public function handle(EventInterface $event): void
    {
        //  Send Email
//        $collection = MongoHelperSingleton::getCollection('events');
//        $collection->insertOne([
//            'date_time_occurred' => $event->dateTimeOccurred()->format('Y-m-d H:i:s'),
//            'data' => [
//                'full_name' => $event->eventData()->fullname(),
//                'email' => $event->eventData()->email
//            ]
//        ]);
    }
}