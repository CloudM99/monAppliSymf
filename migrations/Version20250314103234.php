<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250314103234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE distributeur_produit (distributeur_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_B976901629EB7ACA (distributeur_id), INDEX IDX_B9769016F347EFB (produit_id), PRIMARY KEY(distributeur_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE distributeur_produit ADD CONSTRAINT FK_B976901629EB7ACA FOREIGN KEY (distributeur_id) REFERENCES distributeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE distributeur_produit ADD CONSTRAINT FK_B9769016F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_distributeur DROP FOREIGN KEY FK_E3D5370CF347EFB');
        $this->addSql('ALTER TABLE produit_distributeur DROP FOREIGN KEY FK_E3D5370C29EB7ACA');
        $this->addSql('DROP TABLE produit_distributeur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_distributeur (produit_id INT NOT NULL, distributeur_id INT NOT NULL, INDEX IDX_E3D5370CF347EFB (produit_id), INDEX IDX_E3D5370C29EB7ACA (distributeur_id), PRIMARY KEY(produit_id, distributeur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE produit_distributeur ADD CONSTRAINT FK_E3D5370CF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_distributeur ADD CONSTRAINT FK_E3D5370C29EB7ACA FOREIGN KEY (distributeur_id) REFERENCES distributeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE distributeur_produit DROP FOREIGN KEY FK_B976901629EB7ACA');
        $this->addSql('ALTER TABLE distributeur_produit DROP FOREIGN KEY FK_B9769016F347EFB');
        $this->addSql('DROP TABLE distributeur_produit');
    }
}
