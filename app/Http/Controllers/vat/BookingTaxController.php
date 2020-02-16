<?php

namespace App\Http\Controllers\vat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\Booking_tax_type;
use App\Booking_tax_payment;
use Auth;
use App\Vat;
use App\Vat_payer;
use App\Http\Requests\AddBookingRequest;

class BookingTaxController extends Controller
{
    public function bookingProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        $bookingTaxType = Booking_tax_type::all();

        return view('vat.booking.bookingProfile', ['vatPayer'=>$vatPayer,'bookingTaxType'=>$bookingTaxType]);
    }

  

    // public function removePayment($id)
    // {
    //     $bookingTaxpayment =  Booking_tax_payment::find($id);
    //     $bookingTaxpayment->delete();
    //     return redirect()->back()->with('status', 'Delete Successful');
    // }

    
    // public function trashPayment($id)
    // {
    //     $bookingTaxpayment = Booking_tax_payment::onlyTrashed()->where('payer_id', $id)->get();
    //     return view('vat.booking.trashPayment', ['bookingTaxpayment'=>$bookingTaxpayment]);
    // }

    // //restore payment
    // public function restorePayment($id)
    // {
    //     $bookingTaxpayment = Booking_tax_payment::onlyTrashed()->where('id', $id);
    //     $shopId = $bookingTaxpayment->first()->shop_id;
    //     $bookingTaxpayment->restore();
    //     return redirect()->route('booking-payments', ['shop_id'=>$shopId])->with('status', 'Payment restored successfully');
    // }


    public function getBookingType(Request $request)
    {
        $search = $request->search;
        $bookingTaxType = Vat::where('route', 'booking')->firstOrFail();
       
        $bookingTaxType = Booking_tax_type::
        where('description', 'like', "%$search%");
        $data = $bookingTaxType->get(['id','description']);
        
        return response()->json(array("results"=>$data), 200);
    }

    



}
