<?php

namespace Tests\Unit\Entity\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Entity\User;
use Illuminate\Support\Carbon;

class PhoneTest extends TestCase
{
    use DatabaseTransactions;

    public function testDefault()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => null,
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);

        self::assertFalse($user->isPhoneVerified());
    }

    public function testRequestEmptyPhone()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => null,
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);

        $this->expectExceptionMessage('Phone number is empty.');
        $user->requestPhoneVerification(Carbon::now());
    }

    public function testRequest()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '380000000',
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);

        $token = $user->requestPhoneVerification(Carbon::now());

        self::assertFalse($user->isPhoneVerified());
        self::assertNotEmpty($token);
    }

    public function testRequestWithOldPhone()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '380000000',
            'phone_verified' => true,
            'phone_verify_token' => null,
        ]);

        self::assertTrue($user->isPhoneVerified());

        $user->requestPhoneVerification(Carbon::now());

        self::assertFalse($user->isPhoneVerified());
        self::assertNotEmpty($user->phone_verify_token);
    }

    public function testRequestAlreadySentTimeout()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '380000000',
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);

        $user->requestPhoneVerification(Carbon::now());
        $user->requestPhoneVerification(Carbon::now()->addSeconds(500));

        self::assertFalse($user->isPhoneVerified());
    }

    public function testRequestAlreadySent()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '380000000',
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);

        $user->requestPhoneVerification(Carbon::now());
        $this->expectExceptionMessage('Token is already requested.');
        $user->requestPhoneVerification(Carbon::now()->addSeconds(15));
    }

    public function testVerify()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '380000000',
            'phone_verified' => false,
            'phone_verify_token' => $token = 'token',
            'phone_verify_token_expire' => $now = Carbon::now(),
        ]);

        self::assertFalse($user->isPhoneVerified());
        $user->verifyPhone($token, $now->copy()->subSeconds(15));
        self::assertTrue($user->isPhoneVerified());
    }

    public function testVerifyIncorrectToken()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '380000000',
            'phone_verified' => false,
            'phone_verify_token' => 'token',
            'phone_verify_token_expire' => $now = Carbon::now(),
        ]);

        $this->expectExceptionMessage('Incorrect verify token.');
        $user->verifyPhone('other_token', $now->copy()->subSeconds(15));
    }

    public function testVerifyExpiredToken()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '380000000',
            'phone_verified' => false,
            'phone_verify_token' => $token = 'token',
            'phone_verify_token_expire' => $now = Carbon::now(),
        ]);

        $this->expectExceptionMessage('Token is expired.');
        $user->verifyPhone($token, $now->copy()->addSeconds(500));
    }
}
