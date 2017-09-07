<?php namespace App\Console\Commands;


use App\EmploymentStatus;
use Log;
use Mail;
use Carbon\Carbon;
use App\Application;
use App\ClientRep;
use App\Admin;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DailyMailJobCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'daily-mail-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        Log::info("Command {$this->name} started at {$now}.");

        //
        $this->notifyExpiringApplications();

        $now = Carbon::now()->format('Y-m-d H:i:s');
        Log::info("Command {$this->name} ended at {$now}.");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    protected function notifyExpiringApplications()
    {
        // 応募からの経過時間が24時間以上72時間以内のものを抽出
        $expiring_apps = Application::where('created_at', '<', Carbon::now()->subHours(24))
            ->where('created_at', '>', Carbon::now()->subHours(72))
            ->where('status_id', 1)
            ->get();

        foreach ($expiring_apps as $app) {

            $hour_diff = $app->created_at->diffInHours(Carbon::today());

            if ($hour_diff < 48) {
                $rounded_hour_diff = 24;
            } else if ($hour_diff >= 48 && $hour_diff < 72) {
                $rounded_hour_diff = 48;
            } else {
                $rounded_hour_diff = 72;
            }

            $app->load('job');
            $app->load('customer');

            $job = $app->job;
            $job->load('client');

            $client = $job->client;
            $customer = $app->customer;
            $customer->load('profile');

            $data = ['customer' => $customer, 'client' => $client, 'job' => $job, 'hours' => $rounded_hour_diff];
            if ($job->employment_status->id != EmploymentStatus::FullTime) {

                $emails = ClientRep::getAllRepEmails($app->job->client_id);
                // @mail 応募に対応していない通知 to Client
                Mail::queue(['text' => 'emails.client.application_not_answered_notification'], $data, function ($message) use ($emails, $rounded_hour_diff) {
                    $message->from('info@education-career.jp')
                        ->to($emails)
                        ->subject("【Education Career】応募から{$rounded_hour_diff}時間以上が経過しました");
                });

            } else {
                // @mail 応募に対応していない通知 to Admin
                $emails = Admin::getAllAdminEmails();
                Mail::queue(['text' => 'emails.admin.application_not_answered_notification'], $data, function ($message) use ($emails, $rounded_hour_diff) {
                    $message->from('info@education-career.jp')
                        ->to($emails)
                        ->subject("【Education Career】応募から{$rounded_hour_diff}時間以上が経過しました");
                });
            }
        }

    }

}
