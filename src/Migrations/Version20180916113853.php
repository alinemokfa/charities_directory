<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180916113853 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
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

        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_837DB71E12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__charity AS SELECT id, category_id, name, address, description FROM charity');
        $this->addSql('DROP TABLE charity');
        $this->addSql('CREATE TABLE charity (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO charity (id, category_id, name, address, description) SELECT id, category_id, name, address, description FROM __temp__charity');
        $this->addSql('DROP TABLE __temp__charity');
        $this->addSql('CREATE INDEX IDX_837DB71E12469DE2 ON charity (category_id)');
    }
}
