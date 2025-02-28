<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    public function testBasicAssertion(): void
    {
        $this->assertTrue(true, 'Ce test est un simple test de validation.');
    }

    public function testAddition(): void
    {
        $result = 2 + 3;
        $this->assertEquals(5, $result, '2 + 3 devrait être égal à 5.');
    }
}

