<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230520100721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asso_utilisateur_paiement (id_mode_paiement INT NOT NULL, id_utilisateur INT NOT NULL, INDEX IDX_5A952DCC93DFE0 (id_mode_paiement), INDEX IDX_5A952DC50EAE44 (id_utilisateur), PRIMARY KEY(id_mode_paiement, id_utilisateur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE asso_utilisateur_paiement ADD CONSTRAINT FK_5A952DCC93DFE0 FOREIGN KEY (id_mode_paiement) REFERENCES mode_paiement (id_mode_paiement)');
        $this->addSql('ALTER TABLE asso_utilisateur_paiement ADD CONSTRAINT FK_5A952DC50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asso_utilisateur_paiement DROP FOREIGN KEY FK_5A952DCC93DFE0');
        $this->addSql('ALTER TABLE asso_utilisateur_paiement DROP FOREIGN KEY FK_5A952DC50EAE44');
        $this->addSql('DROP TABLE asso_utilisateur_paiement');
    }
}
