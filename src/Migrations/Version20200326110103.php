<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200326110103 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE joke MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE joke DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE joke DROP id, DROP joke');
        $this->addSql('ALTER TABLE joke ADD PRIMARY KEY (joke_id)');
        $this->addSql('ALTER TABLE favorite_joke DROP joke, DROP id, CHANGE joke_id joke_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE favorite_joke ADD joke VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD id INT NOT NULL, CHANGE joke_id joke_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE joke ADD id INT AUTO_INCREMENT NOT NULL, ADD joke VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
