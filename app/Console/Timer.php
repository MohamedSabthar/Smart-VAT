<?php

namespace App\Console;

use Carbon\Carbon;

use App\Vat;
use App\Business_tax_payment;
use App\Business_tax_shop;
use App\Industrial_tax_payment;
use App\Industrial_tax_shop;
use App\Land_tax_payment;
use App\Land_tax;
use App\Club_licence_tax_payment;
use App\Club_licence_tax;

use App\Vat_payer;
use App\Business_tax_due_payment;
use App\Industrial_tax_due_payment;
use App\Land_tax_due_payments;
use App\Automatic_log;

use App\Jobs\BusinessTaxNoticeJob;
use App\Jobs\IndustrialTaxNoticeJob;
use App\Jobs\LandTaxNoticeJob;
use App\Jobs\ClubLicenceTaxNoticeJob;

use Illuminate\Support\Facades\DB;

class Timer
{
    public static function trigerBusinessDue()
    {
        return function () {
            $currentDate = Carbon::now()->toArray();
            $year = $currentDate['year'];
            foreach (Business_tax_shop::all() as $BusinessTaxShop) {
                $taxPayment=Business_tax_payment::where('shop_id', $BusinessTaxShop->id)->where('created_at', 'like', "%$year%")->first();
                if ($taxPayment==null) {
                    dispatch(new  BusinessTaxNoticeJob($BusinessTaxShop->payer->email, $BusinessTaxShop->id));
                }
            }
        };
    }

    public static function trigerIndustrialDue()
    {
        return function () {
            $currentDate = Carbon::now()->toArray();
            $year = $currentDate['year'];
            foreach (Industrial_tax_shop::all() as $industrialTaxShop) {
                $taxPayment=Industrial_tax_payment::where('shop_id', $industrialTaxShop->id)->where('created_at', 'like', "%$year%")->first();
                if ($taxPayment==null) {
                    dispatch(new  IndustrialTaxNoticeJob($industrialTaxShop->payer->email, $industrialTaxShop->payer->id));
                }
            }
        };
    }

    public static function triggerLandDue()
    {
        //
    }

    public static function tiggerClubLicenceDue()
    {
        //
    }

    public static function triger($tax)
    {
        $vat = Vat::where('route', '=', $tax)->firstOrFail();
        $dueDate = Carbon::parse($vat->due_date)->toArray();
        $lastRunDate =  Automatic_log::where('vat_id', $vat->id)->get()->last();
        $lastRunDate=  $lastRunDate!=null ?  $lastRunDate->toArray() : null ;//get the last log from data base to check whether this transaction already ran or not
        $currentDate = Carbon::now()->toArray();
        return function () use ($tax,$lastRunDate) {
            $dueDate = Carbon::parse(Vat::where('route', '=', $tax)->firstOrFail()->due_date)->toArray();
            
            $currentDate = Carbon::now()->toArray();
            if ($currentDate['month']==$dueDate['month'] && $currentDate['day']==$dueDate['day'] && $lastRunDate['year']==$currentDate['year']) {
                return true;
            }
            return false;
        };
    }

    private function calculateTax($anualWorth, $assessmentAmmount, $lastPaymentDate)
    {
        $currentDate = now()->toArray();
        
        if ($lastPaymentDate!=null) {
            return ($anualWorth*($businessTax->vat_percentage/100)+$assessmentAmmount);
        }
        
        return $anualWorth*($businessTax->vat_percentage/100)+$assessmentAmmount;
    }


    public static function trigerBusinessDueTransaction()
    {
        return function () {
            DB::transaction(function () {
                $businessTax = Vat::where('name', 'Business Tax')->firstOrFail();
                $currentDate = Carbon::now()->toArray();
                $year = $currentDate['year'];
                
                foreach (Business_tax_shop::all() as $BusinessTaxShop) {
                    $taxPayment=Business_tax_payment::where('shop_id', $BusinessTaxShop->id)->where('created_at', 'like', "%$year%")->first();
                    $duePayment =Business_tax_due_payment::where('shop_id', $BusinessTaxShop->id)->first();
                    if ($duePayment==null) { //checking for previous due payments
                        $duePayment = new Business_tax_due_payment;
                        $duePayment->shop_id = $BusinessTaxShop->id;
                        $duePayment->payer_id = $BusinessTaxShop->payer->id;
                        $duePayment->due_ammount = 0;
                    }
                    if ($taxPayment==null) {    // if not paid for this year
                        // if not paid for this year add due payment
                        $duePayment->due_ammount+=$BusinessTaxShop->anual_worth*($businessTax->vat_percentage/100)+$BusinessTaxShop->businessType->assessment_ammount;
                    } else {
                        $duePayment->due_ammount = 0;
                    }
                    $duePayment->save();
                }

                $log = new Automatic_log;
                $log->vat_id = $businessTax->id;
                $log->save(); // save a log at completion of transaction
            });
        };
    }




    public static function trigerIndustrialDueTransaction()
    {
        return function () {
            DB::transaction(function () {
                $industrialTax = Vat::where('name', 'Industrial Tax')->firstOrFail();
                $currentDate = Carbon::now()->toArray();
                $year = $currentDate['year'];
                
                foreach (Industrial_tax_shop::all() as $industrialTaxShop) {
                    $taxPayment=Industrial_tax_payment::where('shop_id', $industrialTaxShop->id)->where('created_at', 'like', "%$year%")->first();
                    $duePayment =Industrial_tax_due_payment::where('shop_id', $industrialTaxShop->id)->first();
                    if ($duePayment==null) {
                        $duePayment = new Industrial_tax_due_payment;
                        $duePayment->shop_id = $industrialTaxShop->id;
                        $duePayment->payer_id = $industrialTaxShop->payer->id;
                        $duePayment->due_ammount = 0;
                    }
                    if ($taxPayment==null) {
                        // if not paid for this month add due payment
                        $duePayment->due_ammount+=$industrialTaxShop->anual_worth*($industrialTax->vat_percentage/100)+$industrialTaxShop->industrialType->assessment_ammount;
                    } else {
                        $duePayment->due_ammount = 0;
                    }
                    $duePayment->save();
                }

                $log = new Automatic_log;
                $log->vat_id = $industrialTax->id;
                $log->save(); // save a log at completion of transaction
            });
        };
    }
}