<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220503145204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD79F37AE5');
        $this->addSql('DROP INDEX IDX_D34A04AD79F37AE5 ON product');
        $this->addSql('ALTER TABLE product ADD user_id INT DEFAULT NULL, DROP id_user_id');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADA76ED395 ON product (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA76ED395');
        $this->addSql('DROP INDEX IDX_D34A04ADA76ED395 ON product');
        $this->addSql('ALTER TABLE product ADD id_user_id INT NOT NULL, DROP user_id');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD79F37AE5 ON product (id_user_id)');
    }
}
