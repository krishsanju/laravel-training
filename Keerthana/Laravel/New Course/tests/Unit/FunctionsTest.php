<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\PhpUnitTesting\Functions;
use PHPUnit\Framework\Attributes\DataProvider;

final class FunctionsTest extends TestCase
{


    public static function additionProvider(): array
    {
        return [
            'two positive integers' => [2, 3, 5],
            'two negative integers' => [-2, -3, -5],
            'positive and negative integer' => [3, -2, 1],
            'adding zero' => [3, 0, 3]
        ];
    }

    #[DataProvider('additionProvider')]
    public function testAddIntegers(int $a, int $b, int $expected): void
    {
        $this->assertSame($expected, Functions::addIntegers($a, $b));
    }

    
    // public function testAddPositiveIntergers(): void
    // {
    //     $this->assertSame(5, Functions::addIntegers(2,3));
    // }

    // public function testAddNegativeIntergers(): void
    // {
    //     $this->assertSame(-5, Functions::addIntegers(-2,-3));
    // }

    public function testAddingIsCommutative(): void
    {
        $this->assertSame(Functions::addIntegers(3, 2), Functions::addIntegers(2, 3));
    }
}
