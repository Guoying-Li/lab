<?php
namespace App\Tests\Integration;

use App\Entity\Objet;
use App\Entity\Categorie;
use App\Entity\Modalite;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ObjetIntegrationTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    public function testPersistObjetWithRelations(): void
    {
        // Création des dépendances (catégorie, modalité, utilisateur)
        $categorie = new Categorie();
        $categorie->setNom('Catégorie Test');

        $modalite = new Modalite();
        $modalite->setNom('Modalité Test');

        $user = new User();
        $user->setEmail('integration@test.com');
        $user->setPassword('fake-password');
        $user->setRoles(['ROLE_USER']);

        $objet = new Objet();
        $objet->setTitre('Objet Intégré');
        $objet->setDescription('Un objet de test pour l’intégration.');
        $objet->addCategorie($categorie);
        $objet->setModalite($modalite);
        $objet->setUser($user);

        // Persistance
        $this->entityManager->persist($categorie);
        $this->entityManager->persist($modalite);
        $this->entityManager->persist($user);
        $this->entityManager->persist($objet);
        $this->entityManager->flush();

        // Vérifications
        $repo = $this->entityManager->getRepository(Objet::class);
        $savedObjet = $repo->findOneBy(['titre' => 'Objet Intégré']);

        $this->assertNotNull($savedObjet);
        $this->assertEquals('Un objet de test pour l’intégration.', $savedObjet->getDescription());
        $this->assertEquals('Catégorie Test', $savedObjet->getCategories()->getNom());
        $this->assertEquals('Modalité Test', $savedObjet->getModalite()->getNom());
        $this->assertEquals('integration@test.com', $savedObjet->getUser()->getEmail());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        // Nettoyage de l'EntityManager
        $this->entityManager->clear();
    }
}
