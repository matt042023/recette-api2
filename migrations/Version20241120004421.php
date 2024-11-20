<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120004421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783D4D403FD');
        $this->addSql('DROP INDEX IDX_389B783D4D403FD ON tag');
        $this->addSql('ALTER TABLE tag ADD parent_id INT NOT NULL, DROP tags_associes_id');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783727ACA70 FOREIGN KEY (parent_id) REFERENCES tag (id)');
        $this->addSql('CREATE INDEX IDX_389B783727ACA70 ON tag (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783727ACA70');
        $this->addSql('DROP INDEX IDX_389B783727ACA70 ON tag');
        $this->addSql('ALTER TABLE tag ADD tags_associes_id INT DEFAULT NULL, DROP parent_id');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783D4D403FD FOREIGN KEY (tags_associes_id) REFERENCES tag (id)');
        $this->addSql('CREATE INDEX IDX_389B783D4D403FD ON tag (tags_associes_id)');
    }
}
