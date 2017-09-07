<?php namespace App\Http\Controllers\Admin;

use DB;
use View;
use Auth;
use App\Customer;
use App\Application;
use App\Job;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

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
        $daily_acquisitions = Customer::where('created_at', Carbon::now()->format('Y-m-d'))->count();
        $daily_applications = Application::where('created_at', Carbon::now()->format('Y-m-d'))->count();
        $current_jobs = Job::count();
        $total_customers = DB::table('customers')->count();

        return view('admin.dashboard')->with(compact(
            'daily_acquisitions',
            'daily_applications',
            'current_jobs',
            'total_customers'
        ));
    }

}
