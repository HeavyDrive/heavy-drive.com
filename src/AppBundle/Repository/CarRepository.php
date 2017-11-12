<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 01/08/17
 * Time: 19:27
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Client;
use AppBundle\Entity\Car;
use AppBundle\Entity\Reservation;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CarRepository
 *
 * @package AppBundle\Repository
 */
class CarRepository extends EntityRepository
{
    /**
     * Get car by id
     *
     * @param $id
     *
     * @return null|Car
     *
     */
    public function findById($id)
    {
        $qb = $this->createCarQueryBuilder();

        $qb->andWhere('car.id = :id');
        $qb->setParameter('id', $id);

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function createCarQueryBuilder()
    {
        $qb = $this->createQueryBuilder('car');

        return $qb;
    }
}