<?php

namespace MHStoreBundle\Repository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllActiveProduct()
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->where('p.sold = :state')
            ->setParameter('state', false);
        ;

        // On retourne ces résultats
        return $qb->getQuery()->getResult();
    }
}