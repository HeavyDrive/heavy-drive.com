<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 29/05/17
 * Time: 22:34
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\BaseFixtureLoader;
use AppBundle\Entity\Client;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ClientData extends BaseFixtureLoader implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * Useful for tests.
     */
    const GOOD_CLIENT_ID = 1;
    const SUPER_ADMIN_ID = 10;
    /** @var ContainerInterface */
    private $container;
    /** @var ObjectManager */
    private $manager;
    /** @var UserManager */
    private $userManager;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager                = $manager;
        $this->userManager            = $this->container->get('fos_user.user_manager');

        $this->createClients();
        $this->createAdmins();

        $this->manager->flush();
    }

    private function createAdmins()
    {
        $superAdmin = $this->createUser('super-admin@heavy-drive.com', ['ROLE_SUPER_ADMIN']);
        $this->createUser('admin@heavy-drive.com',      ['ROLE_HEAVY_ADMIN']);
        $this->createUser('accounting@heavy-drive.com', ['ROLE_ADMIN_ACCOUNTING']);
        $this->createUser('parc@heavy-drive.com',       ['ROLE_ADMIN_PARC']);
        $this->createUser('salesman@heavy-drive.com',   ['ROLE_ADMIN_SALESMAN']);
        $this->createUser('paper@heavy-drive.com',      ['ROLE_ADMIN_PAPERS', 'ROLE_ADMIN_CLIENT']);
        $this->setReference('client_super_admin', $superAdmin);
    }

    private function createClients()
    {
        for ($i = 1; $i < 10; ++$i) {
            $this->createUser($this->faker->safeEmail);
        }
    }

    /**
     * @param string             $email
     *
     * @return Client
     */
    private function createUser($email)
    {
        /** @var Client $client */
        $client = $this->userManager->createUser();
        $client->setEmail($email);
        $client->setPassword('heavy');
        $client->setEnabled(true);
        $client->setUsername($this->faker->userName);
        $client->setLastName($this->faker->lastName);
        $client->setTelephone($this->faker->phoneNumber);
        $client->setPlainPassword('blabla');
        $client->setFirstName($this->faker->firstName);
        $this->userManager->updateUser($client, false);

        return $client;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}