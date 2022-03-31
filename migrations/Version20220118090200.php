<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220118090200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archive (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, legacy_id INT DEFAULT NULL, small_image1_file_name VARCHAR(255) DEFAULT NULL, small_image2_file_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D5FC5D9C184998FC (legacy_id), UNIQUE INDEX unique_archive_year_index (year), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, year INT DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, webpage VARCHAR(1024) DEFAULT NULL, image2_file_name VARCHAR(255) DEFAULT NULL, image3_file_name VARCHAR(255) DEFAULT NULL, image4_file_name VARCHAR(255) DEFAULT NULL, image5_file_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, description TEXT NOT NULL, document1_file_name VARCHAR(255) DEFAULT NULL, image1_file_name VARCHAR(255) DEFAULT NULL, legacy_id INT DEFAULT NULL, summary VARCHAR(300) DEFAULT NULL, UNIQUE INDEX UNIQ_1599687184998FC (legacy_id), UNIQUE INDEX unique_artist_name_index (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_9D53F328232D562B (object_id), UNIQUE INDEX lookup_artist_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE config_calendar_working_day (id INT AUTO_INCREMENT NOT NULL, working_day_number INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, legacy_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_239A646F184998FC (legacy_id), UNIQUE INDEX unique_config_calendar_working_day_index (working_day_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_level1 (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT \'#59F3C1\' NOT NULL, is_archive TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, legacy_id INT DEFAULT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_D4BF1C7D184998FC (legacy_id), UNIQUE INDEX UNIQ_D4BF1C7DC4663E4 (page_id), UNIQUE INDEX unique_menu_level1_name_index (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_level1_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_C2CBE106232D562B (object_id), UNIQUE INDEX lookup_menu_level_1_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_level2 (id INT AUTO_INCREMENT NOT NULL, menu_level1_id INT NOT NULL, page_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, is_list TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, legacy_id INT DEFAULT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_4DB64DC7184998FC (legacy_id), INDEX IDX_4DB64DC787C1CDA7 (menu_level1_id), UNIQUE INDEX UNIQ_4DB64DC7C4663E4 (page_id), UNIQUE INDEX unique_menu_level2_name_level1_index (name, menu_level1_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_level2_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_7F018DC8232D562B (object_id), UNIQUE INDEX lookup_menu_level_2_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, newsletter_group_id INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, status INT DEFAULT 0 NOT NULL, type INT DEFAULT 0, tested TINYINT(1) DEFAULT 0 NOT NULL, begin_send DATETIME DEFAULT NULL, end_send DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, legacy_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_7E8585C8184998FC (legacy_id), INDEX IDX_7E8585C823561F2D (newsletter_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, legacy_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_E7AD0831184998FC (legacy_id), UNIQUE INDEX unique_newsletter_group_name_index (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_group_newsletter_user (newsletter_group_id INT NOT NULL, newsletter_user_id INT NOT NULL, INDEX IDX_42332F3B23561F2D (newsletter_group_id), INDEX IDX_42332F3BA8D470FA (newsletter_user_id), PRIMARY KEY(newsletter_group_id, newsletter_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_post (id INT AUTO_INCREMENT NOT NULL, newsletter_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, short_description VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, interval_date_text VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, type INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, image1_file_name VARCHAR(255) DEFAULT NULL, legacy_id INT DEFAULT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_520F7496184998FC (legacy_id), INDEX IDX_520F749622DB1917 (newsletter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, birthdate DATE DEFAULT NULL, language VARCHAR(2) DEFAULT \'ca\' NOT NULL, token VARCHAR(255) NOT NULL, fail INT DEFAULT 0, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, legacy_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8516CE52184998FC (legacy_id), UNIQUE INDEX unique_newsletter_user_email_index (email), UNIQUE INDEX unique_newsletter_user_token_index (token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, menu_level1_id INT DEFAULT NULL, menu_level2_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary TEXT DEFAULT NULL, description TEXT NOT NULL, is_front_cover TINYINT(1) DEFAULT 0 NOT NULL, publish_date DATE NOT NULL, show_publish_date TINYINT(1) DEFAULT 0 NOT NULL, always_show_on_calendar TINYINT(1) DEFAULT 0 NOT NULL, expiration_date DATE DEFAULT NULL, realization_date_string VARCHAR(255) DEFAULT NULL, place VARCHAR(255) DEFAULT NULL, links TEXT DEFAULT NULL, show_social_networks_sharing_buttons TINYINT(1) DEFAULT 0 NOT NULL, video VARCHAR(255) DEFAULT NULL, url_vimeo VARCHAR(255) DEFAULT NULL, url_flickr VARCHAR(255) DEFAULT NULL, image_file_name VARCHAR(255) DEFAULT NULL, image_caption VARCHAR(255) DEFAULT NULL, title_document1 VARCHAR(255) DEFAULT NULL, title_document2 VARCHAR(255) DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, template_type INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, document1_file_name VARCHAR(255) DEFAULT NULL, document2_file_name VARCHAR(255) DEFAULT NULL, legacy_id INT DEFAULT NULL, small_image1_file_name VARCHAR(255) DEFAULT NULL, small_image2_file_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_140AB620184998FC (legacy_id), INDEX IDX_140AB62087C1CDA7 (menu_level1_id), INDEX IDX_140AB62095746249 (menu_level2_id), UNIQUE INDEX unique_page_published_date_name_index (name, publish_date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_image (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, image_alt_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, image1_file_name VARCHAR(255) DEFAULT NULL, position INT NOT NULL, INDEX IDX_A3BCFB89C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_A3D51B1D232D562B (object_id), UNIQUE INDEX lookup_page_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slideshow_page (id INT AUTO_INCREMENT NOT NULL, menu_level1_id INT DEFAULT NULL, menu_level2_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, realization_date_string VARCHAR(255) DEFAULT NULL, place VARCHAR(255) DEFAULT NULL, link TEXT DEFAULT NULL, image_file_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, position INT NOT NULL, summary VARCHAR(300) DEFAULT NULL, INDEX IDX_9F3084A687C1CDA7 (menu_level1_id), INDEX IDX_9F3084A695746249 (menu_level2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slideshow_page_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_C7F8AFA3232D562B (object_id), UNIQUE INDEX lookup_slideshow_page_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', last_login DATETIME DEFAULT NULL, login_count INT UNSIGNED DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, UNIQUE INDEX unique_user_email_index (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visiting_hours (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, text_line1 VARCHAR(255) NOT NULL, text_line2 VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_7CF88765E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visiting_hours_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_1543FBA232D562B (object_id), UNIQUE INDEX lookup_visiting_hours_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist_translation ADD CONSTRAINT FK_9D53F328232D562B FOREIGN KEY (object_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_level1 ADD CONSTRAINT FK_D4BF1C7DC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE menu_level1_translation ADD CONSTRAINT FK_C2CBE106232D562B FOREIGN KEY (object_id) REFERENCES menu_level1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_level2 ADD CONSTRAINT FK_4DB64DC787C1CDA7 FOREIGN KEY (menu_level1_id) REFERENCES menu_level1 (id)');
        $this->addSql('ALTER TABLE menu_level2 ADD CONSTRAINT FK_4DB64DC7C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE menu_level2_translation ADD CONSTRAINT FK_7F018DC8232D562B FOREIGN KEY (object_id) REFERENCES menu_level2 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C823561F2D FOREIGN KEY (newsletter_group_id) REFERENCES newsletter_group (id)');
        $this->addSql('ALTER TABLE newsletter_group_newsletter_user ADD CONSTRAINT FK_42332F3B23561F2D FOREIGN KEY (newsletter_group_id) REFERENCES newsletter_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_group_newsletter_user ADD CONSTRAINT FK_42332F3BA8D470FA FOREIGN KEY (newsletter_user_id) REFERENCES newsletter_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_post ADD CONSTRAINT FK_520F749622DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62087C1CDA7 FOREIGN KEY (menu_level1_id) REFERENCES menu_level1 (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62095746249 FOREIGN KEY (menu_level2_id) REFERENCES menu_level2 (id)');
        $this->addSql('ALTER TABLE page_image ADD CONSTRAINT FK_A3BCFB89C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page_translation ADD CONSTRAINT FK_A3D51B1D232D562B FOREIGN KEY (object_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slideshow_page ADD CONSTRAINT FK_9F3084A687C1CDA7 FOREIGN KEY (menu_level1_id) REFERENCES menu_level1 (id)');
        $this->addSql('ALTER TABLE slideshow_page ADD CONSTRAINT FK_9F3084A695746249 FOREIGN KEY (menu_level2_id) REFERENCES menu_level2 (id)');
        $this->addSql('ALTER TABLE slideshow_page_translation ADD CONSTRAINT FK_C7F8AFA3232D562B FOREIGN KEY (object_id) REFERENCES slideshow_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visiting_hours_translation ADD CONSTRAINT FK_1543FBA232D562B FOREIGN KEY (object_id) REFERENCES visiting_hours (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_translation DROP FOREIGN KEY FK_9D53F328232D562B');
        $this->addSql('ALTER TABLE menu_level1_translation DROP FOREIGN KEY FK_C2CBE106232D562B');
        $this->addSql('ALTER TABLE menu_level2 DROP FOREIGN KEY FK_4DB64DC787C1CDA7');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62087C1CDA7');
        $this->addSql('ALTER TABLE slideshow_page DROP FOREIGN KEY FK_9F3084A687C1CDA7');
        $this->addSql('ALTER TABLE menu_level2_translation DROP FOREIGN KEY FK_7F018DC8232D562B');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62095746249');
        $this->addSql('ALTER TABLE slideshow_page DROP FOREIGN KEY FK_9F3084A695746249');
        $this->addSql('ALTER TABLE newsletter_post DROP FOREIGN KEY FK_520F749622DB1917');
        $this->addSql('ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C823561F2D');
        $this->addSql('ALTER TABLE newsletter_group_newsletter_user DROP FOREIGN KEY FK_42332F3B23561F2D');
        $this->addSql('ALTER TABLE newsletter_group_newsletter_user DROP FOREIGN KEY FK_42332F3BA8D470FA');
        $this->addSql('ALTER TABLE menu_level1 DROP FOREIGN KEY FK_D4BF1C7DC4663E4');
        $this->addSql('ALTER TABLE menu_level2 DROP FOREIGN KEY FK_4DB64DC7C4663E4');
        $this->addSql('ALTER TABLE page_image DROP FOREIGN KEY FK_A3BCFB89C4663E4');
        $this->addSql('ALTER TABLE page_translation DROP FOREIGN KEY FK_A3D51B1D232D562B');
        $this->addSql('ALTER TABLE slideshow_page_translation DROP FOREIGN KEY FK_C7F8AFA3232D562B');
        $this->addSql('ALTER TABLE visiting_hours_translation DROP FOREIGN KEY FK_1543FBA232D562B');
        $this->addSql('DROP TABLE archive');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE artist_translation');
        $this->addSql('DROP TABLE config_calendar_working_day');
        $this->addSql('DROP TABLE menu_level1');
        $this->addSql('DROP TABLE menu_level1_translation');
        $this->addSql('DROP TABLE menu_level2');
        $this->addSql('DROP TABLE menu_level2_translation');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE newsletter_group');
        $this->addSql('DROP TABLE newsletter_group_newsletter_user');
        $this->addSql('DROP TABLE newsletter_post');
        $this->addSql('DROP TABLE newsletter_user');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_image');
        $this->addSql('DROP TABLE page_translation');
        $this->addSql('DROP TABLE slideshow_page');
        $this->addSql('DROP TABLE slideshow_page_translation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE visiting_hours');
        $this->addSql('DROP TABLE visiting_hours_translation');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
