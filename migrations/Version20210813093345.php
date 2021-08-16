<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210813093345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archive (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, small_image1_file_name VARCHAR(255) DEFAULT NULL, small_image2_file_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX unique_archive_year_index (year), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, year INT DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, webpage VARCHAR(1024) DEFAULT NULL, image2_file_name VARCHAR(255) DEFAULT NULL, image3_file_name VARCHAR(255) DEFAULT NULL, image4_file_name VARCHAR(255) DEFAULT NULL, image5_file_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, description TEXT NOT NULL, document1_file_name VARCHAR(255) DEFAULT NULL, image1_file_name VARCHAR(255) DEFAULT NULL, summary VARCHAR(300) DEFAULT NULL, UNIQUE INDEX unique_artist_name_index (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_level1 (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT \'#59F3C1\' NOT NULL, is_archive TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_D4BF1C7DC4663E4 (page_id), UNIQUE INDEX unique_menu_level1_name_index (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_level2 (id INT AUTO_INCREMENT NOT NULL, menu_level1_id INT NOT NULL, page_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, is_list TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, position INT NOT NULL, INDEX IDX_4DB64DC787C1CDA7 (menu_level1_id), UNIQUE INDEX UNIQ_4DB64DC7C4663E4 (page_id), UNIQUE INDEX unique_menu_level2_name_level1_index (name, menu_level1_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, newsletter_group_id INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, status INT DEFAULT 0 NOT NULL, type INT DEFAULT 0, tested TINYINT(1) DEFAULT \'0\' NOT NULL, begin_send DATETIME DEFAULT NULL, end_send DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, old_database_version_id INT DEFAULT 0 NOT NULL, INDEX IDX_7E8585C823561F2D (newsletter_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, UNIQUE INDEX unique_newsletter_group_name_index (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_group_newsletter_user (newsletter_group_id INT NOT NULL, newsletter_user_id INT NOT NULL, INDEX IDX_42332F3B23561F2D (newsletter_group_id), INDEX IDX_42332F3BA8D470FA (newsletter_user_id), PRIMARY KEY(newsletter_group_id, newsletter_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_post (id INT AUTO_INCREMENT NOT NULL, newsletter_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, short_description VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, interval_date_text VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, type INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, image1_file_name VARCHAR(255) DEFAULT NULL, old_database_version_id INT DEFAULT 0 NOT NULL, position INT NOT NULL, INDEX IDX_520F749622DB1917 (newsletter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, birthdate DATE DEFAULT NULL, language VARCHAR(2) DEFAULT \'ca\' NOT NULL, token VARCHAR(255) NOT NULL, fail INT DEFAULT 0, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, UNIQUE INDEX unique_newsletter_user_email_index (email), UNIQUE INDEX unique_newsletter_user_token_index (token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, menu_level1_id INT DEFAULT NULL, menu_level2_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary TEXT DEFAULT NULL, is_front_cover TINYINT(1) DEFAULT \'0\' NOT NULL, publish_date DATE NOT NULL, show_publish_date TINYINT(1) DEFAULT \'0\' NOT NULL, always_show_on_calendar TINYINT(1) DEFAULT \'0\' NOT NULL, expiration_date DATE DEFAULT NULL, realization_date_string VARCHAR(255) DEFAULT NULL, place VARCHAR(255) DEFAULT NULL, links TEXT DEFAULT NULL, show_social_networks_sharing_buttons TINYINT(1) DEFAULT \'0\' NOT NULL, video VARCHAR(255) DEFAULT NULL, url_vimeo VARCHAR(255) DEFAULT NULL, url_flickr VARCHAR(255) DEFAULT NULL, image_file_name VARCHAR(255) DEFAULT NULL, image_caption VARCHAR(255) DEFAULT NULL, title_document1 VARCHAR(255) DEFAULT NULL, document2_file_name VARCHAR(255) DEFAULT NULL, title_document2 VARCHAR(255) DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, template_type INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, description TEXT NOT NULL, document1_file_name VARCHAR(255) DEFAULT NULL, small_image1_file_name VARCHAR(255) DEFAULT NULL, small_image2_file_name VARCHAR(255) DEFAULT NULL, INDEX IDX_140AB62087C1CDA7 (menu_level1_id), INDEX IDX_140AB62095746249 (menu_level2_id), UNIQUE INDEX unique_page_published_date_name_index (name, publish_date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slideshow (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_alt_name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, image1_file_name VARCHAR(255) DEFAULT NULL, position INT NOT NULL, UNIQUE INDEX unique_slideshow_name_index (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', last_login DATETIME DEFAULT NULL, login_count INT UNSIGNED DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, UNIQUE INDEX unique_user_email_index (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_level1 ADD CONSTRAINT FK_D4BF1C7DC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE menu_level2 ADD CONSTRAINT FK_4DB64DC787C1CDA7 FOREIGN KEY (menu_level1_id) REFERENCES menu_level1 (id)');
        $this->addSql('ALTER TABLE menu_level2 ADD CONSTRAINT FK_4DB64DC7C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C823561F2D FOREIGN KEY (newsletter_group_id) REFERENCES newsletter_group (id)');
        $this->addSql('ALTER TABLE newsletter_group_newsletter_user ADD CONSTRAINT FK_42332F3B23561F2D FOREIGN KEY (newsletter_group_id) REFERENCES newsletter_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_group_newsletter_user ADD CONSTRAINT FK_42332F3BA8D470FA FOREIGN KEY (newsletter_user_id) REFERENCES newsletter_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_post ADD CONSTRAINT FK_520F749622DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62087C1CDA7 FOREIGN KEY (menu_level1_id) REFERENCES menu_level1 (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62095746249 FOREIGN KEY (menu_level2_id) REFERENCES menu_level2 (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_level2 DROP FOREIGN KEY FK_4DB64DC787C1CDA7');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62087C1CDA7');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62095746249');
        $this->addSql('ALTER TABLE newsletter_post DROP FOREIGN KEY FK_520F749622DB1917');
        $this->addSql('ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C823561F2D');
        $this->addSql('ALTER TABLE newsletter_group_newsletter_user DROP FOREIGN KEY FK_42332F3B23561F2D');
        $this->addSql('ALTER TABLE newsletter_group_newsletter_user DROP FOREIGN KEY FK_42332F3BA8D470FA');
        $this->addSql('ALTER TABLE menu_level1 DROP FOREIGN KEY FK_D4BF1C7DC4663E4');
        $this->addSql('ALTER TABLE menu_level2 DROP FOREIGN KEY FK_4DB64DC7C4663E4');
        $this->addSql('DROP TABLE archive');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE menu_level1');
        $this->addSql('DROP TABLE menu_level2');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE newsletter_group');
        $this->addSql('DROP TABLE newsletter_group_newsletter_user');
        $this->addSql('DROP TABLE newsletter_post');
        $this->addSql('DROP TABLE newsletter_user');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE slideshow');
        $this->addSql('DROP TABLE user');
    }
}
