<?php

namespace Isswp101\Persimmon\Contracts;

use Isswp101\Persimmon\DTO\Id;
use Isswp101\Persimmon\DTO\Path;

interface PersistenceContract
{
    public function find(Path $path): array|null;

    public function save(Path $path, array $attributes): Id;

    public function delete(Path $path): void;
}
