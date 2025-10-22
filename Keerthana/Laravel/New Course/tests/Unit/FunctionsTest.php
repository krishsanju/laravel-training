<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PhpUnitTesting\Functions;

final class FunctionsTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testaddPositiveintergers(): void
    {
        $this->assertSame(5, Functions::addIntegers(2,3));
    }

    public function testaddNegativeintergers(): void
    {
        $this->assertSame(-9, Functions::addIntegers(-2,-3));
    }
}
