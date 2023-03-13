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
 // Utilisation du bundle faker pour générer automatiquement des données 
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) { 
            $tierlist = new Tierlist();
            $tierlist->setName('Tierlist ' . $i)
                    ->setType($faker->randomElement(['Gacha', 'FPS', 'MMORPG', 'MOBA']));
                
                $manager->persist($tierlist);
        }

        $manager->flush();
    }
}
