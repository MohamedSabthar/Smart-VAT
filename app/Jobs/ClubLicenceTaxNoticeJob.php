<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\ClubLicenceTaxNotice;
use Illuminate\Support\Facades\Mail;

use App\User;
//use App\Notifications\ClubLicenceTaxNoticeJobFailedNotification;
use Illuminate\Support\Facades\Notification;

class ClubLicenceTaxNoticeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mail;
    public $id; // club id
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mail, $id)
    {  
        $this->mail = $mail;
        $this->id = $id;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->mail)->send(new ClubLicenceTaxNotice($this->id)); // Sending vatpayer notification mail to Queue process
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    // public function failed(Exception $exception)
    // {
    //     $admins = User::where('role', 'admin')->get();
    //     Notification::send($admins, new ClubLicenceTaxNoticeJobFailedNotification($this->id)); //sending notification to all admins on job fail
    // }
}
