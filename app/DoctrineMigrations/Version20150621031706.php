<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150621031706 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE cuenta_usuario (id INT AUTO_INCREMENT NOT NULL, usuario VARCHAR(200) NOT NULL, password VARCHAR(200) NOT NULL, email VARCHAR(100) NOT NULL, usado TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE cuenta (id INT AUTO_INCREMENT NOT NULL, paypal_account_id INT NOT NULL, title_template VARCHAR(200) NOT NULL, precio DOUBLE PRECISION NOT NULL, influence_points INT NOT NULL, descripcion LONGTEXT NOT NULL, level INT NOT NULL, imagen VARCHAR(255) DEFAULT NULL, INDEX IDX_31C7BFCFCDA96122 (paypal_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE cuenta_has_cuenta_usuarios (cuenta_id INT NOT NULL, cuentausuario_id INT NOT NULL, INDEX IDX_61CEF00E9AEFF118 (cuenta_id), INDEX IDX_61CEF00EBB26F936 (cuentausuario_id), PRIMARY KEY(cuenta_id, cuentausuario_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE cuenta ADD CONSTRAINT FK_31C7BFCFCDA96122 FOREIGN KEY (paypal_account_id) REFERENCES paypal_account (id)");
        $this->addSql("ALTER TABLE cuenta_has_cuenta_usuarios ADD CONSTRAINT FK_61CEF00E9AEFF118 FOREIGN KEY (cuenta_id) REFERENCES cuenta (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE cuenta_has_cuenta_usuarios ADD CONSTRAINT FK_61CEF00EBB26F936 FOREIGN KEY (cuentausuario_id) REFERENCES cuenta_usuario (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE pedido ADD cuenta_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CE9AEFF118 FOREIGN KEY (cuenta_id) REFERENCES cuenta (id)");
        $this->addSql("CREATE INDEX IDX_C4EC16CE9AEFF118 ON pedido (cuenta_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE cuenta_has_cuenta_usuarios DROP FOREIGN KEY FK_61CEF00EBB26F936");
        $this->addSql("ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CE9AEFF118");
        $this->addSql("ALTER TABLE cuenta_has_cuenta_usuarios DROP FOREIGN KEY FK_61CEF00E9AEFF118");
        $this->addSql("DROP TABLE cuenta_usuario");
        $this->addSql("DROP TABLE cuenta");
        $this->addSql("DROP TABLE cuenta_has_cuenta_usuarios");
        $this->addSql("DROP INDEX IDX_C4EC16CE9AEFF118 ON pedido");
        $this->addSql("ALTER TABLE pedido DROP cuenta_id");
    }
}
