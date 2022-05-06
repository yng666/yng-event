<?php

namespace Yng\Event;

use Psr\EventDispatcher\{EventDispatcherInterface, ListenerProviderInterface, StoppableEventInterface};

class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var ListenerProviderInterface
     */
    protected ListenerProviderInterface $listenerProvider;

    /**
     * @param ListenerProviderInterface $listenerProvider
     */
    public function __construct(ListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }

    /**
     * 调度事件
     *
     * @param object $event
     *
     * @return object
     */
    public function dispatch(object $event)
    {
        foreach ($this->listenerProvider->getListenersForEvent($event) as $listener) {
            $listener->process($event);
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }
        }
        return $event;
    }
}
