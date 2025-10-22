<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PhpUnitTesting\Person;



final class PersonTest extends TestCase
{
    public function testGetFullNameIsFirstNameAndSurname(): void
    {
        $person = new Person('Teresa', 'Green');

        // $person->setFirstName('Teresa');
        // $person->setSurname('Green');

        $this->assertSame('TeresaGreen', $person->getFullName());
    }
}
