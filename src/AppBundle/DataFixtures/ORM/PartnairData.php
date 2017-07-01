<?php
/**
 * Created by PhpStorm.
 * User: guillaume
 * Date: 24/06/17
 * Time: 12:35
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\BaseFixtureLoader;
use AppBundle\Entity\Agency;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Partnair;

class PartnairData extends BaseFixtureLoader implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $agencyRepository = $this->container->get('doctrine')->getManagerForClass(Agency::class)->getRepository(Agency::class);
        $agences = $agencyRepository->findAll();

        foreach ($agences as $item => $agency) {

            $partnair = new Partnair();
            $partnair->setName($this->faker->name);
            $partnair->setAddress($this->faker->address);
            $partnair->setZipCode($this->faker->postcode);
            $partnair->setCity($this->faker->city);
            $partnair->setfullName($this->faker->name);
            $partnair->setEmail($this->faker->email);
            $partnair->setPhone($this->faker->phoneNumber);
            $partnair->setEnabled(true);

            $partnair->setAgency($agency);

            $manager->persist($partnair);
            $manager->flush();
        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        // TODO: Implement getOrder() method.
        return 5;
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        // TODO: Implement setContainer() method.
        $this->container = $container;

    }
}