<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119234923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, step_id INT DEFAULT NULL, recipe_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT DEFAULT NULL, priority SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, size DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_C53D045F989D9B62 (slug), INDEX IDX_C53D045F73B21E9C (step_id), INDEX IDX_C53D045F59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F73B21E9C FOREIGN KEY (step_id) REFERENCES step (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F73B21E9C');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F59D8A214');
        $this->addSql('DROP TABLE image');
    }
}
