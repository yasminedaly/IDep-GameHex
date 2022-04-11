<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220410124320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matches_teams (matches_id INT NOT NULL, teams_id INT NOT NULL, INDEX IDX_8E7F6A754B30DD19 (matches_id), INDEX IDX_8E7F6A75D6365F12 (teams_id), PRIMARY KEY(matches_id, teams_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_mates (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, member_role VARCHAR(255) NOT NULL, member_phone INT NOT NULL, member_mail VARCHAR(255) NOT NULL, INDEX IDX_6162E22F296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matches_teams ADD CONSTRAINT FK_8E7F6A754B30DD19 FOREIGN KEY (matches_id) REFERENCES matches (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matches_teams ADD CONSTRAINT FK_8E7F6A75D6365F12 FOREIGN KEY (teams_id) REFERENCES teams (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_mates ADD CONSTRAINT FK_6162E22F296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE matches_teams');
        $this->addSql('DROP TABLE team_mates');
    }
}
