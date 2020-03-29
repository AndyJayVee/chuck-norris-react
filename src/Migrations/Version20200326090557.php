<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200326090557 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE joke DROP joke_id, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE favorite_joke MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE favorite_joke DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE favorite_joke DROP id');
        $this->addSql('ALTER TABLE favorite_joke ADD PRIMARY KEY (joke_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE favorite_joke ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE joke ADD joke_id INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
