<?php

namespace App\Http\Controllers;


use App\Entity\Region;
use App\Entity\Adverts\Category;
use App\Entity\Adverts\Advert\Advert;

class HomeController extends Controller
{
    public function index()
    {
        $regions = Region::roots()->orderBy('name')->getModels();

        $categories = Category::whereIsRoot()->defaultOrder()->getModels();

        $adverts = Advert::active()->getModels();

        return view('home', compact('regions', 'categories', 'adverts'));
    }
}
