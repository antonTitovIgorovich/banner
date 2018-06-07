<?php

namespace Tests\Unit\Entity\User;

use Tests\TestCase;
use App\Entity\User;

class RegisterTest extends TestCase
{
    public function testRequest()
    {
        $user = User::register(
            $name = 'name',
            $email = 'email',
            $password = 'password'
        );

        self::assertNotEmpty($user);

        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);

        self::assertNotEmpty($password);
        self::assertEquals($password, $user->password);

        self::assertTrue($user->isWait());
        self::assertFalse($user->isActive());
    }

    public function testVerify()
    {
        $user = User::register('name', 'email', 'password');
        $user->verify();
        self::assertFalse($user->isWait());
        self::assertTrue($user->isActive());
    }

    public function testAlreadyVerified()
    {
        $user = User::register('name', 'email', 'password');
        $user->verify();

        $this->expectException('User is already verified.');
        $user->verify();
    }
}
