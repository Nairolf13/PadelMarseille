<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250119211949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        if (!$schema->hasTable('reservation')) {
            $this->addSql('CREATE TABLE reservation (id SERIAL NOT NULL, admin_id INT NOT NULL, date DATE NOT NULL, time VARCHAR(5) NOT NULL, court INT NOT NULL, players INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
            $this->addSql('CREATE INDEX IDX_42C84955642B8210 ON reservation (admin_id)');
            $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        if ($schema->hasTable('reservation')) {
            $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C84955642B8210');
            $this->addSql('DROP TABLE reservation');
        }
    }
}
