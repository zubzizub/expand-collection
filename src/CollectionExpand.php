<?php

namespace App;

use SplObjectStorage;

class CollectionExpand extends SplObjectStorage
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var CollectionExpand[]
     */
    public array $expands = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function has(string $expand): bool
    {
        return isset($this->expands[$expand]);
    }

    public function getByName(string $expand): ?self
    {
        return !empty($this->expands[$expand]) ? $this->expands[$expand] : null;
    }

    public function add(CollectionExpand $children): void
    {
        $this->expands[$children->getName()] = $children;
        $this->attach($children);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
