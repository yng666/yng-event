<?php

namespace Yng\Event;

use Yng\Event\Contracts\EventListenerInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

class ListenerProvider implements ListenerProviderInterface
{
    /**
     * @var array
     */
    protected array $listeners = [];

    /**
     * 处理监听器和事件
     *
     * ListenerProvider constructor.
     * @param EventListenerInterface ...$listeners
     */
    public function __construct(EventListenerInterface ...$listeners)
    {
        foreach ($listeners as $listener) {
            $this->listen($listener);
        }
    }

    /**
     * 注册单个事件监听
     *
     * @param EventListenerInterface $listener
     */
    public function listen(EventListenerInterface $listener)
    {
        foreach ($listener->listen() as $event) {
            $this->listeners[$event][] = $listener;
        }
    }

    /**
     * 获取监听器
     *
     * @param object $event
     *
     * @return iterable
     */
    public function getListenersForEvent(object $event): iterable
    {
        return $this->listeners[get_class($event)] ?? [];
    }
}
