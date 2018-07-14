<?php

use App\Http\Router\AdvertsPath;
use App\Entity\Region;
use App\Entity\Adverts\Category;

if (!function_exists('adverts_path')) {

    function adverts_path(?Region $region, ?Category $category)
    {
        return app()->make(AdvertsPath::class)
            ->withRegion($region)
            ->withCategory($category);
    }

}
