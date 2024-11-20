<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120011648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_has_ingredient (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, ingredient_id INT NOT NULL, ingredient_group_id INT DEFAULT NULL, unit_id INT DEFAULT NULL, quality DOUBLE PRECISION NOT NULL, is_optional TINYINT(1) NOT NULL, INDEX IDX_FF7A137059D8A214 (recipe_id), INDEX IDX_FF7A1370933FE08C (ingredient_id), INDEX IDX_FF7A13708C5289C9 (ingredient_group_id), INDEX IDX_FF7A1370F8BD700D (unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe_has_ingredient ADD CONSTRAINT FK_FF7A137059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipe_has_ingredient ADD CONSTRAINT FK_FF7A1370933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE recipe_has_ingredient ADD CONSTRAINT FK_FF7A13708C5289C9 FOREIGN KEY (ingredient_group_id) REFERENCES ingredient_group (id)');
        $this->addSql('ALTER TABLE recipe_has_ingredient ADD CONSTRAINT FK_FF7A1370F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_has_ingredient DROP FOREIGN KEY FK_FF7A137059D8A214');
        $this->addSql('ALTER TABLE recipe_has_ingredient DROP FOREIGN KEY FK_FF7A1370933FE08C');
        $this->addSql('ALTER TABLE recipe_has_ingredient DROP FOREIGN KEY FK_FF7A13708C5289C9');
        $this->addSql('ALTER TABLE recipe_has_ingredient DROP FOREIGN KEY FK_FF7A1370F8BD700D');
        $this->addSql('DROP TABLE recipe_has_ingredient');
    }
}
