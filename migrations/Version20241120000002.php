<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120000002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE source (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT DEFAULT NULL, size DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_5F8A7F73989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source_recipe (source_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_6C7794D1953C1C61 (source_id), INDEX IDX_6C7794D159D8A214 (recipe_id), PRIMARY KEY(source_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE source_recipe ADD CONSTRAINT FK_6C7794D1953C1C61 FOREIGN KEY (source_id) REFERENCES source (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE source_recipe ADD CONSTRAINT FK_6C7794D159D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE source_recipe DROP FOREIGN KEY FK_6C7794D1953C1C61');
        $this->addSql('ALTER TABLE source_recipe DROP FOREIGN KEY FK_6C7794D159D8A214');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP TABLE source_recipe');
    }
}
