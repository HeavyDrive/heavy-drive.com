<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Service;
use Doctrine\ORM\EntityRepository;

class ServiceRepository extends EntityRepository
{

    /**
     * Get service by id
     *
     * @param $id
     *
     * @return null|Service
     *
     */
    public function findById($id)
    {
        $qb = $this->createServiceQueryBuilder();

        $qb->andWhere('service.id = :id');
        $qb->setParameter('id', $id);

        return $qb->getQuery()->getSingleResult();
    }

    public function findNameServiceById($id)
    {
        $qb = $this->createServiceQueryBuilder();

        $qb->select('service.name');
        $qb->andWhere('service.id = :id');
        $qb->setParameter('id', $id);

        return $qb->getQuery()->getResult();
    }
    /*
    * @return \Doctrine\ORM\QueryBuilder
    */
    protected function createServiceQueryBuilder()
    {
        $qb = $this->createQueryBuilder('service');

        return $qb;
    }

}