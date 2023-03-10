<?php

namespace App\DataFixtures;

use App\Entity\Tierlist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) { 
            $tierlist = new Tierlist();
            $tierlist->setName('Tierlist ' . $i)
                ->setType('Gacha');
                
                $manager->persist($tierlist);
        }

        $manager->flush();
    }
}
