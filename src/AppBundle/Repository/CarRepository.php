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

    public function getCarAvailability()
    {
        $qb = $this->createCarQueryBuilder();

        $qb->where('car.status = :status');
        $qb->setParameter('status', Car::STATUS_AVAILABLE);

        return $qb;
    }

    public function getWhatYouWant(array $cars)
    {
        $qb = $this->createCarQueryBuilder();
        $qb->where('car.id NOT IN (?1)')
            ->setParameter(1, $cars);

        return $qb->getQuery()
            ->getResult();
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