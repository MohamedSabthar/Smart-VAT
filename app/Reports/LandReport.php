<?php

namespace App\Reports;

use App\Land_tax_payment;

class LandReport
{
    public $landName;
    public $address;
    public $payments;


    public function __construct($landName , $payments)
    {
        $this->land_name = $landName;
        $this->address = $address;
        $this->payments = $payments;
    }

    public static function generateLandReport()
    {
        $records = Land_tax_payment::all()->map(function ($obj) {
            return new LandReport($obj->landTax->landName, $obj->landTax->address, $obj->payment);
        });

        // ### Correct this  ###
        $table =  $records->groupBy(function ($obj) {
            return $obj->land_name;  //+ address
        })->map(function ($row) {
            return $row->sum('payments');
        });

        return $table;  // table has to output payments and the address of the premises


    }
}