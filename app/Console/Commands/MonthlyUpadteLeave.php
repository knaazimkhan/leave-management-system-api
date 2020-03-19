<?php

namespace App\Console\Commands;

use App\LeaveBalance;
use Illuminate\Console\Command;

class MonthlyUpadteLeave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update leave on every month means add 2 leave in current leave    ';

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
        $this->info('monthly leave updating plase wait....');
        
        $leave_balance = LeaveBalance::where('leave_type', 'AL')->get();
        foreach ($leave_balance as $value) {
            $value->increment('total', 2);
        }
        $this->info('done.');
    }
}
