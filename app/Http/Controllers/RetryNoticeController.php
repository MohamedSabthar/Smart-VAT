<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business_tax_shop;
use App\Jobs\BusinessTaxNoticeJob;

use Auth;

class RetryNoticeController extends Controller
{
    public function retryBusinessNotice($id, $notify)
    {
        $vatPayerMail = Business_tax_shop::find($id)->payer->email;
        //pushing mail to the queue
        dispatch(new  BusinessTaxNoticeJob($vatPayerMail, $id));
        Auth::user()->unreadNotifications->where('id', $notify)->first()->delete();
        return redirect()->back()->with('notice-status', 'Mail re-queued successfully');
    }
}