<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Carbon\Carbon;
use App\Vat;
use App\Business_tax_payment;
use App\Business_tax_shop;
use App\Industrial_tax_payment;
use App\Industrial_tax_shop;
use App\Vat_payer;


use App\Console\Timer;

use App\Jobs\BusinessTaxNoticeJob;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        //    //sending business tax overdue notification
        //    $schedule->call(Timer::trigerBusinessDue())->when(Timer::triger('business'));
        //    // ->everyMinute();
        
        //    // sending industrial tax overdue notification
        //    $schedule->call(Timer::trigerIndustrialDue())
        //     // ->when(Timer::triger('industrial'));
        //    ->everyMinute();

        //    //start due payment transations
        //    $schedule->call(Timer::trigerBusinessDueTransaction())->when(Timer::triger('business'));
        //    $schedule->call(Timer::trigerIndustrialDueTransaction())->when(Timer::triger('industrial'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}