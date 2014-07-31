<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140731212558 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("DROP TABLE REFSEU");
        $this->addSql("CREATE TABLE REFSEU (idREFSEU INT AUTO_INCREMENT NOT NULL, Username VARCHAR(20) NOT NULL, Password VARCHAR(20) DEFAULT NULL, Progress SMALLINT DEFAULT NULL, Finished SMALLINT DEFAULT NULL, BOTID VARCHAR(45) NOT NULL, DateCreated DATETIME NOT NULL, DateStarted VARCHAR(45) DEFAULT NULL, DateFinished VARCHAR(45) DEFAULT NULL, REFID VARCHAR(30) NOT NULL, INDEX IDX_261D5655C26430E (REFID), PRIMARY KEY(idREFSEU)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE REFSEU ADD CONSTRAINT FK_261D5655C26430E FOREIGN KEY (REFID) REFERENCES pedido (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

    }
}
