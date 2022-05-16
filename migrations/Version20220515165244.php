<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515165244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles (articleID INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, accept INT DEFAULT NULL, PRIMARY KEY(articleID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, calendar_coach_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(100) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, description LONGTEXT NOT NULL, all_day TINYINT(1) NOT NULL, background_color VARCHAR(7) NOT NULL, border_color VARCHAR(7) NOT NULL, text_color VARCHAR(7) NOT NULL, INDEX IDX_6EA9A146397276F9 (calendar_coach_id), INDEX IDX_6EA9A146A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coach (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, rating DOUBLE PRECISION DEFAULT NULL, tier VARCHAR(25) NOT NULL, image_url VARCHAR(255) NOT NULL, motto VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3F596DCCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info (contentID INT AUTO_INCREMENT NOT NULL, contentTitle VARCHAR(100) NOT NULL, contentDate DATE NOT NULL, infoContent TEXT DEFAULT NULL, ytContent TEXT DEFAULT NULL, PRIMARY KEY(contentID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matches (id INT AUTO_INCREMENT NOT NULL, team1_id INT NOT NULL, team2_id INT NOT NULL, match_res VARCHAR(255) NOT NULL, match_com VARCHAR(300) NOT NULL, match_date DATE NOT NULL, match_time TIME NOT NULL, INDEX IDX_62615BAE72BCFA4 (team1_id), INDEX IDX_62615BAF59E604A (team2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, ref INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, total VARCHAR(255) DEFAULT NULL, INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, supplier_id INT NOT NULL, ref VARCHAR(20) NOT NULL, name VARCHAR(20) NOT NULL, description VARCHAR(255) DEFAULT NULL, price INT DEFAULT NULL, review INT DEFAULT NULL, state VARCHAR(15) DEFAULT NULL, img_url VARCHAR(255) DEFAULT NULL, INDEX IDX_D34A04AD2ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_search (id INT AUTO_INCREMENT NOT NULL, maxprice INT NOT NULL, availablity INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, coach_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(25) NOT NULL, description VARCHAR(255) DEFAULT NULL, start DATETIME NOT NULL, link VARCHAR(255) DEFAULT NULL, rating INT DEFAULT NULL, INDEX IDX_D044D5D43C105691 (coach_id), INDEX IDX_D044D5D4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, start_date DATETIME DEFAULT NULL, leave_date DATETIME DEFAULT NULL, nvr_units_sold INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_mates (riot_id INT NOT NULL, team_id INT NOT NULL, member_role VARCHAR(255) NOT NULL, member_phone INT NOT NULL, member_mail VARCHAR(255) NOT NULL, INDEX IDX_6162E22F296CD8AE (team_id), PRIMARY KEY(riot_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teams (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, team_name VARCHAR(255) NOT NULL, team_tag VARCHAR(3) NOT NULL, team_mail VARCHAR(255) NOT NULL, team_reg VARCHAR(255) NOT NULL, team_logo VARCHAR(255) NOT NULL, INDEX IDX_96C22258A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tutos (category_id INT NOT NULL, tutoID INT AUTO_INCREMENT NOT NULL, content VARCHAR(65534) NOT NULL, title VARCHAR(200) NOT NULL, INDEX IDX_EE0076DE12469DE2 (category_id), PRIMARY KEY(tutoID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, lastName VARCHAR(50) NOT NULL, CIN INT NOT NULL, phone INT NOT NULL, date VARCHAR(50) NOT NULL, email VARCHAR(180) NOT NULL, pwd VARCHAR(255) NOT NULL, role LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', is_verified TINYINT(1) NOT NULL, ban TINYINT(1) NOT NULL, activate TINYINT(1) NOT NULL, locale VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146397276F9 FOREIGN KEY (calendar_coach_id) REFERENCES coach (id)');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BAE72BCFA4 FOREIGN KEY (team1_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BAF59E604A FOREIGN KEY (team2_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D43C105691 FOREIGN KEY (coach_id) REFERENCES coach (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE team_mates ADD CONSTRAINT FK_6162E22F296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE teams ADD CONSTRAINT FK_96C22258A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tutos ADD CONSTRAINT FK_EE0076DE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tutos DROP FOREIGN KEY FK_EE0076DE12469DE2');
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146397276F9');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D43C105691');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2ADD6D8C');
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BAE72BCFA4');
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BAF59E604A');
        $this->addSql('ALTER TABLE team_mates DROP FOREIGN KEY FK_6162E22F296CD8AE');
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146A76ED395');
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_3F596DCCA76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4A76ED395');
        $this->addSql('ALTER TABLE teams DROP FOREIGN KEY FK_96C22258A76ED395');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE coach');
        $this->addSql('DROP TABLE info');
        $this->addSql('DROP TABLE matches');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE property_search');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE team_mates');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE tutos');
        $this->addSql('DROP TABLE user');
    }
}
