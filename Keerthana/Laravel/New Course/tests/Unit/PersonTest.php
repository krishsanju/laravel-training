<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\PhpUnitTesting\Person;



final class PersonTest extends TestCase
{
    public function testGetFullNameIsFirstNameAndSurname(): void
    {
        $person = new Person();

        $person->setFirstName('Teresa');
        $person->setSurname('Green');

        $this->assertSame('Teresa Green', $person->getFullName());
    }

    #[Test]
    public function fullNameIsfirstNameWhenNoSurname(): void
    {
        $person = new Person();

        $person->setFirstName('Keerthana');

        $this->assertSame('Keerthana', $person->getFullName());
    }
}
