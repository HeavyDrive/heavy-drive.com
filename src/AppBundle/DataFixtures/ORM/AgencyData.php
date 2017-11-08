<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 29/05/17
 * Time: 22:34
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\BaseFixtureLoader;
use AppBundle\Entity\Agency;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AgencyData extends BaseFixtureLoader implements OrderedFixtureInterface, ContainerAwareInterface
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
            $agency = new Agency();
            $agency->setName($this->faker->Name);
            $agency->setSiret(rand(00000000000001,99999999999999));
            $agency->setTvaNumber('20');
            $agency->setBillingAddress($this->faker->address);
            $agency->setBillingZipCode($this->faker->postcode);
            $agency->setBillingCity($this->faker->city);
            $agency->setBillingCountry($this->faker->country);
            $agency->setEnabled(true);

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