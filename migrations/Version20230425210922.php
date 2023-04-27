<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425210922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outil DROP FOREIGN KEY FK_22627A3E84684DAF');
        $this->addSql('DROP TABLE filetype');
        $this->addSql('DROP INDEX IDX_22627A3E84684DAF ON outil');
        $this->addSql('ALTER TABLE outil DROP filetype_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE filetype (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, visuel VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE outil ADD filetype_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE outil ADD CONSTRAINT FK_22627A3E84684DAF FOREIGN KEY (filetype_id) REFERENCES filetype (id)');
        $this->addSql('CREATE INDEX IDX_22627A3E84684DAF ON outil (filetype_id)');
    }
}
