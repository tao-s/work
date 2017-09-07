<?php namespace App\Console\Commands;

use Log;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;
use App\Job;
use App\Upgrade;

class DeleteExpiredUpgradesCommand extends Command
{

    protected $name = 'delete-expired-upgrades';
    protected $description = 'Deletes expired upgrades';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        Log::info("Command {$this->name} started at {$now} for the date {$this->argument('date')}.");

        $date = $this->argument('date');
        $carbon = Carbon::createFromFormat('Y-m-d', $date);
        $upgrades = Upgrade::where('expire_date', '<', $carbon->format('Y-m-d'))->get();

        foreach ($upgrades as $upgrade) {
            $client_id = $upgrade->client_id;
            Job::prepareFroFreePlan($client_id);
        }

        $ids = explode(',', $upgrades->implode('id', ','));
        Upgrade::destroy($ids);

        $now = Carbon::now()->format('Y-m-d H:i:s');
        Log::info("Command {$this->name} ended at {$now} for the date {$this->argument('date')}.");
    }

    protected function getArguments()
    {
        return [
            ['date', InputArgument::REQUIRED, 'yyyy-mm-dd.'],
        ];
    }

    protected function getOptions()
    {
        return [];
    }

}
