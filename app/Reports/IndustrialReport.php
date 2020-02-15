<?php

namespace App\Reports;

use App\Industrial_tax_payment;

class IndustrialReport
{
    public $industrialTypeDescription;
    public $payments;


    public function __construct($description, $payments)
    {
        $this->industrialTypeDescription = $description;
        $this->payments = $payments;
    }

    public static function generateIndustrialReport($dates)
    {
        $records = Industrial_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get()->map(function ($obj) {
            return new IndustrialReport($obj->industrialTaxShop->industrialType->description, $obj->payment, $obj->industrialTaxShop->industrialType->id);
        });

        $table =  $records->groupBy(function ($obj) {
            return $obj->industrialTypeDescription;
        })->map(function ($row) {
            return $row->sum('payments');
        });

        return $table;
    }
}