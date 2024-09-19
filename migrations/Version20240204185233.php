<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240204185233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_objet (categorie_id INT NOT NULL, objet_id INT NOT NULL, INDEX IDX_B3B5A1E8BCF5E72D (categorie_id), INDEX IDX_B3B5A1E8F520CF5A (objet_id), PRIMARY KEY(categorie_id, objet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modalite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objet (id INT AUTO_INCREMENT NOT NULL, objet_user_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_46CD4C387C60C5AE (objet_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objet_categorie (objet_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_811B5753F520CF5A (objet_id), INDEX IDX_811B5753BCF5E72D (categorie_id), PRIMARY KEY(objet_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pret (id INT AUTO_INCREMENT NOT NULL, pret_modalite_id INT DEFAULT NULL, date_de_retour DATE NOT NULL, date_de_pret DATE NOT NULL, INDEX IDX_52ECE979FDFE700A (pret_modalite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, telephone VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_objet ADD CONSTRAINT FK_B3B5A1E8BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_objet ADD CONSTRAINT FK_B3B5A1E8F520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C387C60C5AE FOREIGN KEY (objet_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE objet_categorie ADD CONSTRAINT FK_811B5753F520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE objet_categorie ADD CONSTRAINT FK_811B5753BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pret ADD CONSTRAINT FK_52ECE979FDFE700A FOREIGN KEY (pret_modalite_id) REFERENCES modalite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_objet DROP FOREIGN KEY FK_B3B5A1E8BCF5E72D');
        $this->addSql('ALTER TABLE categorie_objet DROP FOREIGN KEY FK_B3B5A1E8F520CF5A');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C387C60C5AE');
        $this->addSql('ALTER TABLE objet_categorie DROP FOREIGN KEY FK_811B5753F520CF5A');
        $this->addSql('ALTER TABLE objet_categorie DROP FOREIGN KEY FK_811B5753BCF5E72D');
        $this->addSql('ALTER TABLE pret DROP FOREIGN KEY FK_52ECE979FDFE700A');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE categorie_objet');
        $this->addSql('DROP TABLE modalite');
        $this->addSql('DROP TABLE objet');
        $this->addSql('DROP TABLE objet_categorie');
        $this->addSql('DROP TABLE pret');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
