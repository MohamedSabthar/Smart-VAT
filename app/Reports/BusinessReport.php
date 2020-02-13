<?php

namespace App\Reports;

use App\Business_tax_payment;

class BusinessReport
{
    public $businessTypeDescription;
    public $payments;


    public function __construct($description, $payments)
    {
        $this->businessTypeDescription = $description;
        $this->payments = $payments;
    }

    public static function generateBusinessReport($dates)
    {
        $records = Business_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get()->map(function ($obj) {
            return new BusinessReport($obj->businessTaxShop->businessType->description, $obj->payment);
        });

        $table =  $records->groupBy(function ($obj) {
            return $obj->businessTypeDescription;
        })->map(function ($row) {
            return $row->sum('payments');
        });

        return $table;
    }
}

/**
 *
 *use App\Reports\BusinessReport;
 *$reportData = BusinessReport::generateBusinessReport();

 * foreach($reportData as $description => $total){
 *      html body
 *                        }
 */