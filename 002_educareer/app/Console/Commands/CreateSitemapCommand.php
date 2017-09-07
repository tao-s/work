<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Log;
use Config;
use Storage;
use Carbon\Carbon;
use App\Job;
use App\Client;
use App\BusinessType;
use App\EmploymentStatus;
use App\JobCategory;

class CreateSitemapCommand extends Command
{

    protected $name = 'create-sitemap';
    protected $description = 'creates misc.xml';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        Log::info("Command {$this->name} started at {$now}");

        $this->create_main_sitemap();
        $this->create_craft_sitemap();

        $now = Carbon::now()->format('Y-m-d H:i:s');
        Log::info("Command {$this->name} ended at {$now}");
    }

    protected function getArguments()
    {
        return [];
    }

    protected function getOptions()
    {
        return [];
    }

    protected function create_main_sitemap()
    {
        $jobs = Job::getPublishableJobs();
        $jobs_view = view('batch.jobs')->with(compact('jobs'))->render();
        Storage::disk('public')->put('jobs.xml', $jobs_view);

        $clients = Client::getPublishableClients();
        $companies_view = view('batch.clients')->with(compact('clients'))->render();
        Storage::disk('public')->put('companies.xml', $companies_view);

        $job_category = JobCategory::all()->toArray();
        $job_category[] = ['id' => ''];
        $employment_status = EmploymentStatus::all()->toArray();
        $employment_status[] = ['id' => ''];
        $business_type = BusinessType::all()->toArray();
        $business_type[] = ['id' => ''];
        $prefecture = array_keys(Config::get('prefecture'));
        $prefecture[] = '';

        foreach ($prefecture as $pref) {
            $search_view = view('batch.search')->with(compact('job_category', 'employment_status', 'business_type', 'pref'))->render();
            Storage::disk('public')->put('search'.$pref.'.xml', $search_view);
        }
        $sitemap_view = view('batch.sitemap')->with(compact('prefecture'))->render();
        Storage::disk('public')->put('sitemap.xml', $sitemap_view);
    }

    protected function create_craft_sitemap()
    {
        $uris = DB::select("
            select
            b.uri
            from zz_elements as a
            inner join zz_elements_i18n as b
            on a.id = b.elementId

            where b.uri is not null
            and b.uri <> '__home__'
            and a.type in ('Category', 'Entry')
            and a.enabled = 1
            ");

        $sitemap_view = view('batch.magazine')->with(compact('uris'))->render();
        Storage::disk('public')->put('magazine.xml', $sitemap_view);
    }

}
