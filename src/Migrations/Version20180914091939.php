<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180914091939 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, name FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO category (id, name) SELECT id, name FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('DROP INDEX IDX_837DB71E12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__charity AS SELECT id, category_id, name, address, description FROM charity');
        $this->addSql('DROP TABLE charity');
        $this->addSql('CREATE TABLE charity (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, address VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_837DB71E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO charity (id, category_id, name, address, description) SELECT id, category_id, name, address, description FROM __temp__charity');
        $this->addSql('DROP TABLE __temp__charity');
        $this->addSql('CREATE INDEX IDX_837DB71E12469DE2 ON charity (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_64C19C15E237E06');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, name FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO category (id, name) SELECT id, name FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('DROP INDEX IDX_837DB71E12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__charity AS SELECT id, category_id, name, address, description FROM charity');
        $this->addSql('DROP TABLE charity');
        $this->addSql('CREATE TABLE charity (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO charity (id, category_id, name, address, description) SELECT id, category_id, name, address, description FROM __temp__charity');
        $this->addSql('DROP TABLE __temp__charity');
        $this->addSql('CREATE INDEX IDX_837DB71E12469DE2 ON charity (category_id)');
    }
}
