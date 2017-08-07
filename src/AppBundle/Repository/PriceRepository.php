<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 05/08/17
 * Time: 16:54
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Car;
use AppBundle\Entity\Service;
use Doctrine\ORM\EntityRepository;

class PriceRepository extends EntityRepository
{
    public function getPriceCarByService($service,  $car)
    {
        $qb = $this->createPriceQueryBuilder();

        $qb->addSelect('price');

        $qb->innerJoin('price.car', 'priceCar');
        $qb->where('priceCar.id = :car');
        $qb->setParameter('car', $service);

        $qb->innerJoin('price.service', 'priceService');
        $qb->andWhere('priceService.id = :service');
        $qb->setParameter('service', $car);

        return $qb;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function createPriceQueryBuilder()
    {
        $qb = $this->createQueryBuilder('price');

        return $qb;
    }
}