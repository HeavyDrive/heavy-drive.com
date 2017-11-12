<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 11/08/17
 * Time: 16:04
 */

namespace AppBundle\Manager;


use AppBundle\Entity\BookingGuest;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;

class BookingGuestManager
{

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * ReservationManager constructor.
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry      = $registry;
        $this->entityManager = $registry->getManagerForClass(BookingGuest::class);
    }

    /**
     * Save an booking guest
     *
     * @param BookingGuest $bookingGuest
     * @param bool         $flush
     */
    public function save(BookingGuest $bookingGuest, $flush = false)
    {
        $em = $this->entityManager->persist($bookingGuest);
        $this->entityManager->flush($em);
    }

}