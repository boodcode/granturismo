<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421132153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outil (id INT AUTO_INCREMENT NOT NULL, operation_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, visuel VARCHAR(255) DEFAULT NULL, INDEX IDX_22627A3E44AC3583 (operation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE outil ADD CONSTRAINT FK_22627A3E44AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outil DROP FOREIGN KEY FK_22627A3E44AC3583');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE outil');
    }
}
