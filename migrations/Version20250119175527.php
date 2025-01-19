<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250119175527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->getTable('admin');
        
        if (!$table->hasColumn('username')) {
            $this->addSql('ALTER TABLE admin ADD username VARCHAR(180) NOT NULL');
            $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76F85E0677 ON admin (username)');
        }
        
        if (!$table->hasColumn('created_at')) {
            $this->addSql('ALTER TABLE admin ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $table = $schema->getTable('admin');
        
        if ($table->hasColumn('username')) {
            $this->addSql('DROP INDEX UNIQ_880E0D76F85E0677');
            $this->addSql('ALTER TABLE admin DROP username');
        }
        
        if ($table->hasColumn('created_at')) {
            $this->addSql('ALTER TABLE admin DROP created_at');
        }
    }
}
