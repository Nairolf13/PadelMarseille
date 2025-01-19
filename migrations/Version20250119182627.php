<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250119182627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->getTable('admin');
        
        try {
            $this->addSql('DROP INDEX uniq_identifier_email');
        } catch (\Exception $e) {
            // Ignore if index does not exist
        }
        
        if (!$table->hasColumn('is_verified')) {
            $this->addSql('ALTER TABLE admin ADD is_verified BOOLEAN NOT NULL');
        }
        
        // Restore email column if it was dropped
        if (!$table->hasColumn('email')) {
            $this->addSql('ALTER TABLE admin ADD email VARCHAR(255) DEFAULT \'default_\' || (random() * 10000)::text || \'@example.com\' NOT NULL');
            $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON admin (email)');
        }
        
        // Restore created_at column if it was dropped
        if (!$table->hasColumn('created_at')) {
            $this->addSql('ALTER TABLE admin ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW()');
        }
        
        // Directly execute rename without catching the error
        $this->addSql('ALTER INDEX IF EXISTS uniq_880e0d76f85e0677 RENAME TO UNIQ_IDENTIFIER_USERNAME');
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('admin');
        
        if ($table->hasColumn('is_verified')) {
            $this->addSql('ALTER TABLE admin DROP is_verified');
        }
        
        $this->addSql('COMMENT ON COLUMN admin.created_at IS \'(DC2Type:datetime_immutable)\'');
        
        try {
            $this->addSql('CREATE UNIQUE INDEX uniq_identifier_email ON admin (email)');
        } catch (\Exception $e) {
            // Ignore if index already exists
        }
        
        // Directly execute rename without catching the error
        $this->addSql('ALTER INDEX IF EXISTS uniq_identifier_username RENAME TO uniq_880e0d76f85e0677');
    }
}
