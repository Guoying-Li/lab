<?php
namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicTest extends WebTestCase
{
    public function testHomePageLoadsSuccessfully(): void
    {
        // Création du client pour simuler une requête HTTP
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // Vérifie que la réponse est un succès HTTP (200)
        $this->assertResponseIsSuccessful();

        // Vérifie que le client n'est pas null avant de faire des assertions dessus
        $this->assertNotNull($client, 'Le client n’a pas été correctement créé.');

        // Vérifie la présence d'un élément spécifique sur la page
        $this->assertSelectorTextContains('h1', 'Trouvez'); // Vérifie que le texte de l'élément h1 contient le mot "Trouvez"
    }
}

