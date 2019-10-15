<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\BusinessTaxNotice;
use Illuminate\Support\Facades\Mail;

class BusinessTaxNoticeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail =  $this->id!=2 ?$this->id.'@yopmail.com' : $this->id;
        // dd($mail);
        echo($mail);
        Mail::to($mail)->send(new BusinessTaxNotice); // Sending mail to Queue process
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Mail::to('sabtharugc0@gmail.com')->send(new BusinessTaxNotice);
    }
}
