<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword(
            $this->encoder->encodePassword($admin, '0000')
        );
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setEmail('admin@charities.test');
        $manager->persist($admin);

        $user = new User();
        $user->setUsername('user');
        $user->setPassword(
            $this->encoder->encodePassword($user, '0000')
        );
        $user->setRoles(array('ROLE_USER'));
        $user->setEmail('user@charities.test');
        $manager->persist($user);

        $manager->flush();
    }
}
