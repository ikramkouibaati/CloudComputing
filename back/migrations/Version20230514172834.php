<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514172834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id_image INT AUTO_INCREMENT NOT NULL, id_categorie INT DEFAULT NULL, id_produit INT DEFAULT NULL, lien_image VARCHAR(255) NOT NULL, INDEX IDX_C53D045FC9486A13 (id_categorie), INDEX IDX_C53D045FF7384557 (id_produit), PRIMARY KEY(id_image)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FC9486A13 FOREIGN KEY (id_categorie) REFERENCES categorie (id_categorie)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF7384557 FOREIGN KEY (id_produit) REFERENCES produit (id_produit)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FC9486A13');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FF7384557');
        $this->addSql('DROP TABLE image');
    }
}
