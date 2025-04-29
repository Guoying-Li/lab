<?php
// src/DataFixtures/TestUserFixtures.php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Modalite;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TestUserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setNom('Test');
        $user->setPrenom('Utilisateur');
        $user->setTelephone('+33600000000');
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setIsVerified(true); // Pour éviter les problèmes de sécurité
        $user->setPassword($this->hasher->hashPassword($user, 'test1234'));

        $manager->persist($user);
        // Catégorie
        $categorie = new Categorie();
        $categorie->setNom('Informatique');
        $manager->persist($categorie);

        // Modalité
        $modalite = new Modalite();
        $modalite->setNom('Renouvelable');
        $manager->persist($modalite);

        $manager->flush();

        // Références pour les tests
        $this->addReference('test_user', $user);
        $this->addReference('test_categorie', $categorie);
        $this->addReference('test_modalite', $modalite);
    }
}