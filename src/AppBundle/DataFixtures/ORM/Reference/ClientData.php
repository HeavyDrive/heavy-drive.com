<?php

namespace AppBundle\DataFixtures\ORM\Reference;

use AppBundle\DataFixtures\BaseFixtureLoader;
use AppBundle\Entity\Client;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ClientData extends BaseFixtureLoader implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        
        /** @var Client $client */
        $client = $userManager->createUser();
        $client->setEmail('ashleyl@heavy-drive.com');
        $client->setUsername('ashley');;
        $client->setPassword('azerty');
        $client->setPlainPassword($this->faker->password);
        $client->setLastName($this->faker->lastName);
        $client->setTelephone($this->faker->phoneNumber);
        $client->setEnabled(true);
        $client->setRoles(['ROLE_SUPER_ADMIN']);
        $client->setFirstName($this->faker->firstName);
        $client->setAddress("11 rue claude monet");
        $client->setCity("Garges");
        $client->setZipCode(95140);

        $userManager->updateUser($client, false);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}