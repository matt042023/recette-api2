<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123232134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image CHANGE size size INT NOT NULL');
        $this->addSql('ALTER TABLE recipe_has_ingredient CHANGE ingredient_group_id ingredient_group_id INT NOT NULL, CHANGE unit_id unit_id INT NOT NULL');
        $this->addSql('ALTER TABLE source CHANGE size size INT NOT NULL');
        $this->addSql('ALTER TABLE step ADD name VARCHAR(128) NOT NULL, ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_43B9FE3C989D9B62 ON step (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image CHANGE size size DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE recipe_has_ingredient CHANGE ingredient_group_id ingredient_group_id INT DEFAULT NULL, CHANGE unit_id unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE source CHANGE size size DOUBLE PRECISION NOT NULL');
        $this->addSql('DROP INDEX UNIQ_43B9FE3C989D9B62 ON step');
        $this->addSql('ALTER TABLE step DROP name, DROP slug');
    }
}
