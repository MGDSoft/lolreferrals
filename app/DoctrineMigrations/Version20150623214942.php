<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150623214942 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE pedido_has_objetos_extras (pedido_id VARCHAR(30) NOT NULL, objetoextra_id INT NOT NULL, INDEX IDX_3DA0798A4854653A (pedido_id), INDEX IDX_3DA0798AB474B826 (objetoextra_id), PRIMARY KEY(pedido_id, objetoextra_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE cuenta_has_objetos_extras (cuenta_id INT NOT NULL, objetoextra_id INT NOT NULL, INDEX IDX_83871A959AEFF118 (cuenta_id), INDEX IDX_83871A95B474B826 (objetoextra_id), PRIMARY KEY(cuenta_id, objetoextra_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE objeto_extra (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(200) NOT NULL, precio DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE pedido_has_objetos_extras ADD CONSTRAINT FK_3DA0798A4854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE pedido_has_objetos_extras ADD CONSTRAINT FK_3DA0798AB474B826 FOREIGN KEY (objetoextra_id) REFERENCES objeto_extra (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE cuenta_has_objetos_extras ADD CONSTRAINT FK_83871A959AEFF118 FOREIGN KEY (cuenta_id) REFERENCES cuenta (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE cuenta_has_objetos_extras ADD CONSTRAINT FK_83871A95B474B826 FOREIGN KEY (objetoextra_id) REFERENCES objeto_extra (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE pedido_has_objetos_extras DROP FOREIGN KEY FK_3DA0798AB474B826");
        $this->addSql("ALTER TABLE cuenta_has_objetos_extras DROP FOREIGN KEY FK_83871A95B474B826");
        $this->addSql("DROP TABLE pedido_has_objetos_extras");
        $this->addSql("DROP TABLE cuenta_has_objetos_extras");
        $this->addSql("DROP TABLE objeto_extra");
    }
}
