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

use App\User;
use App\Notifications\BusinessTaxNoticeJobFailedNotification;
use Illuminate\Support\Facades\Notification;

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
        // $mail =  $this->id!=2 ?$this->id.'@yopmail.com' : $this->id;
        $mail = $this->id;
        Mail::to($mail)->send(new BusinessTaxNotice); // Sending vatpayer notification mail to Queue process
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new BusinessTaxNoticeJobFailedNotification($this->id)); //sending notification to all admins on job fail
    }
}