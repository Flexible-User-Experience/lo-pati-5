<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222110653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page ADD previous_edition_parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62068A04136 FOREIGN KEY (previous_edition_parent_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_140AB62068A04136 ON page (previous_edition_parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62068A04136');
        $this->addSql('DROP INDEX IDX_140AB62068A04136 ON page');
        $this->addSql('ALTER TABLE page DROP previous_edition_parent_id');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
