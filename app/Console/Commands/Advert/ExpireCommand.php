<?php

namespace App\Console\Commands\Advert;

use App\Entity\Adverts\Advert\Advert;
use App\UseCases\Adverts\AdvertService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ExpireCommand extends Command
{

    /* @var AdvertService */
    private $service;

    protected $signature = 'advert:expire';

    public function __construct(AdvertService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle(): bool
    {
        $success = true;
        /** @var Advert[] $adverts */
        $adverts = Advert::active()->where('expired_at', '<', Carbon::now())->cursor();

        foreach ($adverts as $advert) {
            try {
                $this->service->expire($advert);
            } catch (\DomainException $e) {
                $this->error($e->getMessage());
                $success = false;
            }
        }

        $this->info('Command executed successfully!');
        return $success;
    }
}
