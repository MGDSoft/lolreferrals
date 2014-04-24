<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140422110748 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE pedido ADD n_remaining_queue INT DEFAULT 0");
        $this->addSql("ALTER TABLE pedido MODIFY n_remaining_queue INT NOT NULL");


        $this->addSql("CREATE TABLE pedido_opinion (id INT AUTO_INCREMENT NOT NULL, pedido_id VARCHAR(30) DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, created DATETIME NOT NULL, UNIQUE INDEX UNIQ_C97B38494854653A (pedido_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE pedido_opinion ADD CONSTRAINT FK_C97B38494854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id)");
        $this->addSql("ALTER TABLE pedido ADD opinion_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CE51885A6A FOREIGN KEY (opinion_id) REFERENCES pedido_opinion (id)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_C4EC16CE51885A6A ON pedido (opinion_id)");


        $this->addSql("ALTER TABLE pedido ADD language VARCHAR(2) DEFAULT 'en'");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE pedido DROP n_remaining_queue");


        $this->addSql("ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CE51885A6A");
        $this->addSql("DROP TABLE pedido_opinion");
        $this->addSql("DROP INDEX UNIQ_C4EC16CE51885A6A ON pedido");
        $this->addSql("ALTER TABLE pedido DROP opinion_id");

        $this->addSql("ALTER TABLE pedido DROP language");
    }
}
