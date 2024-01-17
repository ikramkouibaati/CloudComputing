<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610162216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD id_mode_paiement INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DC93DFE0 FOREIGN KEY (id_mode_paiement) REFERENCES mode_paiement (id_mode_paiement)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DC93DFE0 ON commande (id_mode_paiement)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DC93DFE0');
        $this->addSql('DROP INDEX IDX_6EEAA67DC93DFE0 ON commande');
        $this->addSql('ALTER TABLE commande DROP id_mode_paiement');
    }
}
