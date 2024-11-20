<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120001134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, tags_associes_id INT DEFAULT NULL, menu TINYINT(1) NOT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT DEFAULT NULL, priority SMALLINT NOT NULL, UNIQUE INDEX UNIQ_389B783989D9B62 (slug), INDEX IDX_389B783D4D403FD (tags_associes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_recipe (tag_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_33C9F81BBAD26311 (tag_id), INDEX IDX_33C9F81B59D8A214 (recipe_id), PRIMARY KEY(tag_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783D4D403FD FOREIGN KEY (tags_associes_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE tag_recipe ADD CONSTRAINT FK_33C9F81BBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_recipe ADD CONSTRAINT FK_33C9F81B59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783D4D403FD');
        $this->addSql('ALTER TABLE tag_recipe DROP FOREIGN KEY FK_33C9F81BBAD26311');
        $this->addSql('ALTER TABLE tag_recipe DROP FOREIGN KEY FK_33C9F81B59D8A214');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_recipe');
    }
}
