<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\EntityRepository;


class PrecioRangoRepository extends EntityRepository
{

    public function getRowByNReferidos($nReferidos)
    {
        return $this->getEntityManager()
            ->createQuery('
            SELECT p
                FROM MGDBasicBundle:PrecioRango p
            WHERE
                p.limite >= :limite

            ORDER BY p.limite ASC
            ')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->setParameters(array('limite' => $nReferidos))
            ->getOneOrNullResult();


    }

}
