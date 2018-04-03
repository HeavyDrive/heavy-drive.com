<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 01/08/17
 * Time: 22:28
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Client;
use AppBundle\Entity\Reservation;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use AppBundle\Entity\Car;

class ReservationRepository extends EntityRepository
{
    /**
     * Get all booking closed or cancel by client
     *
     * @param Client|null $user
     *
     * @return QueryBuilder
     */
    public function getReservationHistoricByClient(Client $user)
    {
        $qb = $this->createReservationQueryBuilder();

        $qb->addSelect('reservation');

        $qb->innerJoin('reservation.client', 'reservationClient');
        $qb->where('reservationClient.id = :client');
        $qb->setParameter('client', $user);

        $qb->innerJoin('reservation.car', 'reservationCar');
        $qb->andWhere('reservation.status IN (:reservationStatus)');
        $qb->setParameter('reservationStatus', [
            Reservation::STATUS_CLOSED,
            Reservation::STATUS_CANCELLED
        ]);

        return $qb;
    }

    /**
     * Get all boking
     *
     * @param Client|null $user
     *
     * @return QueryBuilder
     */
    public function getReservationByClient(Client $user)
    {
        $qb = $this->createReservationQueryBuilder();

        $qb->addSelect('reservation');

        $qb->innerJoin('reservation.client', 'reservationClient');
        $qb->where('reservationClient.id = :client');
        $qb->setParameter('client', $user);

        $qb->innerJoin('reservation.car', 'reservationCar');
        $qb->andWhere('reservation.status IN (:reservationStatus)');
        $qb->setParameter('reservationStatus', [
            Reservation::STATUS_ACCEPTED,
            Reservation::STATUS_CREATED,
            Reservation::STATUS_IN_PROGRESS,
            Reservation::STATUS_NOT_SOLD,
            Reservation::STATUS_WAITTING,
            Reservation::STATUS_SOLD
        ]);

        return $qb;
    }

    /**
     * Get all cars is not available today
     *
     * @return array|null
     */
    public function getAvailabilityCarForDay()
    {
        $date = date_create('now');
        $date->setTime(00,00,00);

        $dateFin = date_create('now');
        $dateFin->setTime(23,59,59);

        $qb = $this->createReservationQueryBuilder();

        $qb->select('reservation');

        $qb->where('reservation.dateStart between :dateDeb AND :dateFin ');
        $qb->setParameter('dateDeb', $date);
        $qb->setParameter('dateFin', $dateFin);

        if(count($qb->getQuery()->getResult()) == 0) {
            return null;
        } else {
            return $qb->getQuery()->getResult();
        }
    }

    /**
     * Get if an car is available between this period
     *
     * @param $car
     * @param $dateStart
     * @param $dateEnd
     *
     * @return array
     */
    public function getAvailabilityCarForPeriod($car, $dateStart, $dateEnd)
    {
        $qb = $this->createReservationQueryBuilder();

        $qb->select('reservation');

        $qb->innerJoin('reservation.car', 'reservationCar');
        $qb->where('reservationCar = :car');
        $qb->setParameter('car', $car);

        $qb->andWhere('reservation.dateStart <= :dateStart AND reservation.dateEnd >= :dateEnd');
        $qb->orWhere('reservation.dateStart >= :dateStart AND reservation.dateEnd <= :dateEnd');
        $qb->orWhere('reservation.dateStart >= :dateStart AND reservation.dateEnd = :dateEnd');
        $qb->orWhere('reservation.dateStart = :dateStart AND reservation.dateEnd >= :dateEnd');
        $qb->orWhere('reservation.dateStart between :dateStart AND :dateEnd');

        $qb->setParameter('dateStart', $dateStart);
        $qb->setParameter('dateEnd', $dateEnd);

        dump($qb->getQuery()->getResult());

        return $qb->getQuery()->getResult();
    }

    public function getLastBillId()
    {
        $qb = $this->createReservationQueryBuilder();
        $qb->select('reservation.bill');
        $qb->orderBy('reservation.bill', 'DESC');
        $qb->setMaxResults(1);

        return $qb->getQuery()->getResult();
    }

    /*
    * @return \Doctrine\ORM\QueryBuilder
    */
    protected function createReservationQueryBuilder()
    {
        $qb = $this->createQueryBuilder('reservation');

        return $qb;
    }
}