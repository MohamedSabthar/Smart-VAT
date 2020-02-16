<?php

namespace App\Reports;

use App\License_tax_payment;

class LicenseReport
{
    public $licenseTypeDescription;
    public $payments;


    public function __construct($description, $payments)
    {
        $this->licenseTypeDescription = $description;
        $this->payments = $payments;
    }

    public static function generateLicenseReport($dates)
    {
        $records = License_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get()->map(function ($obj) {
            return new LicenseReport($obj->licenseTaxShop->licenseType->description, $obj->payment);
        });

        $table =  $records->groupBy(function ($obj) {
            return $obj->licenseTypeDescription;
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