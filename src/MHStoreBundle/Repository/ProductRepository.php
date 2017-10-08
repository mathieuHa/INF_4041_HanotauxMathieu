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
        return $qb->getQuery()->getResult();
    }

    public function searchProduct($name)
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->where('p.name LIKE :name')
            ->orWhere('p.description LIKE :name')
            ->setParameter('name', '%'.$name.'%');

        return $qb->getQuery()->getResult();
    }
}
