<?php

namespace Isswp101\Persimmon\Tests;

use Isswp101\Persimmon\Tests\Models\Product;
use PHPUnit\Framework\TestCase;

function dd($value): void
{
    print_r($value);
    exit();
}

class BaseTest extends TestCase
{
    public function testTrue(): void
    {
        $product = Product::find(1);

        dd($product->toArray());

        $this->assertTrue(true);
    }
}
