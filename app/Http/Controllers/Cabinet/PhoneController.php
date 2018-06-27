<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\SmsSender;

class PhoneController extends Controller
{
    private $sms;

    public function __construct(SmsSender $sms)
    {
        $this->sms = $sms;
    }

    public function request(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            $token = $user->requestPhoneVerification(Carbon::now());
            $this->sms->send($user->phone, 'Phone verification token: ' . $token);
        } catch (\DomainException $e) {
            $request->session()->flash('error', $e->getMessage());
        }

        return redirect()->route('cabinet.profile.phone');
    }

    public function form()
    {
        return view('cabinet.profile.phone');
    }

    public function verify(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string|max:255',
        ]);

        /** @var User $user */
        $user = Auth::user();

        try {
            $user->verifyPhone($request['token'], Carbon::now());
        } catch (\DomainException $e) {
            return redirect()->route('cabinet.profile.home')->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.profile.home');
    }

    public function auth()
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isPhoneAuthEnabled()) {
            $user->disablePhoneAuth();
        } else {
            $user->enablePhoneAuth();
        }

        return redirect()->route('cabinet.profile.home');
    }
}
