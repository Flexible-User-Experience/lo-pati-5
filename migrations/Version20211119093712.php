<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211119093712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_9D53F328232D562B (object_id), UNIQUE INDEX lookup_artist_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE config_footer_information_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_817024D8232D562B (object_id), UNIQUE INDEX lookup_config_footer_information_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_level1_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_C2CBE106232D562B (object_id), UNIQUE INDEX lookup_menu_level_1_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_level2_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_7F018DC8232D562B (object_id), UNIQUE INDEX lookup_menu_level_2_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_A3D51B1D232D562B (object_id), UNIQUE INDEX lookup_page_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist_translation ADD CONSTRAINT FK_9D53F328232D562B FOREIGN KEY (object_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE config_footer_information_translation ADD CONSTRAINT FK_817024D8232D562B FOREIGN KEY (object_id) REFERENCES config_footer_information (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_level1_translation ADD CONSTRAINT FK_C2CBE106232D562B FOREIGN KEY (object_id) REFERENCES menu_level1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_level2_translation ADD CONSTRAINT FK_7F018DC8232D562B FOREIGN KEY (object_id) REFERENCES menu_level2 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_translation ADD CONSTRAINT FK_A3D51B1D232D562B FOREIGN KEY (object_id) REFERENCES page (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE artist_translation');
        $this->addSql('DROP TABLE config_footer_information_translation');
        $this->addSql('DROP TABLE menu_level1_translation');
        $this->addSql('DROP TABLE menu_level2_translation');
        $this->addSql('DROP TABLE page_translation');
    }
}
