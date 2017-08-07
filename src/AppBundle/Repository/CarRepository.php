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
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function createCarQueryBuilder()
    {
        $qb = $this->createQueryBuilder('car');

        return $qb;
    }
}