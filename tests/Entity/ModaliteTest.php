<?php
// tests/Entity/ModaliteTest.php

namespace App\Tests\Entity;

use App\Entity\Modalite;
use PHPUnit\Framework\TestCase;

class ModaliteTest extends TestCase
{
    public function testSetNomFormatsCorrectly(): void
    {
        $modalite = new Modalite();
        $modalite->setNom('   location   ');

        $this->assertEquals('Location', $modalite->getNom(), 'Le nom doit être formaté avec la première lettre en majuscule et sans espaces inutiles.');
    }
}
