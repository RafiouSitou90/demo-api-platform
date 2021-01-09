<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $passHash = $this->userPasswordEncoder->encodePassword($user, 'password');

            $user->setEmail($faker->email)
                ->setPassword($passHash);
            if ($i % 3 === 0) {
                $user->setIsVerified(true)
                    ->setAge(23);
            }
            $manager->persist($user);

            for ($j = 0; $j < random_int(5, 20); $j++) {
                $article = (new Article())
                    ->setAuthor($user)
                    ->setName($faker->text(50))
                    ->setContent($faker->text(300))
                ;
                $manager->persist($article);
            }
        }

        $manager->flush();
    }
}
