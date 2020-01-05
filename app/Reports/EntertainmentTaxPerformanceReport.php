<?php

namespace App\Reports;

use App\Entertainment_tax_performance_payment;

class EntertainmentTaxPerformanceReport
{
    public $entertainmentTypeDescription;
    public $payments;


    public function __construct($description, $payments)
    {
        $this->entertainmentTypeDescription = $description;
        $this->payments = $payments;
    }

    public static function generateEntertainmentTaxPerformanceReport()
    {
        $records = Entertainment_tax_performance_payment::all()->map(function ($obj) {
            return new EntertainmentTaxPerformanceReport($obj->type->description, $obj->payment);
        });

        $table =  $records->groupBy(function ($obj) {
            return $obj->entertainmentTypeDescription;
        })->map(function ($row) {
            return $row->sum('payments');
        });

        return $table;
    }
}