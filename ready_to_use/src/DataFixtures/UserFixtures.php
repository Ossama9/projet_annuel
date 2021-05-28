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
        $user->setUsername('kearnen');
        $user->setEmail('test123@gmail.com');
        $user->setPassword($this->encoder->encodePassword($user, '123456789'));
        $user->setFirstName('Charles');
        $user->setLastName('Lefebvre');
        $user->setSignupDate(new \DateTime());
        $user->setRoles(0);
        $manager->persist($user);
        $manager->flush();
    }
}
