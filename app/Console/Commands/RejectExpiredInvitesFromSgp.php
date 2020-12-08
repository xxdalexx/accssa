<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Http\Guzzle\Sgp\SgpBase;

class RejectExpiredInvitesFromSgp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sgp:reject-applications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reject applications that are more than 7 days old.';

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
     * @return int
     */
    public function handle()
    {
        $applications = collect((new SgpBase)->getApplications());

        foreach ($applications as $app) {
            if (Carbon::parse($app->applyDate)->diffInDays() > 6) {
                (new SgpBase)->rejectApplication($app->id);
            }
        }
    }
}
