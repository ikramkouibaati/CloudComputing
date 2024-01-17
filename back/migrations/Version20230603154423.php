<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230603154423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD id_adresse_facturation INT NOT NULL, ADD id_adresse_livraison INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D9F0F341E FOREIGN KEY (id_adresse_facturation) REFERENCES adresse_facturation (id_adresse_facturation)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFA3C61DE FOREIGN KEY (id_adresse_livraison) REFERENCES adresse_livraison (id_adresse_livraison)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D9F0F341E ON commande (id_adresse_facturation)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DFA3C61DE ON commande (id_adresse_livraison)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D9F0F341E');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFA3C61DE');
        $this->addSql('DROP INDEX IDX_6EEAA67D9F0F341E ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67DFA3C61DE ON commande');
        $this->addSql('ALTER TABLE commande DROP id_adresse_facturation, DROP id_adresse_livraison');
    }
}
