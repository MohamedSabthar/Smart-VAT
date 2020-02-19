<?php

namespace App\Reports;

use App\Club_licence_tax_payment;

class ClubLicenceReport
{
    public $clubName;
    public $address;
    public $payments;


    public function __construct($clubName,$address, $payments)
    {
        $this->clubName = $clubName; // check club_name
        $this->address = $address;
        $this->payments = $payments;
    }

    public static function generateClubLicenceReport($dates)
    {
        $records = Club_licence_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get()->map(function ($obj) {
            return new ClubLicenceReport($obj->clubLicenceTax->club_name, $obj->clubLicenceTax->address, $obj->payment);
        });

        $table =  $records->groupBy(function ($obj) {
            return $obj->clubName; 
        })->map(function ($row) {
            return $row->sum('payments');
        });

        return $table;
    }
}
