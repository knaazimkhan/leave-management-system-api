<?php

namespace App\Console\Commands;

use App\LeaveBalance;
use Illuminate\Console\Command;

class YearlyResetLeave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:yearly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset leave yearly';

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
        $this->info('yearly leave reseting plase wait....');
        
        LeaveBalance::where('leave_type', 'AL')->update(['total' => 7, 'used' => 0]);
        LeaveBalance::where('leave_type', 'CL')->update(['total' => 7, 'used' => 0]);
        LeaveBalance::where('leave_type', 'SL')->update(['total' => 7, 'used' => 0]);
       
        $this->info('done.');
    }
}
