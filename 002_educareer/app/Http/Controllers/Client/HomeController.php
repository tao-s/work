<?php namespace App\Http\Controllers\Client;

use View;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function __construct()
    {
        View::share('module_key', 'home');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        return redirect('/posting');
    }

}
