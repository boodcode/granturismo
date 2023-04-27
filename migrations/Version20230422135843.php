<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230422135843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE operation_marque (operation_id INT NOT NULL, marque_id INT NOT NULL, INDEX IDX_27EF28AC44AC3583 (operation_id), INDEX IDX_27EF28AC4827B9B2 (marque_id), PRIMARY KEY(operation_id, marque_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE operation_marque ADD CONSTRAINT FK_27EF28AC44AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE operation_marque ADD CONSTRAINT FK_27EF28AC4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marque_operation DROP FOREIGN KEY FK_61EB6BF144AC3583');
        $this->addSql('ALTER TABLE marque_operation DROP FOREIGN KEY FK_61EB6BF14827B9B2');
        $this->addSql('DROP TABLE marque_operation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE marque_operation (marque_id INT NOT NULL, operation_id INT NOT NULL, INDEX IDX_61EB6BF14827B9B2 (marque_id), INDEX IDX_61EB6BF144AC3583 (operation_id), PRIMARY KEY(marque_id, operation_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE marque_operation ADD CONSTRAINT FK_61EB6BF144AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marque_operation ADD CONSTRAINT FK_61EB6BF14827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE operation_marque DROP FOREIGN KEY FK_27EF28AC44AC3583');
        $this->addSql('ALTER TABLE operation_marque DROP FOREIGN KEY FK_27EF28AC4827B9B2');
        $this->addSql('DROP TABLE operation_marque');
    }
}
