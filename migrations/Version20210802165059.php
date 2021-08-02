<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210802165059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, newsletter_group_id INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, status INT DEFAULT 0 NOT NULL, type INT DEFAULT 0, tested TINYINT(1) DEFAULT \'0\' NOT NULL, begin_send DATETIME DEFAULT NULL, end_send DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_7E8585C823561F2D (newsletter_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, UNIQUE INDEX unique_newsletter_group_name_index (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_group_newsletter_user (newsletter_group_id INT NOT NULL, newsletter_user_id INT NOT NULL, INDEX IDX_42332F3B23561F2D (newsletter_group_id), INDEX IDX_42332F3BA8D470FA (newsletter_user_id), PRIMARY KEY(newsletter_group_id, newsletter_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_post (id INT AUTO_INCREMENT NOT NULL, newsletter_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, short_description VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, interval_date_text VARCHAR(255) DEFAULT NULL, type INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, image1_file_name VARCHAR(255) DEFAULT NULL, position INT NOT NULL, INDEX IDX_520F749622DB1917 (newsletter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, birthdate DATE DEFAULT NULL, language VARCHAR(2) DEFAULT \'ca\' NOT NULL, token VARCHAR(255) NOT NULL, fail INT DEFAULT 0, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, UNIQUE INDEX unique_newsletter_user_email_index (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C823561F2D FOREIGN KEY (newsletter_group_id) REFERENCES newsletter_group (id)');
        $this->addSql('ALTER TABLE newsletter_group_newsletter_user ADD CONSTRAINT FK_42332F3B23561F2D FOREIGN KEY (newsletter_group_id) REFERENCES newsletter_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_group_newsletter_user ADD CONSTRAINT FK_42332F3BA8D470FA FOREIGN KEY (newsletter_user_id) REFERENCES newsletter_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_post ADD CONSTRAINT FK_520F749622DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id)');
        $this->addSql('DROP INDEX unique_year_index ON archive');
        $this->addSql('CREATE UNIQUE INDEX unique_archive_year_index ON archive (year)');
        $this->addSql('DROP INDEX unique_name_index ON menu_level1');
        $this->addSql('CREATE UNIQUE INDEX unique_menu_level1_name_index ON menu_level1 (name)');
        $this->addSql('ALTER TABLE menu_level2 DROP FOREIGN KEY FK_4DB64DC787C1CDA7');
        $this->addSql('DROP INDEX unique_subname_index ON menu_level2');
        $this->addSql('CREATE UNIQUE INDEX unique_menu_level2_name_level1_index ON menu_level2 (name, menu_level1_id)');
        $this->addSql('ALTER TABLE menu_level2 ADD CONSTRAINT FK_4DB64DC787C1CDA7 FOREIGN KEY (menu_level1_id) REFERENCES menu_level1 (id)');
        $this->addSql('DROP INDEX published_date_name_unique_idx ON page');
        $this->addSql('CREATE UNIQUE INDEX unique_page_published_date_name_index ON page (name, publish_date)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE newsletter_post DROP FOREIGN KEY FK_520F749622DB1917');
        $this->addSql('ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C823561F2D');
        $this->addSql('ALTER TABLE newsletter_group_newsletter_user DROP FOREIGN KEY FK_42332F3B23561F2D');
        $this->addSql('ALTER TABLE newsletter_group_newsletter_user DROP FOREIGN KEY FK_42332F3BA8D470FA');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE newsletter_group');
        $this->addSql('DROP TABLE newsletter_group_newsletter_user');
        $this->addSql('DROP TABLE newsletter_post');
        $this->addSql('DROP TABLE newsletter_user');
        $this->addSql('DROP INDEX unique_archive_year_index ON archive');
        $this->addSql('CREATE UNIQUE INDEX unique_year_index ON archive (year)');
        $this->addSql('DROP INDEX unique_menu_level1_name_index ON menu_level1');
        $this->addSql('CREATE UNIQUE INDEX unique_name_index ON menu_level1 (name)');
        $this->addSql('ALTER TABLE menu_level2 DROP FOREIGN KEY FK_4DB64DC787C1CDA7');
        $this->addSql('DROP INDEX unique_menu_level2_name_level1_index ON menu_level2');
        $this->addSql('CREATE UNIQUE INDEX unique_subname_index ON menu_level2 (name, menu_level1_id)');
        $this->addSql('ALTER TABLE menu_level2 ADD CONSTRAINT FK_4DB64DC787C1CDA7 FOREIGN KEY (menu_level1_id) REFERENCES menu_level1 (id)');
        $this->addSql('DROP INDEX unique_page_published_date_name_index ON page');
        $this->addSql('CREATE UNIQUE INDEX published_date_name_unique_idx ON page (name, publish_date)');
    }
}
