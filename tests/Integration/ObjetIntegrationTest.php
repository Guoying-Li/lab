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
        // Création des entités liées
        $categorie = new Categorie();
        $categorie->setNom('Catégorie Tes');
        $this->entityManager->persist($categorie);

        $modalite = new Modalite();
        $modalite->setNom('Modalité Test');
        $this->entityManager->persist($modalite);

        $user = new User();
        $user->setEmail('integration@test.com');
        $user->setPassword('fake-password');
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);

        // Flush des entités dépendantes pour s'assurer qu'elles sont bien insérées
        $this->entityManager->flush();

        // Création de l'objet principal
        $objet = new Objet();
        $objet->setTitre('Objet Intégré');
        $objet->setDescription('Un objet de test pour l’intégration.');
        $objet->addCategorie($categorie);
        $objet->setModalite($modalite);
        $objet->setUser($user);

        $this->entityManager->persist($objet);
        $this->entityManager->flush();

        // Vérification en base
        $repo = $this->entityManager->getRepository(Objet::class);
        $savedObjet = $repo->findOneBy(['titre' => 'Objet Intégré']);

        $this->assertNotNull($savedObjet);
        $this->assertEquals('Un objet de test pour l’intégration.', $savedObjet->getDescription());
        $this->assertEquals('Catégorie Test', $savedObjet->getCategories()->first()->getNom());
        $this->assertEquals('Modalité Test', $savedObjet->getModalite()->getNom());
        $this->assertEquals('integration@test.com', $savedObjet->getUser()->getEmail());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->clear();
    }
}

