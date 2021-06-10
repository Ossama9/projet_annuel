<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('test');
        $user->setEmail('test@gmail.com');
        $user->setPassword($this->encoder->encodePassword($user, '123456789'));
        $user->setFirstName('Nicolas');
        $user->setLastName('Dupont');
        $user->setSignupDate(new \DateTime());
        $user->setRoles(0);
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('test123@gmail.com');
        $admin->setPassword($this->encoder->encodePassword($user, '123456789'));
        $admin->setFirstName('Charles');
        $admin->setLastName('Lefebvre');
        $admin->setSignupDate(new \DateTime());
        $admin->setRoles(1);
        $manager->persist($admin);

        $manager->flush();
    }
}
