<?php

namespace App\Console;

use Carbon\Carbon;

use App\Vat;
use App\Business_tax_payment;
use App\Business_tax_shop;
use App\Industrial_tax_payment;
use App\Industrial_tax_shop;
use App\Vat_payer;

use App\Jobs\BusinessTaxNoticeJob;

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
}