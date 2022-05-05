<?php

namespace App\DataFixtures;

use App\Entity\Customers;
use App\Entity\Products;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($p = 1; $p <= 30; $p++){
            $product = (new Products())->setName('SamSung ps'.$p)
                ->setDescription("Une petite description pour gérer le test et voir si ça couvre toutes les fonctionnalité de base")
                ->setPrice(rand(150, 1800))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setStock(rand(0, 40));

            $manager->persist($product);
        }

        $customer = new Customers();
            $customer->setEmail("bouygue@bilmo.com")
            ->setPassword($this->hasher->hashPassword($customer, "password"))
            ->setCompany("Bouygue Telecome")
            ->setCreatedAt(new \DateTimeImmutable())
            ;

        $manager->persist($customer);

        for ($u = 1; $u <= 3; $u++){
            $user = new Users();
                $user->setFirstName("Utilisateur N° ".$u)
                    ->setLastName("prénom de l'utilisateur N° ".$u)
                    ->setEmail("user$u@bilmo.com")
                    ->setPassword($this->hasher->hashPassword($user, 'password'))
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setCustomer($customer);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
