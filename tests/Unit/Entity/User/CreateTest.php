<?php
/**
 * Project: banner_
 * Date: 07.06.18
 * Time: 17:15
 */

namespace Tests\Unit\Entity\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Entity\User;

class CreateTest extends TestCase
{
    use DatabaseTransactions;

    public function testNew(): void
    {
        $user = User::new(
            $name = 'name',
            $email = 'email'
        );

        self::assertNotEmpty($user);

        self::assertNotEmpty($user->password);
        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);

        self::assertTrue($user->isActive());
    }
}
