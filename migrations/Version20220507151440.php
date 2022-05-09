<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220507151440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coach (coachId INT AUTO_INCREMENT NOT NULL, rating DOUBLE PRECISION NOT NULL, userID INT DEFAULT NULL, INDEX FK_coach_user (userID), PRIMARY KEY(coachId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE games (contentID INT AUTO_INCREMENT NOT NULL, contentTitle VARCHAR(100) NOT NULL, contentDate DATE NOT NULL, gamingContent BLOB NOT NULL, PRIMARY KEY(contentID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matches (matchid INT AUTO_INCREMENT NOT NULL, team1 INT NOT NULL, team2 INT NOT NULL, matchres VARCHAR(255) NOT NULL, matchcom VARCHAR(300) NOT NULL, matchdate DATE DEFAULT \'CURRENT_TIMESTAMP\' NOT NULL, matchtime TIME DEFAULT \'CURRENT_TIMESTAMP\' NOT NULL, PRIMARY KEY(matchid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id_product INT AUTO_INCREMENT NOT NULL, ref VARCHAR(20) NOT NULL, name VARCHAR(20) NOT NULL, description VARCHAR(100) NOT NULL, price INT NOT NULL, review INT NOT NULL, state VARCHAR(20) NOT NULL, id_supplier INT NOT NULL, INDEX id_supplier (id_supplier), PRIMARY KEY(id_product)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (sessionId INT AUTO_INCREMENT NOT NULL, startTime TIME NOT NULL, Date DATE NOT NULL, rating DOUBLE PRECISION NOT NULL, coachId INT DEFAULT NULL, userID INT DEFAULT NULL, INDEX FK_session_user (userID), INDEX FK_D044D5D47EF1F90C (coachId), PRIMARY KEY(sessionId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id_supplier INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, start_date DATE DEFAULT NULL, leave_date DATE DEFAULT NULL, nbr_units_sold INT NOT NULL, PRIMARY KEY(id_supplier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teammembers (riotId INT AUTO_INCREMENT NOT NULL, memberRole VARCHAR(255) NOT NULL, memberPhone INT NOT NULL, memberMail VARCHAR(255) NOT NULL, userID INT NOT NULL, teamId INT DEFAULT NULL, INDEX team_members_FK (teamId), PRIMARY KEY(riotId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teams (teamId INT AUTO_INCREMENT NOT NULL, teamName VARCHAR(255) NOT NULL, teamTag VARCHAR(3) NOT NULL, teamMail VARCHAR(255) NOT NULL, teamReg VARCHAR(255) NOT NULL, userID INT NOT NULL, PRIMARY KEY(teamId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (userID INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, lastName VARCHAR(50) NOT NULL, CIN INT NOT NULL, phone INT NOT NULL, date VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, pwd VARCHAR(50) NOT NULL, role VARCHAR(50) DEFAULT \'CLIENT\' NOT NULL, PRIMARY KEY(userID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCC5FD86D04 FOREIGN KEY (userID) REFERENCES user (userID)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D47EF1F90C FOREIGN KEY (coachId) REFERENCES coach (coachId)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D45FD86D04 FOREIGN KEY (userID) REFERENCES user (userID)');
        $this->addSql('ALTER TABLE teammembers ADD CONSTRAINT FK_CA8872A5D8528F51 FOREIGN KEY (teamId) REFERENCES teams (teamId)');
        $this->addSql('ALTER TABLE articles CHANGE title title VARCHAR(200) NOT NULL, CHANGE content content VARCHAR(65534) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D47EF1F90C');
        $this->addSql('ALTER TABLE teammembers DROP FOREIGN KEY FK_CA8872A5D8528F51');
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_3F596DCC5FD86D04');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D45FD86D04');
        $this->addSql('DROP TABLE coach');
        $this->addSql('DROP TABLE games');
        $this->addSql('DROP TABLE matches');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE teammembers');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE articles CHANGE content content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE title title VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`');
    }
}
