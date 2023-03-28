<?php

namespace App\DataFixtures;

use Generator;
use Faker\Factory;
use App\Entity\Game;
use App\Entity\User;
use App\Entity\Tierlist;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct()
    {
        ;
    }
 // Utilisation du bundle faker pour générer automatiquement des données 
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // Tierlist
        $tierlists = [];
        for ($i = 0; $i < 50; $i++) 
        { 
            $tierlist = new Tierlist();
            $tierlist->setName('Tierlist ' . $i)
                    ->setType($faker->randomElement(['Gacha', 'FPS', 'MMORPG', 'MOBA']));
                
            $tierlists[] = $tierlist;
            $manager->persist($tierlist);
        }

        // Games
        for ($g = 0; $g < 25; $g++) 
        { 
            $game = new Game();
            $game->setName('Jeux ' . $g)
            ->setType($faker->randomElement(['Gacha', 'FPS', 'MMORPG', 'MOBA']))
            ->setPlateforme($faker->randomElement(['XboxOne', 'Playstation5', 'PC', 'NintendoSwitch/DS']))
            ->setSociete($faker->randomElement(['Nintendo', 'Activision', 'Sony', 'Bethesda', 'Electronic Arts', 'Epic Games']))
            ->setPrice(mt_rand(0, 1) == 1 ? mt_rand(1, 100) : null)
            ->setDescription($faker->text(300))
            ->setIsFavorite(mt_rand(0, 1) == 1 ? true : false);

            for ($k=0; $k < mt_rand(5, 15); $k++) 
            { 
                $game->addTierlist($tierlists[mt_rand(0, count($tierlists) - 1)]);
            }

            $manager->persist($game);
        }

        // Users
        for ($i=0; $i < 10; $i++) { 
            $user = new User();
            $user->setFullName($faker->name())
                ->setPseudo($faker->firstName())
                ->setEmail($faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');

            $manager->persist($user);
        }

        $manager->flush();

}}