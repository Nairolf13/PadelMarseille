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
        $this->addSql('DROP INDEX uniq_identifier_email');
        $this->addSql('ALTER TABLE admin ADD is_verified BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE admin DROP email');
        $this->addSql('ALTER TABLE admin DROP created_at');
        $this->addSql('ALTER INDEX uniq_880e0d76f85e0677 RENAME TO UNIQ_IDENTIFIER_USERNAME');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE admin ADD email VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE admin ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE admin DROP is_verified');
        $this->addSql('COMMENT ON COLUMN admin.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE UNIQUE INDEX uniq_identifier_email ON admin (email)');
        $this->addSql('ALTER INDEX uniq_identifier_username RENAME TO uniq_880e0d76f85e0677');
    }
}
