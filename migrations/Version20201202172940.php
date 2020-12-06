<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202172940 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add relation between pans and users table';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pans ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE pans ADD CONSTRAINT FK_311CB838A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_311CB838A76ED395 ON pans (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pans DROP FOREIGN KEY FK_311CB838A76ED395');
        $this->addSql('DROP INDEX IDX_311CB838A76ED395 ON pans');
        $this->addSql('ALTER TABLE pans DROP user_id');
    }
}
