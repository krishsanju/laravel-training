<?php

namespace App\PhpUnitTesting;

class Queue
{
    private array $items = [];

    public function push(mixed $item): void
    {
        $this->items[] = $item;
    }

    public function pop(): mixed
    {
        if (empty($this->items)) {
            throw new \UnderflowException('Queue is empty');
        }

        return array_shift($this->items);
    }

    public function getSize(): int
    {
        return count($this->items);
    }
}
