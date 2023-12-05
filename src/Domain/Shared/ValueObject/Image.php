<?php

namespace Core\Domain\Shared\ValueObject;

class Image
{
    public function __construct(
        protected string $path,
    ) {
    }

    public function path(): string
    {
        return $this->path;
    }
}