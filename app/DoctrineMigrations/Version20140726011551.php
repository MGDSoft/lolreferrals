<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140726011551 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE REFSEU (idREFSEU INT NOT NULL, Username VARCHAR(20) NOT NULL, Password VARCHAR(20) DEFAULT NULL, REFID VARCHAR(45) NOT NULL, Progress SMALLINT DEFAULT NULL, Finished SMALLINT DEFAULT NULL, BOTID VARCHAR(45) NOT NULL, DateCreated DATETIME NOT NULL, DateStarted VARCHAR(45) DEFAULT NULL, DateFinished VARCHAR(45) DEFAULT NULL, PRIMARY KEY(idREFSEU, Username)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE REFSEU");
    }
}
