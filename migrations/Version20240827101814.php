<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827101814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de la colonne category_id à la table book et suppression de la table intermédiaire book_category';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE book ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD publication_year INT NOT NULL, ADD description VARCHAR(255) NOT NULL, ADD cover_image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_BOOK_CATEGORY FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_BOOK_CATEGORY ON book (category_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_BOOK_CATEGORY');
        $this->addSql('ALTER TABLE book DROP INDEX IDX_BOOK_CATEGORY');
        $this->addSql('ALTER TABLE book DROP category_id');
        $this->addSql('ALTER TABLE book DROP publication_year, DROP description, DROP cover_image');
    }
}
