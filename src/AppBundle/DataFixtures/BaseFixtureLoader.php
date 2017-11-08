<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Faker\Factory;

abstract class BaseFixtureLoader extends AbstractFixture
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed(1337);
    }
}