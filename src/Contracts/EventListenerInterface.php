<?php

namespace Yng\Event\Contracts;

interface EventListenerInterface
{
    public function listen(): array;

    public function process(object $event): void;
}