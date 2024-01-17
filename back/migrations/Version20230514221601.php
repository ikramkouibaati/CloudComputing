<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514221601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id_commande INT AUTO_INCREMENT NOT NULL, id_reduction INT NULL, id_utilisateur INT NOT NULL, date_commande DATE NOT NULL, statut VARCHAR(255) NOT NULL, prix_total DOUBLE PRECISION NOT NULL, INDEX IDX_6EEAA67D31D2E84F (id_reduction), INDEX IDX_6EEAA67D50EAE44 (id_utilisateur), PRIMARY KEY(id_commande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_adresse (id_commande INT NOT NULL, id_adresse INT NOT NULL, INDEX IDX_35E47AB63E314AE8 (id_commande), INDEX IDX_35E47AB61DC2A166 (id_adresse), PRIMARY KEY(id_commande, id_adresse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D31D2E84F FOREIGN KEY (id_reduction) REFERENCES reduction (id_reduction)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE commande_adresse ADD CONSTRAINT FK_35E47AB63E314AE8 FOREIGN KEY (id_commande) REFERENCES commande (id_commande)');
        $this->addSql('ALTER TABLE commande_adresse ADD CONSTRAINT FK_35E47AB61DC2A166 FOREIGN KEY (id_adresse) REFERENCES adresse (id_adresse)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D31D2E84F');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D50EAE44');
        $this->addSql('ALTER TABLE commande_adresse DROP FOREIGN KEY FK_35E47AB63E314AE8');
        $this->addSql('ALTER TABLE commande_adresse DROP FOREIGN KEY FK_35E47AB61DC2A166');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_adresse');
    }
}
