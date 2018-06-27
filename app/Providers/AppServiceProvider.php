<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SmsSender;
use App\Services\Sms;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        $this->app->singleton(SmsSender::class, function (Application $app) {

            $config = $app->make('config')->get('sms');

            if (!empty($config['url'])) {
                return new Sms($config['api_id'], $config['url']);
            }
            return new Sms($config['api_id']);
        });
    }
}
