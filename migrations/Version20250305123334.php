<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250305123334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C38A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_46CD4C38A76ED395 ON objet (user_id)');
        $this->addSql('ALTER TABLE pret DROP FOREIGN KEY FK_52ECE979FDFE700A');
        $this->addSql('ALTER TABLE pret ADD user_id INT NOT NULL, ADD objet_id INT NOT NULL, CHANGE pret_modalite_id pret_modalite_id INT NOT NULL');
        $this->addSql('ALTER TABLE pret ADD CONSTRAINT FK_52ECE979A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pret ADD CONSTRAINT FK_52ECE979F520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pret ADD CONSTRAINT FK_52ECE979FDFE700A FOREIGN KEY (pret_modalite_id) REFERENCES modalite (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_52ECE979A76ED395 ON pret (user_id)');
        $this->addSql('CREATE INDEX IDX_52ECE979F520CF5A ON pret (objet_id)');
        $this->addSql('ALTER TABLE user ADD created_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', DROP date');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C38A76ED395');
        $this->addSql('DROP INDEX IDX_46CD4C38A76ED395 ON objet');
        $this->addSql('ALTER TABLE pret DROP FOREIGN KEY FK_52ECE979A76ED395');
        $this->addSql('ALTER TABLE pret DROP FOREIGN KEY FK_52ECE979F520CF5A');
        $this->addSql('ALTER TABLE pret DROP FOREIGN KEY FK_52ECE979FDFE700A');
        $this->addSql('DROP INDEX IDX_52ECE979A76ED395 ON pret');
        $this->addSql('DROP INDEX IDX_52ECE979F520CF5A ON pret');
        $this->addSql('ALTER TABLE pret DROP user_id, DROP objet_id, CHANGE pret_modalite_id pret_modalite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pret ADD CONSTRAINT FK_52ECE979FDFE700A FOREIGN KEY (pret_modalite_id) REFERENCES modalite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP created_at');
    }
}
