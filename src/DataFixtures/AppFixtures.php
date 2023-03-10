<?php

namespace App\DataFixtures;

use Generator;
use Faker\Factory;
use App\Entity\Tierlist;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    /*
    * @var Generator
    */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++) { 
            $tierlist = new Tierlist();
            $tierlist->setName($this->faker->word())
                ->setType('Gacha');
                
                $manager->persist($tierlist);
        }

        $manager->flush();
    }
}
