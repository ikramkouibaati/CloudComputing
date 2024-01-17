<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230521200412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asso_commande_produit (id_produit INT NOT NULL, id_commande INT NOT NULL, quantite INT NOT NULL, INDEX IDX_A88069E7F7384557 (id_produit), INDEX IDX_A88069E73E314AE8 (id_commande), PRIMARY KEY(id_produit, id_commande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE asso_commande_produit ADD CONSTRAINT FK_A88069E7F7384557 FOREIGN KEY (id_produit) REFERENCES produit (id_produit)');
        $this->addSql('ALTER TABLE asso_commande_produit ADD CONSTRAINT FK_A88069E73E314AE8 FOREIGN KEY (id_commande) REFERENCES commande (id_commande)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asso_commande_produit DROP FOREIGN KEY FK_A88069E7F7384557');
        $this->addSql('ALTER TABLE asso_commande_produit DROP FOREIGN KEY FK_A88069E73E314AE8');
        $this->addSql('DROP TABLE asso_commande_produit');
    }
}
