<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Intervention;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface) 
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }
    
    public function load(ObjectManager $manager): void
    {

        $fakeUser = array(array("name"=>"admin","role"=>array('ROLE_USER','ROLE_ADMIN','GOD')),array("name"=>"test","role"=>array('ROLE_USER')));
        $faker = Factory::create('fr_FR');

        foreach ($fakeUser as $key => $value) {
            # code... 
        
            $user = new User();
            $user->setUsername($value["name"]);
            $user->setRoles($value["role"]);
            // $user->setPassword($this->->getParameter('app.user_admin_pwd'));
            $user->setPassword($this->userPasswordHasherInterface->hashPassword(
                $user, $value["name"]
            ));

            $user->setCreatedAt(new \DateTimeImmutable());
            
            $manager->persist($user);

            // add customers
            for ($i=0; $i < 3; $i++) { 
                $customer = new Customer();
                $customer->setName($faker->name);
                $customer->setUser($user);
                $customer->setStreet($faker->streetAddress());
                $customer->setRate($faker->numberBetween(9,19));
                $customer->setCreatedAt(new \DateTimeImmutable());
                
                $manager->persist($customer);

                $random = random_int(1, 22);
                
                // add jobs
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
        }

        

        $manager->flush();
    }
}
