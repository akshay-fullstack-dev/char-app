<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Carbon\Carbon;

class dailyUserStatusCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customCron:trialOver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to the user trial period if or changed then update their status';

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
    public function handle()
    {
        $app_trial_period = env('APP_TRIAL_DAYS', '5');
        $sub_days_from_trial = Carbon::now()->subDays($app_trial_period);
        $users = User::where('status', User::inActiveStatus)->where('created_at', '<=', $sub_days_from_trial)->get();
        $trial_over_users_id = array();
        if ($users->count()) {
            foreach ($users as $user) {
                array_push($trial_over_users_id, $user->id);
            }
            $tial_over = User::whereIn('id', $trial_over_users_id)->update(array('status' =>  User::trialOver));
        }
    }
}
