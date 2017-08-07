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

        dump($qb);

        return $qb;
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