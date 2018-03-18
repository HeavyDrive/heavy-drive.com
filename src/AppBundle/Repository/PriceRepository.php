<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 05/08/17
 * Time: 16:54
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Car;
use AppBundle\Entity\Price;
use AppBundle\Entity\Service;
use Doctrine\ORM\EntityRepository;

class PriceRepository extends EntityRepository
{
    public function getPriceCarByService($service, $car)
    {
        $qb = $this->createPriceQueryBuilder();

        $qb->addSelect('price.toPay');

        $qb->innerJoin('price.car', 'priceCar');
        $qb->where('priceCar.id = :car');
        $qb->setParameter('car', $car);

        $qb->innerJoin('price.service', 'priceService');
        $qb->andWhere('priceService.id = :service');
        $qb->setParameter('service', $service);

        return $qb->getQuery()->getSingleResult();
    }

    public function getPriceCar($car)
    {
        $qb = $this->createPriceQueryBuilder();

        $qb->select('price.toPay');
        $qb->addSelect('price.totalPrice');

        $qb->innerJoin('price.car', 'priceCar');
        $qb->where('priceCar.id = :car');
        $qb->setParameter('car', $car);

        return $qb->getQuery()->getResult();
    }

    public function getPriceCarForWeddingService($car)
    {
        $qb = $this->createPriceQueryBuilder();

        $qb->addSelect('price');

        $qb->innerJoin('price.car', 'priceCar');
        $qb->innerJoin('price.service', 'priceService');
        $qb->where('priceCar.id = :car');
        //$qb->andWhere('priceService.id = :service_id');
        $qb->setParameter('car', $car);


        return $qb->getQuery()->getResult();
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