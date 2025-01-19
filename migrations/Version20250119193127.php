<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250119193127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add email column to admin table with default value';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->getTable('admin');
        
        if (!$table->hasColumn('email')) {
            $this->addSql('ALTER TABLE admin ADD email VARCHAR(255) DEFAULT \'admin@padelmarseille.com\' NOT NULL');
            $this->addSql('UPDATE admin SET email = \'admin@padelmarseille.com\' WHERE email IS NULL');
            $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON admin (email)');
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $table = $schema->getTable('admin');
        
        if ($table->hasColumn('email')) {
            $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL');
            $this->addSql('ALTER TABLE admin DROP email');
        }
    }
}

        if ($table->hasColumn('email')) {
            $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL');
            $this->addSql('ALTER TABLE admin DROP email');
        }
    }
}
