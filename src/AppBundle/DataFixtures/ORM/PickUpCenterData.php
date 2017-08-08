<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 24/07/17
 * Time: 00:42
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\BaseFixtureLoader;
use AppBundle\Entity\Agency;
use AppBundle\Entity\PickUpCenter;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PickUpCenterData extends BaseFixtureLoader implements OrderedFixtureInterface, ContainerAwareInterface
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
        $agencyRepository = $this->container->get('doctrine')->getManagerForClass(Agency::class)->getRepository(Agency::class);
        $agencies = $agencyRepository->findAll();

        foreach ($agencies as $agency) {
            $pickUpCenter = new PickUpCenter();
            $pickUpCenter->setAgency($agency);
            $pickUpCenter->setOpeningHours("ouvert 7/7 de 9h à 18h");
            $pickUpCenter->setEnabled($this->faker->boolean);

            $manager->persist($pickUpCenter);
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