<?php

namespace App\Console;

use Carbon\Carbon;

use App\Vat;
use App\Business_tax_payment;
use App\Business_tax_shop;
use App\Industrial_tax_payment;
use App\Industrial_tax_shop;
use App\Vat_payer;
use App\Business_tax_due_payment;

use App\Jobs\BusinessTaxNoticeJob;

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
                    dispatch(new  BusinessTaxNoticeJob($industrialTaxShop->payer->email, $industrialTaxShop->payer->id));
                }
            }
        };
    }

    public static function triger($tax)
    {
        return function () {
            $dueDate = Carbon::parse(Vat::where('route', '=', $tax)->firstOrFail()->due_date)->toArray();
            $currentDate = Carbon::now()->toArray();
            if ($currentDate['month']==$dueDate['month'] && $currentDate['day']==$dueDate['day']) {
                return true;
            }
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
                    if ($taxPayment==null) {
                        if ($duePayment==null) {
                            $duePayment = new Business_tax_due_payment;
                            $duePayment->shop_id = $BusinessTaxShop->id;
                            $duePayment->payer_id = $BusinessTaxShop->payer->id;
                            $duePayment->due_ammount = 0;
                        }
                        // if not paid for this month add due payment
                        $duePayment->due_ammount+=$BusinessTaxShop->anual_worth*($businessTax->vat_percentage/100)+$BusinessTaxShop->businessType->assessment_ammount;
                    } else {
                        $duePayment->due_ammount = 0;
                    }
                    $duePayment->save();
                }
            });
        };
    }
}