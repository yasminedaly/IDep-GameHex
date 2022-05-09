<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220425050412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('ALTER TABLE articles ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD316812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_BFDD316812469DE2 ON articles (category_id)');
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_coach_user');
        $this->addSql('ALTER TABLE coach CHANGE userID userID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCC5FD86D04 FOREIGN KEY (userID) REFERENCES user (userID)');
        $this->addSql('ALTER TABLE info CHANGE infoContent infoContent TEXT NOT NULL');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_session_user');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_session_coach');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_session_coach');
        $this->addSql('ALTER TABLE session CHANGE coachId coachId INT DEFAULT NULL, CHANGE userID userID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D47EF1F90C FOREIGN KEY (coachId) REFERENCES coach (coachId)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D45FD86D04 FOREIGN KEY (userID) REFERENCES user (userID)');
        $this->addSql('DROP INDEX fk_session_coach ON session');
        $this->addSql('CREATE INDEX FK_D044D5D47EF1F90C ON session (coachId)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_session_coach FOREIGN KEY (coachId) REFERENCES coach (coachId) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE supplier CHANGE nbr_units_sold nbr_units_sold INT NOT NULL');
        $this->addSql('ALTER TABLE teammembers DROP FOREIGN KEY team_members_FK');
        $this->addSql('ALTER TABLE teammembers CHANGE riotId riotId INT AUTO_INCREMENT NOT NULL, CHANGE teamId teamId INT DEFAULT NULL, ADD PRIMARY KEY (riotId)');
        $this->addSql('ALTER TABLE teammembers ADD CONSTRAINT FK_CA8872A5D8528F51 FOREIGN KEY (teamId) REFERENCES teams (teamId)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD316812469DE2');
        $this->addSql('CREATE TABLE feedback (userID INT NOT NULL, articleID INT NOT NULL, `like` INT NOT NULL, dislike INT NOT NULL, INDEX userID (userID), INDEX articleID (articleID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT feedback_ibfk_2 FOREIGN KEY (articleID) REFERENCES articles (articleID)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT feedback_ibfk_1 FOREIGN KEY (userID) REFERENCES user (userID)');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP INDEX IDX_BFDD316812469DE2 ON articles');
        $this->addSql('ALTER TABLE articles DROP category_id');
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_3F596DCC5FD86D04');
        $this->addSql('ALTER TABLE coach CHANGE userID userID INT NOT NULL');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_coach_user FOREIGN KEY (userID) REFERENCES user (userID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info CHANGE infoContent infoContent LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D47EF1F90C');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D45FD86D04');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D47EF1F90C');
        $this->addSql('ALTER TABLE session CHANGE coachId coachId INT NOT NULL, CHANGE userID userID INT NOT NULL');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_session_user FOREIGN KEY (userID) REFERENCES user (userID) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_session_coach FOREIGN KEY (coachId) REFERENCES coach (coachId) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP INDEX fk_d044d5d47ef1f90c ON session');
        $this->addSql('CREATE INDEX FK_session_coach ON session (coachId)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D47EF1F90C FOREIGN KEY (coachId) REFERENCES coach (coachId)');
        $this->addSql('ALTER TABLE supplier CHANGE nbr_units_sold nbr_units_sold INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE teammembers MODIFY riotId INT NOT NULL');
        $this->addSql('ALTER TABLE teammembers DROP FOREIGN KEY FK_CA8872A5D8528F51');
        $this->addSql('ALTER TABLE teammembers DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE teammembers CHANGE riotId riotId INT NOT NULL, CHANGE teamId teamId INT NOT NULL');
        $this->addSql('ALTER TABLE teammembers ADD CONSTRAINT team_members_FK FOREIGN KEY (teamId) REFERENCES teams (teamId) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
