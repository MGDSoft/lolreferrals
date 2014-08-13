<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140813203107 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE REFSEU ADD pedido_bot_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE REFSEU ADD CONSTRAINT FK_261D5655365475DB FOREIGN KEY (pedido_bot_id) REFERENCES pedido_bots (id)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_261D5655365475DB ON REFSEU (pedido_bot_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE REFSEU DROP FOREIGN KEY FK_261D5655365475DB");
        $this->addSql("DROP INDEX UNIQ_261D5655365475DB ON REFSEU");
        $this->addSql("ALTER TABLE REFSEU DROP pedido_bot_id");
    }
}
