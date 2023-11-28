<?php

use Core\Domain\Shared\Event\EventDispatcher;
use Core\Domain\Shared\Event\EventHandlerInterface;
use Core\Domain\Shared\Event\EventInterface;
use Tests\Unit\Mocks\Event\EventMock;

describe('Event Dispatcher', function () {
    it('should register an event handler', function () {
        $eventDispatcher = new EventDispatcher();
        $eventHandler = spy(EventHandlerInterface::class);
        $eventDispatcher->register(eventName: EventInterface::class, eventHandler: $eventHandler);

        expect($eventDispatcher->getEventHandlers()[EventInterface::class])->toHaveCount(1);
        expect($eventDispatcher->getEventHandlers()[EventInterface::class][0])->toEqual($eventHandler);
    });

    it('should unregister an event handler', function () {
        $eventDispatcher = new EventDispatcher();
        $eventHandler = spy(EventHandlerInterface::class);

        $eventDispatcher->register(eventName: EventInterface::class, eventHandler: $eventHandler);
        expect($eventDispatcher->getEventHandlers()[EventInterface::class])->toHaveCount(1);

        $eventDispatcher->unregister(eventName: EventInterface::class, eventHandler: $eventHandler);

        expect($eventDispatcher->getEventHandlers()[EventInterface::class])->toHaveCount(0);
    });

    it('should unregister all event handler', function () {
        $eventDispatcher = new EventDispatcher();
        $eventHandler = spy(EventHandlerInterface::class);

        $eventDispatcher->register(eventName: EventInterface::class, eventHandler: $eventHandler);
        expect($eventDispatcher->getEventHandlers()[EventInterface::class])->toHaveCount(1);

        $eventDispatcher->unregisterAll();

        expect($eventDispatcher->getEventHandlers())->toBeEmpty();
    });

    it('should notify all event handlers', function () {
        $eventDispatcher = new EventDispatcher();
        $eventHandler = spy(EventHandlerInterface::class);

        $eventDispatcher->register(eventName: EventMock::class, eventHandler: $eventHandler);
        expect($eventDispatcher->getEventHandlers()[EventMock::class])->toHaveCount(1);

        $event = new EventMock();

        $eventDispatcher->notify(event: $event);

        $eventHandler->shouldHaveReceived('handle')->once();
    });
});