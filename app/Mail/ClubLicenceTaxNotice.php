<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\club_licence_tax;
use App\Vat;

use Carbon\Carbon;

class ClubLicenceTaxNotice extends Mailable
{
    use Queueable, SerializesModels;
    private $id;
    private $duePayment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id=$id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $club = club_licence_tax::find($this->id);
        $date = Carbon::now();
        $year = $date->toArray()['year'];
        $duePayment = $this->calculateTax($this->id);
        return $this->markdown('mail.clubLicenceTaxNotice', ['club'=>$club,'date'=>$date,'year'=>$year,'duePayment'=>$duePayment]);
    }

    private function calculateTax($clubId)
    {
        $licenceTaxClub = club_licence_tax::findOrFail($clubId);  //get the VAT payer id
            
        $clubLicenceTax = Vat::where('name', 'Club Licence Tax')->firstOrFail();
        $dueAmmount = $clubLicenceTax->due==null ? 0 : $licenceTaxClub->due->due_amount;
        return $licenceTaxClub->anual_worth*($clubLicenceTax->vat_percentage/100) + $dueAmmount;
    }
}
