<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use MGD\BasicBundle\Entity\PaypalAccount;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ScopeInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140310221136 extends AbstractMigration implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $em;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("CREATE TABLE paypal_account (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, api_username VARCHAR(255) NOT NULL, api_password VARCHAR(255) NOT NULL, api_signature VARCHAR(255) NOT NULL, dinero_para_rotar DOUBLE PRECISION NOT NULL, dinero_agregado DOUBLE PRECISION NOT NULL, dinero_agregado_total DOUBLE PRECISION NOT NULL, order_n INT NOT NULL, active TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_475E55815E237E06 (name), UNIQUE INDEX UNIQ_475E55812B65CCF8 (api_username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE paypal_accounts_payment (id INT AUTO_INCREMENT NOT NULL, pedido_id VARCHAR(30) DEFAULT NULL, paypal_account_id INT NOT NULL, precio DOUBLE PRECISION NOT NULL, descripcion LONGTEXT DEFAULT NULL, fecha DATETIME NOT NULL, INDEX IDX_5E3A10374854653A (pedido_id), INDEX IDX_5E3A1037CDA96122 (paypal_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE precio_rango (id INT AUTO_INCREMENT NOT NULL, precio DOUBLE PRECISION NOT NULL, limite DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE paypal_accounts_payment ADD CONSTRAINT FK_5E3A10374854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE paypal_accounts_payment ADD CONSTRAINT FK_5E3A1037CDA96122 FOREIGN KEY (paypal_account_id) REFERENCES paypal_account (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CE2DBC2FC9");
        $this->addSql("DROP INDEX IDX_C4EC16CE2DBC2FC9 ON pedido");
        $this->addSql("ALTER TABLE pedido ADD precio_rango_id INT DEFAULT NULL, CHANGE articulo_id n_referidos INT NOT NULL");

        $this->addSql("INSERT INTO `precio_rango` (`id`, `precio`, `limite`) VALUES
(1, 0.7, 10),
(2, 0.68, 13),
(3, 0.66, 16),
(4, 0.64, 19),
(5, 0.62, 22),
(6, 0.6, 25),
(7, 0.58, 28),
(8, 0.56, 31),
(9, 0.54, 34),
(10, 0.52, 37),
(11, 0.5, 40),
(12, 0.48, 43),
(13, 0.47, 46),
(14, 0.46, 50),
(15, 0.45, 56),
(16, 0.44, 62),
(17, 0.43, 69),
(18, 0.42, 76),
(19, 0.41, 90),
(20, 0.4, 100),
(21, 0.39, 150),
(22, 0.39, 200),
(23, 0.38, 400);
");
        $this->addSql("ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CE101DEF4D FOREIGN KEY (precio_rango_id) REFERENCES precio_rango (id)");
        $this->addSql("UPDATE `pedido` SET `precio_rango_id`=20"); // 100 referrals

        $this->addSql("CREATE INDEX IDX_C4EC16CE101DEF4D ON pedido (precio_rango_id)");

        $username=$this->container->getParameter("paypal_api_username");
        $password=$this->container->getParameter("paypal_api_password");
        $signature=$this->container->getParameter("paypal_api_signature");

        $this->addSql("INSERT INTO paypal_account (`name`,active,api_username,api_password,api_signature,dinero_para_rotar)
            VALUES ('Default',1,'$username','$password','$signature',1200)
            "
        );

        $this->addSql("ALTER TABLE pedido_bots CHANGE pedido_id pedido_id VARCHAR(30) NOT NULL");

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE paypal_accounts_payment DROP FOREIGN KEY FK_5E3A1037CDA96122");
        $this->addSql("ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CE101DEF4D");
        $this->addSql("DROP TABLE paypal_account");
        $this->addSql("DROP TABLE paypal_accounts_payment");
        $this->addSql("DROP TABLE precio_rango");
        $this->addSql("DROP INDEX IDX_C4EC16CE101DEF4D ON pedido");
        $this->addSql("ALTER TABLE pedido DROP precio_rango_id, CHANGE n_referidos articulo_id INT NOT NULL");
        $this->addSql("ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CE2DBC2FC9 FOREIGN KEY (articulo_id) REFERENCES articulo (id)");
        $this->addSql("CREATE INDEX IDX_C4EC16CE2DBC2FC9 ON pedido (articulo_id)");
        $this->addSql("ALTER TABLE pedido_bots CHANGE pedido_id pedido_id VARCHAR(30) DEFAULT NULL");
    }
}
