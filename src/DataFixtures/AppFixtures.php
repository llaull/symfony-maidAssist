<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Intervention;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setUsername("admin");
        $user->setRoles(array('ROLE_USER','ROLE_ADMIN','GOD'));
        $user->setPassword('$2y$13$eJX6XwG95bJ5Wkb3okgdxuoTi/S2g1Pa8V.uU4TyZXZXz50bLLHm2');
        $user->setCreatedAt(new \DateTimeImmutable());
        
        $manager->persist($user);


        for ($i=0; $i < 8; $i++) { 
            $customer = new Customer();
            $customer->setName($faker->name);
            $customer->setUser($user);
            $customer->setStreet($faker->streetAddress());
            $customer->setRate($faker->numberBetween(9,19));
            $customer->setCreatedAt(new \DateTimeImmutable());
            
            $manager->persist($customer);

            $random = random_int(1, 22);
            
            for ($y=0; $y < $random; $y++) { 
                $intervention = new Intervention();
                $intervention->setCustomer($customer);
                $intervention->setUser($user);
                $intervention->setDate($faker->dateTimeBetween('-4 months', 'yesterday'));
                $intervention->setDuration($faker->numberBetween(2,6));
                $intervention->setStartAt($faker->dateTime());
                $intervention->setDonePaid($faker->boolean());
    
                $intervention->setCreatedAt(new \DateTimeImmutable());
                
                $manager->persist($intervention);
            }

        }

        

        $manager->flush();
    }
}
