<?php

namespace AppBundle\DataFixtures\ORM\Reference;

use AppBundle\DataFixtures\BaseFixtureLoader;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Agency;

class AgencyData extends BaseFixtureLoader implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $agency = new Agency();
        $agency->setName('Agence 95');
        $agency->setSiret('123456789');
        $agency->setTvaNumber('20');
        $agency->setBillingAddress('15, rue de la Briqueterie');
        $agency->setBillingZipCode('95330');
        $agency->setBillingCity('Domont');
        $agency->setBillingCountry('France');
        $agency->setEnabled(true);

        $manager->persist($agency);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}