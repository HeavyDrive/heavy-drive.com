<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\BaseFixtureLoader;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Car;

class CarData extends BaseFixtureLoader implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        $heavyData = json_decode(file_get_contents(__DIR__.'/data/CarData.json'), true);

        foreach ($heavyData as $i => $carData) {
            $car = new Car();

            $car->setDoors($carData['NB_PORTE']);
            $car->setOptions($carData['PUISSANCE_FISCALE']);
            $car->setPassengerCapacity($carData['NB_PLACE']);
            $car->setTransmission($carData['TRANSMISSION']);
            $car->setCarModel($carData['ID_MODELE']);
            $car->setCarMaker($carData['MARQUE']);

            $car->setUuid($this->faker->uuid);
            $car->setRegistration($this->faker->randomLetter . $this->faker->randomNumber(5));
            $car->setStatus($this->faker->randomDigit);
            $car->setPickUpStatus($this->faker->randomDigit);
            $car->setFirstHand($this->faker->boolean);
            $car->setDuplicateKeys($this->faker->boolean);
            $car->setChassisJig($this->faker->boolean);
            $car->setRepainted($this->faker->boolean);
            $car->setCreatedAt($this->faker->dateTime);
            $car->setEnabled($this->faker->boolean);
            $car->setFirstRegistrationAt($this->faker->dateTime);
            $car->setPickUpDoneAt($this->faker->dateTime);
            $car->setComments($this->faker->paragraph);
            $car->setPictures($this->faker->imageUrl(5));
            $car->setMileageEstimate($this->faker->randomNumber(6));
            $car->setMileageReal($this->faker->randomNumber(8));
            $car->setInteriorColor($this->faker->colorName);
            $car->setExteriorColor($this->faker->colorName);
            $car->setLastMaintenanceMileage($this->faker->randomNumber(9));

            $manager->persist($car);
        }

        $manager->flush();
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

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        // TODO: Implement getOrder() method.
        return 2;
    }
}