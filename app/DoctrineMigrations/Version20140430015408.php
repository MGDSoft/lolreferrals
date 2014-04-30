<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140430015408 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CE51885A6A");
        $this->addSql("DROP INDEX UNIQ_C4EC16CE51885A6A ON pedido");
        $this->addSql("ALTER TABLE pedido DROP opinion_id, DROP n_remaining_queue");

        // Manual
        $this->addSql("UPDATE `Cola` SET `days`=500 WHERE id=1");

        $this->addSql("ALTER TABLE Cola CHANGE days referals_per_day INT DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE pedido ADD opinion_id INT DEFAULT NULL, ADD n_remaining_queue INT NOT NULL");
        $this->addSql("ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CE51885A6A FOREIGN KEY (opinion_id) REFERENCES pedido_opinion (id)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_C4EC16CE51885A6A ON pedido (opinion_id)");
        $this->addSql("ALTER TABLE Cola CHANGE referals_per_day days INT DEFAULT NULL");
    }
}
