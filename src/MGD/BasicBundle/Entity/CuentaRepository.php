<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\EntityRepository;
use MGD\BasicBundle\Entity\Pedido;

/**
 * PedidoBots
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CuentaRepository extends EntityRepository
{
    /**
     * @return Cuenta
     */
    public function getAllAvailable()
    {
        $sql="
            SELECT p
            FROM MGDBasicBundle:Cuenta p
            JOIN p.cuentaUsuarios cu
            WHERE
                cu.usado = false
                ORDER BY p.precio ASC
                "
        ;

        return $this->getEntityManager()
            ->createQuery($sql)
            ->getResult();
        ;
    }
}
