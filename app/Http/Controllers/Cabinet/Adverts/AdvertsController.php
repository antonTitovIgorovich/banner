<?php

namespace App\Http\Controllers\Cabinet\Adverts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertsController extends Controller
{
    public function index()
    {
        return view('cabinet.adverts.index');
    }
}
