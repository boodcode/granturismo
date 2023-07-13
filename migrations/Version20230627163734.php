<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627163734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stat_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, operation_id INT DEFAULT NULL, outil_id INT DEFAULT NULL, type VARCHAR(16) NOT NULL, date DATETIME NOT NULL, INDEX IDX_ACDB2D1DA76ED395 (user_id), INDEX IDX_ACDB2D1D44AC3583 (operation_id), INDEX IDX_ACDB2D1D3ED89C80 (outil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stat_user ADD CONSTRAINT FK_ACDB2D1DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE stat_user ADD CONSTRAINT FK_ACDB2D1D44AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE stat_user ADD CONSTRAINT FK_ACDB2D1D3ED89C80 FOREIGN KEY (outil_id) REFERENCES outil (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stat_user DROP FOREIGN KEY FK_ACDB2D1DA76ED395');
        $this->addSql('ALTER TABLE stat_user DROP FOREIGN KEY FK_ACDB2D1D44AC3583');
        $this->addSql('ALTER TABLE stat_user DROP FOREIGN KEY FK_ACDB2D1D3ED89C80');
        $this->addSql('DROP TABLE stat_user');
    }
}
