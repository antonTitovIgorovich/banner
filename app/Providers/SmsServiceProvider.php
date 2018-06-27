<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SmsSender;
use App\Services\Sms;
use App\Services\ArraySender;
use Illuminate\Contracts\Foundation\Application;

class SmsServiceProvider extends ServiceProvider
{
    private $config;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->config = $app->make('config')->get('sms');
    }

    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        $this->app->singleton(SmsSender::class, function () {

            switch ($this->config['driver']) {
                case 'sms':
                    return $this->makeSms();
                case 'array':
                    return new ArraySender();
                default:
                    throw new \InvalidArgumentException('Undefined SMS Driver ' . $this->config['driver']);
            }

        });
    }

    protected function makeSms()
    {
        $params = $this->config['drivers']['sms'];

        return !empty($params['url']) ?
            new Sms($params['api_id'], $params['url']) :
            new Sms($params['api_id']);
    }
}