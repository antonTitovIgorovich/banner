<?php

namespace App\UseCases\Auth;

use App\Entity\User;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\Auth\VerifyMail;


class RegisterService
{
    public function register(RegisterRequest $request): void
    {
        $user = User::register(
            $request['name'],
            $request['password'],
            $request['password']
        );
        Mail::to($user->email)->send(new VerifyMail($user));
        event(new Registered($user));
    }

    public function verify(int $userId): void
    {
        /** @var User $user */
        $user = User::findOrFail($userId);
        $user->verify();
    }


}