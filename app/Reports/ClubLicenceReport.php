<?php

namespace App\Reports;

use App\Club_licence_tax_payment;

class ClubLicenceReport
{
    public $clubName;
    public $address;
    public $payments;


    public function __construct($clubName, $payments)
    {
        $this->club_name = $clubName; // check club_name
        $this->address = $address;
        $this->payments = $payments;
    }

    public static function generateClubLicenceReport($dates)
    {
        $records = Club_licence_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get()->map(function ($obj) {
            return new ClubLicenceReport($obj->clubLicenceTax->clubName, $obj->clubLicenceTax->address, $obj->payment);
        });

        $table =  $records->groupBy(function ($obj) {
            return $obj->club_name; // +address
        })->map(function ($row) {
            return $row->sum('payments');
        });

        return $table;
    }
}
