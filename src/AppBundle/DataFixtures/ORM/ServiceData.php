<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 23/06/17
 * Time: 11:36
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\BaseFixtureLoader;
use AppBundle\Entity\Agency;
use AppBundle\Entity\Service;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceData extends BaseFixtureLoader implements OrderedFixtureInterface, ContainerAwareInterface
{

    /** @var ContainerInterface */
    private $container;

    /** @var ObjectManager */
    private $manager;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 10; $i++ )
        {
            $agency = new Service();
            $agency->setName($this->faker->name);
            $agency->setCreatedAt($this->faker->dateTime);
            $agency->setDescription($this->faker->text);
            $agency->setEnabled(true);
            $agency->setAgency(null);

            $manager->persist($agency);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}