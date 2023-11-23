<?php

namespace App\Tests\Unit;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserTest extends KernelTestCase
{   
    public function getEntity(): User {
        return (new User())->setEmail("user@gmail.com")
                ->setPassword('rien')
                ->setRoles(['ROLE_USER']);
    }
    public function testEntityValidity(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity();

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(0,$errors);
    }

    public function testInvalidName(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $user = $this->getEntity();
        $user->setEmail('');
        $errors = $container->get('validator')->validate($user);
        $this->assertCount(1,$errors);

    }

    public function getTwoUsers()
    {
        $user=$this->getEntity();
        $users = static::getContainer()->get('doctrine.orm.entity_manager')->findAll()->count();
        $this->assertTrue(2 === $users);

    }
}
