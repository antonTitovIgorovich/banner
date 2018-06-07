<?php

namespace App\UseCases\Auth;

use App\Entity\User;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use App\Mail\Auth\VerifyMail;
use Illuminate\Contracts\Mail\Mailer as MailerInterface;
use Illuminate\Contracts\Events\Dispatcher;

class RegisterService
{
    protected $mailer;
    protected $event;

    public function __construct(MailerInterface $mailer, Dispatcher $event)
    {
        $this->mailer = $mailer;
        $this->event = $event;
    }

    public function register(RegisterRequest $request): void
    {
        $user = User::register(
            $request['name'],
            $request['password'],
            $request['password']
        );

        $this->mailer->to($user->email)->send(new VerifyMail($user));
        $this->event->dispatch(new Registered($user));
    }

    public function verify(int $userId): void
    {
        /** @var User $user */
        $user = User::findOrFail($userId);
        $user->verify();
    }


}