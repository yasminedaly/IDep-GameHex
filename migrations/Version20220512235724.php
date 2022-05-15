<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512235724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tutos DROP FOREIGN KEY FK_BFDD316812469DE2');
        $this->addSql('ALTER TABLE tutos CHANGE title title VARCHAR(200) NOT NULL, CHANGE content content VARCHAR(65534) NOT NULL');
        $this->addSql('DROP INDEX idx_bfdd316812469de2 ON tutos');
        $this->addSql('CREATE INDEX IDX_EE0076DE12469DE2 ON tutos (category_id)');
        $this->addSql('ALTER TABLE tutos ADD CONSTRAINT FK_BFDD316812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tutos DROP FOREIGN KEY FK_EE0076DE12469DE2');
        $this->addSql('ALTER TABLE tutos CHANGE content content LONGTEXT NOT NULL, CHANGE title title VARCHAR(200) DEFAULT NULL');
        $this->addSql('DROP INDEX idx_ee0076de12469de2 ON tutos');
        $this->addSql('CREATE INDEX IDX_BFDD316812469DE2 ON tutos (category_id)');
        $this->addSql('ALTER TABLE tutos ADD CONSTRAINT FK_EE0076DE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }
}
