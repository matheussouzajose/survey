<?php

namespace Core\Main\Adapters;

use Core\Domain\Shared\Event\EventDispatcher;

class EventServiceAdapter
{
    private static ?EventDispatcher $eventDispatcher = null;

    public static function provideEventDispatcher(): EventDispatcher {
        if (self::$eventDispatcher === null) {
            self::$eventDispatcher = new EventDispatcher();
        }
        return self::$eventDispatcher;
    }
}