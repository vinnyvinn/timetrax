<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TA_LOG;
use TA\Managers\AttendanceManager;
use Log;

class PullAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'imports employee attendance log to TA attendance';

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
        $log = TA_LOG::whereNull('status')->orderBy('TAid','ASC')->get();
        $results = AttendanceManager::syncAttendance($log, $log);
        $this->info($results);
    }
}
