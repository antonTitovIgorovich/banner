<?php
/**
 * Project: banner_
 * Date: 23.05.18
 * Time: 21:18
 */

namespace App\Http\Controllers\Cabinet;


use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cabinet.home');
    }
}