<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210728154352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archive (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, small_image1_file_name VARCHAR(255) DEFAULT NULL, small_image2_file_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX unique_year_index (year), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, year INT DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, webpage VARCHAR(1024) DEFAULT NULL, image2_file_name VARCHAR(255) DEFAULT NULL, image3_file_name VARCHAR(255) DEFAULT NULL, image4_file_name VARCHAR(255) DEFAULT NULL, image5_file_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, description TEXT NOT NULL, document1_file_name VARCHAR(255) DEFAULT NULL, image1_file_name VARCHAR(255) DEFAULT NULL, summary VARCHAR(300) DEFAULT NULL, UNIQUE INDEX unique_artist_name_index (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_level1 (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT \'#59F3C1\' NOT NULL, is_archive TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_D4BF1C7DC4663E4 (page_id), UNIQUE INDEX unique_name_index (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_level2 (id INT AUTO_INCREMENT NOT NULL, menu_level1_id INT NOT NULL, page_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, is_list TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, position INT NOT NULL, INDEX IDX_4DB64DC787C1CDA7 (menu_level1_id), UNIQUE INDEX UNIQ_4DB64DC7C4663E4 (page_id), UNIQUE INDEX unique_subname_index (name, menu_level1_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, menu_level1_id INT DEFAULT NULL, menu_level2_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary TEXT DEFAULT NULL, is_front_cover TINYINT(1) DEFAULT \'0\' NOT NULL, publish_date DATE NOT NULL, show_publish_date TINYINT(1) DEFAULT \'0\' NOT NULL, always_show_on_calendar TINYINT(1) DEFAULT \'0\' NOT NULL, expiration_date DATE DEFAULT NULL, realization_date_string VARCHAR(255) DEFAULT NULL, place VARCHAR(255) DEFAULT NULL, links TEXT DEFAULT NULL, show_social_networks_sharing_buttons TINYINT(1) DEFAULT \'0\' NOT NULL, video VARCHAR(255) DEFAULT NULL, url_vimeo VARCHAR(255) DEFAULT NULL, url_flickr VARCHAR(255) DEFAULT NULL, image_file_name VARCHAR(255) DEFAULT NULL, image_caption VARCHAR(255) DEFAULT NULL, title_document1 VARCHAR(255) DEFAULT NULL, document2_file_name VARCHAR(255) DEFAULT NULL, title_document2 VARCHAR(255) DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, template_type INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, description TEXT NOT NULL, document1_file_name VARCHAR(255) DEFAULT NULL, small_image1_file_name VARCHAR(255) DEFAULT NULL, small_image2_file_name VARCHAR(255) DEFAULT NULL, INDEX IDX_140AB62087C1CDA7 (menu_level1_id), INDEX IDX_140AB62095746249 (menu_level2_id), UNIQUE INDEX published_date_name_unique_idx (name, publish_date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slideshow (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_alt_name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, image1_file_name VARCHAR(255) DEFAULT NULL, position INT NOT NULL, UNIQUE INDEX unique_slideshow_name_index (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_level1 ADD CONSTRAINT FK_D4BF1C7DC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE menu_level2 ADD CONSTRAINT FK_4DB64DC787C1CDA7 FOREIGN KEY (menu_level1_id) REFERENCES menu_level1 (id)');
        $this->addSql('ALTER TABLE menu_level2 ADD CONSTRAINT FK_4DB64DC7C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62087C1CDA7 FOREIGN KEY (menu_level1_id) REFERENCES menu_level1 (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62095746249 FOREIGN KEY (menu_level2_id) REFERENCES menu_level2 (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_level2 DROP FOREIGN KEY FK_4DB64DC787C1CDA7');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62087C1CDA7');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62095746249');
        $this->addSql('ALTER TABLE menu_level1 DROP FOREIGN KEY FK_D4BF1C7DC4663E4');
        $this->addSql('ALTER TABLE menu_level2 DROP FOREIGN KEY FK_4DB64DC7C4663E4');
        $this->addSql('DROP TABLE archive');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE menu_level1');
        $this->addSql('DROP TABLE menu_level2');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE slideshow');
    }
}
