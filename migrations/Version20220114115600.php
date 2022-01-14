<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220114115600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE slideshow_page (id INT AUTO_INCREMENT NOT NULL, menu_level1_id INT DEFAULT NULL, menu_level2_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, realization_date_string VARCHAR(255) DEFAULT NULL, link TEXT DEFAULT NULL, image_file_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, position INT NOT NULL, summary VARCHAR(300) DEFAULT NULL, INDEX IDX_9F3084A687C1CDA7 (menu_level1_id), INDEX IDX_9F3084A695746249 (menu_level2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slideshow_page_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_C7F8AFA3232D562B (object_id), UNIQUE INDEX lookup_slideshow_page_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE slideshow_page ADD CONSTRAINT FK_9F3084A687C1CDA7 FOREIGN KEY (menu_level1_id) REFERENCES menu_level1 (id)');
        $this->addSql('ALTER TABLE slideshow_page ADD CONSTRAINT FK_9F3084A695746249 FOREIGN KEY (menu_level2_id) REFERENCES menu_level2 (id)');
        $this->addSql('ALTER TABLE slideshow_page_translation ADD CONSTRAINT FK_C7F8AFA3232D562B FOREIGN KEY (object_id) REFERENCES slideshow_page (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slideshow_page_translation DROP FOREIGN KEY FK_C7F8AFA3232D562B');
        $this->addSql('DROP TABLE slideshow_page');
        $this->addSql('DROP TABLE slideshow_page_translation');
    }
}
