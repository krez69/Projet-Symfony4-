<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        //Création de faux utilisateur type "auteur"
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $fakerUser = new User();
            $fakerUser->setEmail($faker->email);
            $fakerUser->setRoles(['ROLE_SUBSCRIBER_FAKER']);
            $fakerUser->setPassword($this->passwordEncoder->encodePassword($fakerUser,'fakerpassword'));

            $manager->persist($fakerUser);
        }
        // Création d’un utilisateur de type “auteur”
        $subscriber = new User();
        $subscriber->setEmail('subscriber@monsite.com');
        $subscriber->setRoles(['ROLE_SUBSCRIBER']);
        $subscriber->setPassword($this->passwordEncoder->encodePassword(
            $subscriber,
            'subscriberpassword'
        ));

        $manager->persist($subscriber);

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'adminpassword'
        ));

        $manager->persist($admin);

        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
