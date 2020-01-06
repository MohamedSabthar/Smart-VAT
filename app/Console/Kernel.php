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
        /**
         * sending business tax overdue notification
         */
        // $schedule->call(function () {
        //     $currentDate = Carbon::now()->toArray();
        //     $year = $currentDate['year'];
        //     foreach (Business_tax_shop::all() as $BusinessTaxShop) {
        //         $taxPayment=Business_tax_payment::where('shop_id', $BusinessTaxShop->id)->where('created_at', 'like', "%$year%")->first();
        //         if ($taxPayment==null) {
        //             // dispatch(new  BusinessTaxNoticeJob($BusinessTaxShop->payer->email, $BusinessTaxShop->payer->id));
        //             dispatch(new  BusinessTaxNoticeJob($BusinessTaxShop->payer->email, $BusinessTaxShop->id));
        //         }
        //     }
        // })
        // // ->everyMinute();
        // ->when(function () {
        //     $businessTaxDueDate = Carbon::parse(Vat::where('route', '=', 'business')->firstOrFail()->due_date)->toArray();
        //     $currentDate = Carbon::now()->toArray();
        //     if ($currentDate['month']==$businessTaxDueDate['month'] && $currentDate['day']==$businessTaxDueDate['day']) {
        //         return true;
        //     }
        // });

        /**
         * sending industrial tax overdue notification
         */
        $schedule->call(function () {
            $currentDate = Carbon::now()->toArray();
            $year = $currentDate['year'];
            foreach (Industrial_tax_shop::all() as $industrialTaxShop) {
                $taxPayment=Industrial_tax_payment::where('shop_id', $industrialTaxShop->id)->where('created_at', 'like', "%$year%")->first();
                if ($taxPayment==null) {
                    dispatch(new  BusinessTaxNoticeJob($industrialTaxShop->payer->email, $industrialTaxShop->payer->id));
                }
            }
        })
        ->everyMinute();
        // ->when(function () {
        //     $industrialTaxDueDate = Carbon::parse(Vat::where('route', '=', 'industrial')->firstOrFail()->due_date)->toArray();
        //     $currentDate = Carbon::now()->toArray();
        //     if ($currentDate['month']==$industrialTaxDueDate['month'] && $currentDate['day']==$industrialTaxDueDate['day']) {
        //         return true;
        //     }
        // });
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