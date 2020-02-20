<?php

namespace App\Reports;

use App\Land_tax_payment;

class LandReport
{
    public $landName;
    public $address;
    public $payments;


    public function __construct($landName , $payments, $address)
    {
        $this->landName = $landName; // get land name
        $this->address = $address;
        $this->payments = $payments;
    }

    public static function generateLandReport($dates)
    {
        $records = Land_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get()
        ->map(function ($obj) {
            //dd($obj->landTax->land_name);
            return new LandReport($obj->landTax->land_name, $obj->payment, $obj->landTax->address);
        });
//dd($records->map->landTax);
        
        $table =  $records->groupBy(function ($obj) {
            return $obj->landName;  
        })->map(function ($row) {
            return $row->sum('payments');
        });

        return $table;  // table has to output payments and the address of the premises


    }
}