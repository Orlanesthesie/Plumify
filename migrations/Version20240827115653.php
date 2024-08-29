<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827115653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD name VARCHAR(255) NOT NULL, DROP roman, DROP comic, DROP thriller, DROP history, DROP drama, DROP cook, DROP romance, DROP child, DROP religion, DROP sport, DROP scholar, DROP sf');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD roman TINYINT(1) NOT NULL, ADD comic TINYINT(1) NOT NULL, ADD thriller TINYINT(1) NOT NULL, ADD history TINYINT(1) NOT NULL, ADD drama TINYINT(1) NOT NULL, ADD cook TINYINT(1) NOT NULL, ADD romance TINYINT(1) NOT NULL, ADD child TINYINT(1) NOT NULL, ADD religion TINYINT(1) NOT NULL, ADD sport TINYINT(1) NOT NULL, ADD scholar TINYINT(1) NOT NULL, ADD sf TINYINT(1) NOT NULL, DROP name');
    }
}
