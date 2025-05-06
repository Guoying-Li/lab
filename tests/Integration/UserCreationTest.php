<?php

namespace App\Tests\Integration;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreationTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);
    }

    public function testCreateAndPersistUser(): void
    {
    $user = new User();
    $user->setEmail('testuser@empruntheque.fr');
    $user->setRoles(['ROLE_USER']);

    // Ajout des champs obligatoires
    $user->setNom('Test');
    $user->setPrenom('User');
    $user->setIsVerified(true); // champ booléen non nullable

    // Hashage du mot de passe
    $hashedPassword = $this->passwordHasher->hashPassword($user, 'monSuperMotDePasse123');
    $user->setPassword($hashedPassword);

    $this->entityManager->persist($user);
    $this->entityManager->flush();

    // Vérification
    $savedUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'testuser@empruntheque.fr']);

    $this->assertNotNull($savedUser);
    $this->assertEquals('testuser@empruntheque.fr', $savedUser->getEmail());
    $this->assertContains('ROLE_USER', $savedUser->getRoles());
    $this->assertEquals('Test', $savedUser->getNom());
    $this->assertEquals('User', $savedUser->getPrenom());
    $this->assertTrue($savedUser->isVerified());
    }


    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->clear();
    }
}
 