<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 24/07/17
 * Time: 00:25
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\BaseFixtureLoader;
use AppBundle\Entity\Car;
use AppBundle\Entity\Price;
use AppBundle\Entity\Service;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PriceData extends BaseFixtureLoader implements OrderedFixtureInterface, ContainerAwareInterface
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
        $carRepository = $this->container->get('doctrine')->getManagerForClass(Car::class)->getRepository(Car::class);
        $cars = $carRepository->findAll();

        $serviceRepository = $this->container->get('doctrine')->getManagerForClass(Service::class)->getRepository(Service::class);
        $services = $serviceRepository->findAll();

        foreach ($cars as $car) {
            foreach ($services as $service) {
                $price = new Price();
                $price->setCar($car);
                $price->setService($service);
                $price->setToPay($this->faker->randomFloat(5, 1000, null));
                $price->setCreatedAt($this->faker->dateTime);
                $price->setUpdatedAt($this->faker->dateTime);

                $manager->persist($price);
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
        return 6;
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