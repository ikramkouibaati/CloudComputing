<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230625164030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asso_adresse_livraison_utilisateur (id_utilisateur INT NOT NULL, id_adresse_livraison INT NOT NULL, INDEX IDX_2E46F11550EAE44 (id_utilisateur), INDEX IDX_2E46F115FA3C61DE (id_adresse_livraison), PRIMARY KEY(id_utilisateur, id_adresse_livraison)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE asso_adresse_facturation_utilisateur (id_utilisateur INT NOT NULL, id_adresse_facturation INT NOT NULL, INDEX IDX_55D9AD6950EAE44 (id_utilisateur), INDEX IDX_55D9AD699F0F341E (id_adresse_facturation), PRIMARY KEY(id_utilisateur, id_adresse_facturation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE asso_adresse_livraison_utilisateur ADD CONSTRAINT FK_2E46F11550EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE asso_adresse_livraison_utilisateur ADD CONSTRAINT FK_2E46F115FA3C61DE FOREIGN KEY (id_adresse_livraison) REFERENCES adresse_livraison (id_adresse_livraison)');
        $this->addSql('ALTER TABLE asso_adresse_facturation_utilisateur ADD CONSTRAINT FK_55D9AD6950EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE asso_adresse_facturation_utilisateur ADD CONSTRAINT FK_55D9AD699F0F341E FOREIGN KEY (id_adresse_facturation) REFERENCES adresse_facturation (id_adresse_facturation)');
        $this->addSql('ALTER TABLE produit CHANGE date_ajout date_ajout DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asso_adresse_livraison_utilisateur DROP FOREIGN KEY FK_2E46F11550EAE44');
        $this->addSql('ALTER TABLE asso_adresse_livraison_utilisateur DROP FOREIGN KEY FK_2E46F115FA3C61DE');
        $this->addSql('ALTER TABLE asso_adresse_facturation_utilisateur DROP FOREIGN KEY FK_55D9AD6950EAE44');
        $this->addSql('ALTER TABLE asso_adresse_facturation_utilisateur DROP FOREIGN KEY FK_55D9AD699F0F341E');
        $this->addSql('DROP TABLE asso_adresse_livraison_utilisateur');
        $this->addSql('DROP TABLE asso_adresse_facturation_utilisateur');
        $this->addSql('ALTER TABLE produit CHANGE date_ajout date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
