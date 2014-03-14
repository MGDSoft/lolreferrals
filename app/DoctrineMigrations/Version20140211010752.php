<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use MGD\BasicBundle\DataConstants\EstadoEnum;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140211010752 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE credits (id INT AUTO_INCREMENT NOT NULL, payment_instruction_id INT NOT NULL, payment_id INT DEFAULT NULL, attention_required TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, credited_amount NUMERIC(10, 5) NOT NULL, crediting_amount NUMERIC(10, 5) NOT NULL, reversing_amount NUMERIC(10, 5) NOT NULL, state SMALLINT NOT NULL, target_amount NUMERIC(10, 5) NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_4117D17E8789B572 (payment_instruction_id), INDEX IDX_4117D17E4C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE financial_transactions (id INT AUTO_INCREMENT NOT NULL, credit_id INT DEFAULT NULL, payment_id INT DEFAULT NULL, extended_data LONGTEXT DEFAULT NULL COMMENT '(DC2Type:extended_payment_data)', processed_amount NUMERIC(10, 5) NOT NULL, reason_code VARCHAR(100) DEFAULT NULL, reference_number VARCHAR(100) DEFAULT NULL, requested_amount NUMERIC(10, 5) NOT NULL, response_code VARCHAR(100) DEFAULT NULL, state SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, tracking_id VARCHAR(100) DEFAULT NULL, transaction_type SMALLINT NOT NULL, INDEX IDX_1353F2D9CE062FF9 (credit_id), INDEX IDX_1353F2D94C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE payments (id INT AUTO_INCREMENT NOT NULL, payment_instruction_id INT NOT NULL, approved_amount NUMERIC(10, 5) NOT NULL, approving_amount NUMERIC(10, 5) NOT NULL, credited_amount NUMERIC(10, 5) NOT NULL, crediting_amount NUMERIC(10, 5) NOT NULL, deposited_amount NUMERIC(10, 5) NOT NULL, depositing_amount NUMERIC(10, 5) NOT NULL, expiration_date DATETIME DEFAULT NULL, reversing_approved_amount NUMERIC(10, 5) NOT NULL, reversing_credited_amount NUMERIC(10, 5) NOT NULL, reversing_deposited_amount NUMERIC(10, 5) NOT NULL, state SMALLINT NOT NULL, target_amount NUMERIC(10, 5) NOT NULL, attention_required TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_65D29B328789B572 (payment_instruction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE payment_instructions (id INT AUTO_INCREMENT NOT NULL, amount NUMERIC(10, 5) NOT NULL, approved_amount NUMERIC(10, 5) NOT NULL, approving_amount NUMERIC(10, 5) NOT NULL, created_at DATETIME NOT NULL, credited_amount NUMERIC(10, 5) NOT NULL, crediting_amount NUMERIC(10, 5) NOT NULL, currency VARCHAR(3) NOT NULL, deposited_amount NUMERIC(10, 5) NOT NULL, depositing_amount NUMERIC(10, 5) NOT NULL, extended_data LONGTEXT NOT NULL COMMENT '(DC2Type:extended_payment_data)', payment_system_name VARCHAR(100) NOT NULL, reversing_approved_amount NUMERIC(10, 5) NOT NULL, reversing_credited_amount NUMERIC(10, 5) NOT NULL, reversing_deposited_amount NUMERIC(10, 5) NOT NULL, state SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE articulo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, precio DOUBLE PRECISION NOT NULL, imagen VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Cola (id INT AUTO_INCREMENT NOT NULL, days INT DEFAULT NULL, text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Contacto (id INT AUTO_INCREMENT NOT NULL, estado_id VARCHAR(30) DEFAULT NULL, email VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, mensaje LONGTEXT NOT NULL, fecha DATETIME NOT NULL, ip VARCHAR(39) NOT NULL, INDEX IDX_DE372B6A9F5A440B (estado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE cupon_descuento (id VARCHAR(30) NOT NULL, valor DOUBLE PRECISION NOT NULL, porcentaje_boo TINYINT(1) NOT NULL, n_usos INT NOT NULL, n_usados INT NOT NULL, expiracion_date DATETIME NOT NULL, fecha DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Estado (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, descripcion_admin VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_21F1E4D53A909126 (nombre), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Noticia (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, titulo VARCHAR(255) NOT NULL, noticia LONGTEXT NOT NULL, fecha DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_FE9D660ADB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE pedido (id VARCHAR(30) NOT NULL, articulo_id INT NOT NULL, estado_id INT DEFAULT NULL, cupon_id VARCHAR(30) DEFAULT NULL, email VARCHAR(100) NOT NULL, referral_link VARCHAR(255) DEFAULT NULL, ip VARCHAR(39) NOT NULL, ref_paypal VARCHAR(255) DEFAULT NULL, fecha DATETIME NOT NULL, total NUMERIC(6, 2) NOT NULL, paymentInstruction_id INT DEFAULT NULL, INDEX IDX_C4EC16CE2DBC2FC9 (articulo_id), INDEX IDX_C4EC16CE9F5A440B (estado_id), INDEX IDX_C4EC16CED7AFF6F2 (cupon_id), UNIQUE INDEX UNIQ_C4EC16CEFD913E4D (paymentInstruction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE pedido_bots (id INT AUTO_INCREMENT NOT NULL, pedido_id VARCHAR(30) DEFAULT NULL, nombre VARCHAR(255) NOT NULL, contrasena VARCHAR(255) NOT NULL, lvl INT NOT NULL, update_date DATETIME NOT NULL, creado_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_A3E5913A909126 (nombre), INDEX IDX_A3E5914854653A (pedido_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE pedido_estados (id INT AUTO_INCREMENT NOT NULL, pedido_id VARCHAR(30) NOT NULL, estado_id INT NOT NULL, descripcion LONGTEXT DEFAULT NULL, fecha DATETIME NOT NULL, INDEX IDX_4052A9464854653A (pedido_id), INDEX IDX_4052A9469F5A440B (estado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE rol (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, salt VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE usuario_roles (usuario_id INT NOT NULL, rol_id INT NOT NULL, INDEX IDX_ABE044D9DB38439E (usuario_id), INDEX IDX_ABE044D94BAB96C (rol_id), PRIMARY KEY(usuario_id, rol_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE credits ADD CONSTRAINT FK_4117D17E8789B572 FOREIGN KEY (payment_instruction_id) REFERENCES payment_instructions (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE credits ADD CONSTRAINT FK_4117D17E4C3A3BB FOREIGN KEY (payment_id) REFERENCES payments (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE financial_transactions ADD CONSTRAINT FK_1353F2D9CE062FF9 FOREIGN KEY (credit_id) REFERENCES credits (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE financial_transactions ADD CONSTRAINT FK_1353F2D94C3A3BB FOREIGN KEY (payment_id) REFERENCES payments (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE payments ADD CONSTRAINT FK_65D29B328789B572 FOREIGN KEY (payment_instruction_id) REFERENCES payment_instructions (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE Contacto ADD CONSTRAINT FK_DE372B6A9F5A440B FOREIGN KEY (estado_id) REFERENCES pedido (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE Noticia ADD CONSTRAINT FK_FE9D660ADB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)");
        $this->addSql("ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CE2DBC2FC9 FOREIGN KEY (articulo_id) REFERENCES articulo (id)");
        $this->addSql("ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CE9F5A440B FOREIGN KEY (estado_id) REFERENCES Estado (id)");
        $this->addSql("ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CED7AFF6F2 FOREIGN KEY (cupon_id) REFERENCES cupon_descuento (id)");
        $this->addSql("ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CEFD913E4D FOREIGN KEY (paymentInstruction_id) REFERENCES payment_instructions (id)");
        $this->addSql("ALTER TABLE pedido_bots ADD CONSTRAINT FK_A3E5914854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id)");
        $this->addSql("ALTER TABLE pedido_estados ADD CONSTRAINT FK_4052A9464854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE pedido_estados ADD CONSTRAINT FK_4052A9469F5A440B FOREIGN KEY (estado_id) REFERENCES Estado (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE usuario_roles ADD CONSTRAINT FK_ABE044D9DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)");
        $this->addSql("ALTER TABLE usuario_roles ADD CONSTRAINT FK_ABE044D94BAB96C FOREIGN KEY (rol_id) REFERENCES rol (id)");

        /*$this->addSql("INSERT INTO `Estado`(`id`, `nombre`, `descripcion_admin`) VALUES (".EstadoEnum::Cola.",'Queue','')");
        $this->addSql("INSERT INTO `Estado`(`id`, `nombre`, `descripcion_admin`) VALUES (".EstadoEnum::Esperando.",'Waiting','')");
        $this->addSql("INSERT INTO `Estado`(`id`, `nombre`, `descripcion_admin`) VALUES (".EstadoEnum::Fallido.",'Failed','')");
        $this->addSql("INSERT INTO `Estado`(`id`, `nombre`, `descripcion_admin`) VALUES (".EstadoEnum::Finalizado.",'Done','')");
        $this->addSql("INSERT INTO `Estado`(`id`, `nombre`, `descripcion_admin`) VALUES (".EstadoEnum::PendientePago.",'Pending Payment','')");
        $this->addSql("INSERT INTO `Estado`(`id`, `nombre`, `descripcion_admin`) VALUES (".EstadoEnum::Procesando.",'Running','')");*/

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE financial_transactions DROP FOREIGN KEY FK_1353F2D9CE062FF9");
        $this->addSql("ALTER TABLE credits DROP FOREIGN KEY FK_4117D17E4C3A3BB");
        $this->addSql("ALTER TABLE financial_transactions DROP FOREIGN KEY FK_1353F2D94C3A3BB");
        $this->addSql("ALTER TABLE credits DROP FOREIGN KEY FK_4117D17E8789B572");
        $this->addSql("ALTER TABLE payments DROP FOREIGN KEY FK_65D29B328789B572");
        $this->addSql("ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CEFD913E4D");
        $this->addSql("ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CE2DBC2FC9");
        $this->addSql("ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CED7AFF6F2");
        $this->addSql("ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CE9F5A440B");
        $this->addSql("ALTER TABLE pedido_estados DROP FOREIGN KEY FK_4052A9469F5A440B");
        $this->addSql("ALTER TABLE Contacto DROP FOREIGN KEY FK_DE372B6A9F5A440B");
        $this->addSql("ALTER TABLE pedido_bots DROP FOREIGN KEY FK_A3E5914854653A");
        $this->addSql("ALTER TABLE pedido_estados DROP FOREIGN KEY FK_4052A9464854653A");
        $this->addSql("ALTER TABLE usuario_roles DROP FOREIGN KEY FK_ABE044D94BAB96C");
        $this->addSql("ALTER TABLE Noticia DROP FOREIGN KEY FK_FE9D660ADB38439E");
        $this->addSql("ALTER TABLE usuario_roles DROP FOREIGN KEY FK_ABE044D9DB38439E");
        $this->addSql("DROP TABLE credits");
        $this->addSql("DROP TABLE financial_transactions");
        $this->addSql("DROP TABLE payments");
        $this->addSql("DROP TABLE payment_instructions");
        $this->addSql("DROP TABLE articulo");
        $this->addSql("DROP TABLE Cola");
        $this->addSql("DROP TABLE Contacto");
        $this->addSql("DROP TABLE cupon_descuento");
        $this->addSql("DROP TABLE Estado");
        $this->addSql("DROP TABLE Noticia");
        $this->addSql("DROP TABLE pedido");
        $this->addSql("DROP TABLE pedido_bots");
        $this->addSql("DROP TABLE pedido_estados");
        $this->addSql("DROP TABLE rol");
        $this->addSql("DROP TABLE usuario");
        $this->addSql("DROP TABLE usuario_roles");
    }
}
