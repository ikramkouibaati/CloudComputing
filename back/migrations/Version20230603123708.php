<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230603123708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asso_materiel_produit (id_produit INT NOT NULL, id_materiel INT NOT NULL, INDEX IDX_E64A6092F7384557 (id_produit), INDEX IDX_E64A609248095C04 (id_materiel), PRIMARY KEY(id_produit, id_materiel)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE asso_materiel_produit ADD CONSTRAINT FK_E64A6092F7384557 FOREIGN KEY (id_produit) REFERENCES produit (id_produit)');
        $this->addSql('ALTER TABLE asso_materiel_produit ADD CONSTRAINT FK_E64A609248095C04 FOREIGN KEY (id_materiel) REFERENCES materiel (id_materiel)');
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816E173B1B8');
        $this->addSql('ALTER TABLE commande_adresse DROP FOREIGN KEY FK_35E47AB61DC2A166');
        $this->addSql('ALTER TABLE commande_adresse DROP FOREIGN KEY FK_35E47AB63E314AE8');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE commande_adresse');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DF6203804');
        $this->addSql('DROP INDEX IDX_6EEAA67DF6203804 ON commande');
        $this->addSql('ALTER TABLE commande CHANGE statut_id id_statut INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DC3534552 FOREIGN KEY (id_statut) REFERENCES statut (id_statut)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DC3534552 ON commande (id_statut)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id_adresse INT AUTO_INCREMENT NOT NULL, id_client INT NOT NULL, type_adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, rue VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, complement_adresse VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, region VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, code_postal INT NOT NULL, pays VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_C35F0816E173B1B8 (id_client), PRIMARY KEY(id_adresse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande_adresse (id_commande INT NOT NULL, id_adresse INT NOT NULL, INDEX IDX_35E47AB63E314AE8 (id_commande), INDEX IDX_35E47AB61DC2A166 (id_adresse), PRIMARY KEY(id_commande, id_adresse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816E173B1B8 FOREIGN KEY (id_client) REFERENCES utilisateur (id_utilisateur) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commande_adresse ADD CONSTRAINT FK_35E47AB61DC2A166 FOREIGN KEY (id_adresse) REFERENCES adresse (id_adresse) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commande_adresse ADD CONSTRAINT FK_35E47AB63E314AE8 FOREIGN KEY (id_commande) REFERENCES commande (id_commande) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE asso_materiel_produit DROP FOREIGN KEY FK_E64A6092F7384557');
        $this->addSql('ALTER TABLE asso_materiel_produit DROP FOREIGN KEY FK_E64A609248095C04');
        $this->addSql('DROP TABLE asso_materiel_produit');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DC3534552');
        $this->addSql('DROP INDEX IDX_6EEAA67DC3534552 ON commande');
        $this->addSql('ALTER TABLE commande CHANGE id_statut statut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF6203804 FOREIGN KEY (statut_id) REFERENCES statut (id_statut) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6EEAA67DF6203804 ON commande (statut_id)');
    }
}
