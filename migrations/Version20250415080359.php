<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250415080359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Supprimer la table produit_distributeur (si elle existe) et renommer la table distributeur_produit en produit_distributeur';
    }

    public function up(Schema $schema): void
    {
        // Supprimer la table produit_distributeur si elle existe
        $this->addSql('DROP TABLE IF EXISTS produit_distributeur');

        // Renommer la table distributeur_produit en produit_distributeur
        $this->addSql('RENAME TABLE distributeur_produit TO produit_distributeur');

        // Ajouter les contraintes de clé étrangère
        $this->addSql('ALTER TABLE produit_distributeur ADD CONSTRAINT FK_PRODUIT_DISTRIBUTEUR_PRODUIT FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_distributeur ADD CONSTRAINT FK_PRODUIT_DISTRIBUTEUR_DISTRIBUTEUR FOREIGN KEY (distributeur_id) REFERENCES distributeur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // Supprimer les contraintes de clé étrangère
        $this->addSql('ALTER TABLE produit_distributeur DROP FOREIGN KEY FK_PRODUIT_DISTRIBUTEUR_PRODUIT');
        $this->addSql('ALTER TABLE produit_distributeur DROP FOREIGN KEY FK_PRODUIT_DISTRIBUTEUR_DISTRIBUTEUR');

        // Renommer la table produit_distributeur en distributeur_produit
        $this->addSql('RENAME TABLE produit_distributeur TO distributeur_produit');
    }

}
