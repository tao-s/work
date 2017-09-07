<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Log;
use Carbon\Carbon;
use App\Job;

class RandomizeJobsTableCommand extends Command
{

    protected $name = 'randomize-jobs-table';
    protected $description = 'updates random column of jobs table';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        Log::info("Command {$this->name} started at {$now}");

        $fun_of_life = Job::FUN_OF_LIFE;
        $private_job = Job::PRIVATE_JOB;

        $q = "UPDATE jobs SET random = round(rand() * 10000) where client_id not in ({$fun_of_life}, {$private_job})";
        DB::update(DB::raw($q));

        $q = "UPDATE jobs SET random = round(rand() * 10000) * 10000 where client_id in ({$fun_of_life}, {$private_job})";
        DB::update(DB::raw($q));

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

}
