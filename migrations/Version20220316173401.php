<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220316173401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_previous_editions (page_id INT NOT NULL, page_previous_edition_id INT NOT NULL, INDEX IDX_641D255C4663E4 (page_id), INDEX IDX_641D255217FC47C (page_previous_edition_id), PRIMARY KEY(page_id, page_previous_edition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_previous_editions ADD CONSTRAINT FK_641D255C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page_previous_editions ADD CONSTRAINT FK_641D255217FC47C FOREIGN KEY (page_previous_edition_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62068A04136');
        $this->addSql('DROP INDEX IDX_140AB62068A04136 ON page');
        $this->addSql('ALTER TABLE page DROP previous_edition_parent_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE page_previous_editions');
        $this->addSql('ALTER TABLE page ADD previous_edition_parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62068A04136 FOREIGN KEY (previous_edition_parent_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_140AB62068A04136 ON page (previous_edition_parent_id)');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
