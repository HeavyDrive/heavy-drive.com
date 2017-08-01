<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 24/07/17
 * Time: 22:26
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\BaseFixtureLoader;
use AppBundle\Entity\Car;
use AppBundle\Entity\Client;
use AppBundle\Entity\PickUpCenter;
use AppBundle\Entity\Reservation;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ReservationData extends BaseFixtureLoader implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    /** @var ObjectManager */
    private $manager;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $clientRepository = $this->container->get('doctrine')->getManagerForClass(Client::class)->getRepository(Client::class);
        $clients = $clientRepository->findAll();

        $pickUpCenterRepository = $this->container->get('doctrine')->getManagerForClass(PickUpCenter::class)->getRepository(PickUpCenter::class);
        $pickUpCenters = $pickUpCenterRepository->findAll();

        $carRepository = $this->container->get('doctrine')->getManagerForClass(Car::class)->getRepository(Car::class);
        $cars = $carRepository->findAll();

        for ($i=0; $i < 10; $i++) {
            foreach ($clients as $client) {
                foreach ($pickUpCenters as $pickUpCenter) {
                    $reservation = new Reservation();
                    //$reservation->setCar($car);
                    $reservation->setClient($client);
                    $reservation->setPickUpLocationId($pickUpCenter);
                    $reservation->setDropOffLocationId($pickUpCenter);

                    $manager->persist($reservation);
                }
            }
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 8;
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}