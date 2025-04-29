<?php

namespace App\Tests\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ObjetControllerTest extends WebTestCase
{
    public function testCreateObjet(): void
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $crawler = $client->request('GET', '/login');
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get(EntityManagerInterface::class);

        $form = $crawler->selectButton('Me connecter')->form([
            'email' => 'test@example.com',
            'password' => 'test1234',
        ]);

        $client->submit($form);


        // Accéder au formulaire de création
        $crawler = $client->request('GET', '/objet/create');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Ajouter')->form([
            'objet[titre]' => 'Objet Test',
            'objet[categories]' =>[10, 2, 3, 4, 5],
            'objet[modalite]' => 17,
            'objet[description]' => 'Ceci est une description de test.',
        ]);

        $client->submit($form);

        // Vérifier la redirection
        $this->assertResponseRedirects('/objet');
        $client->followRedirect();

        // Vérifier que l'objet est bien en base
        $objet = $entityManager->getRepository(\App\Entity\Objet::class)->findOneBy(['titre' => 'Objet Test']);
        $this->assertNotNull($objet);
        $this->assertEquals('Ceci est une description de test.', $objet->getDescription());
    }
}




