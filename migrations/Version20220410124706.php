<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220410124706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_mates MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE team_mates DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE team_mates ADD riot_id INT NOT NULL, DROP id');
        $this->addSql('ALTER TABLE team_mates ADD PRIMARY KEY (riot_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_mates ADD id INT AUTO_INCREMENT NOT NULL, DROP riot_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
