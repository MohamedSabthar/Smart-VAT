<?php

namespace App\Http\Controllers\vat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking_tax;
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

        return view('vat.booking.bookingProfile', ['vatPayer'=>$vatPayer]);
    }
    public function registerBooking($id, AddBookingRequest $request)
    {
        
        $vatPayer = Vat_payer :: find($id); // get vat payer id
        $bookingTax = new Booking_tax();
        $bookingTax->place = $request->bookingPlace;
        $bookigTax->event = $request->event;
        $bookingTax->date = $request->date;
        $bookingTax->key_money =$request->keyMoney; 
        $bookingTax->time = $request->time;
        $bookingTax->additional_time = $request->addtTime;
        $bookingTax->employee_id = Auth::user()->id; // get releted employee id
        $bookingTax->payer_id =$id;
 
        $bookingTax ->save();
         
        return redirect()->route('booking-profile', ['id'=>$vatPayer->id])->with('status', 'New shop Rent Added successfully');
    }

    private function calculateTax($anualWorth, $assessmentAmmount, $lastPaymentDate)
    {
        $currentDate = now()->toArray();
        $bookingTax = Vat::where('route', 'booking')->firstOrFail();

        if ($lastPaymentDate!=null) {
            return ($anualWorth*($bookingTax->vat_percentage/100)+$assessmentAmmount)*($currentDate['year']-$lastPaymentDate['year']);
        }
        
        return $anualWorth*($bookingTax->vat_percentage/100)+$assessmentAmmount;
    }

    public function bookingPayments($shop_id)
    {
        $bookingTax = Booking_tax::findOrFail($shop_id);
        $currentDate = now()->toArray();    // get the currrent date properties
        $lastPaymentDate = $bookingTax->payments->pluck('created_at')->last(); // get the last payment date
        $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
        $paid=false;
        $duePayment = 0.0;
        
        if ($lastPaymentDate!=null && $currentDate['year'] == $lastPaymentDate['year']) { //if last_payment year matchess current year
            $paid=true; // then this year has no due
        } else {
            $assessmentAmmount = $bookingTax->assessment_ammount;
            $duePayment = $this->calculateTax($bookingTax->anual_worth, $assessmentAmmount, $lastPaymentDate);
        }
       
        return view('vat.booking.bookingPayment', ['bookingTax'=>$bookingTax,'paid'=>$paid,'duePayment'=>$duePayment]);
    } 

    public function recivebookingPayments($shop_id, Request $request)
    {
        $payerId=Booking_tax::findOrFail($shop_id)->payer->id;  //get the VAT payer id
        
        $bookingTaxpayment = new Booking_tax_payment;
        $bookingTaxpayment->payment = $request->payment;
        $bookingTaxpayment->shop_id = $shop_id;
        $bookingTaxpayment->payer_id =$payerId;
        $bookingTaxpayment->user_id = Auth::user()->id;
        $bookingTaxpayment->save();

        return redirect()->back()->with('sucess', 'Payment added successfuly');
    }

    public function viewQuickPayments()
    {
        return view('vat.booking.bookingQuickPayments');
    }

    public function checkPayments(Request $request)
    {
        $data['payerDetails'] = Vat_payer::where('nic', $request->nic)->first();
        if ($data['payerDetails'] != null) {
            $data['duePaymentValue'] = [];
            $data['duePayments']=[];
            $currentDate = now()->toArray();    // get the currrent date properties
            $year = $currentDate['year'];
            $i =0;
            
            foreach ($data['payerDetails']->booking as $shop) {
                $lastPaymentDate = $shop->payments->pluck('created_at')->last(); // get the last payment date
                $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
                $assessmentAmmount = $shop->assessment_ammount;
                $data['duePaymentValue'][$i] = $this->calculateTax($shop->anual_worth, $assessmentAmmount, $lastPaymentDate);
                $data['duePayments'][$i]=  Booking_tax_payment::where('shop_id', $shop->id)->where('created_at', 'like', "%$year%")->first(); //getting the latest payment if paid else null
                $i++;
            }
        }
        return response()->json($data, 200);
    }


    public function acceptQuickPayments(Request $request)
    {
        $shopIds = $request->except(['_token']);
        
        if (count($shopIds)==0) {
            return redirect()->back()->with('error', 'No payments selected');
        }
        
        foreach ($shopIds as $shopId => $val) {
            $bookingTax= Booking_tax::findOrFail($shopId);  //get the VAT payer id
            $payerId = $bookingTax->payer->id;
            $lastPaymentDate = $bookingTax->payments->pluck('created_at')->last(); // get the last payment date
            $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
            $assessmentAmmount = $bookingTax->assessment_ammount;
            
            $duePayment = $this->calculateTax($bookingTax->anual_worth, $assessmentAmmount, $lastPaymentDate);
            $bookingTaxpayment = new Booking_tax_payment;
            $bookingTaxpayment->payment = $duePayment;
            $bookingTaxpayment->shop_id = $shopId;
            $bookingTaxpayment->payer_id =$payerId;
            $bookingTaxpayment->user_id = Auth::user()->id;
    
            $bookingTaxpayment->save();
        }
    
        return redirect()->back()->with('status', 'Payments successfully accepted');
    }

    public function removePayment($id)
    {
        $bookingTaxpayment =  Booking_tax_payment::find($id);
        $bookingTaxpayment->delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    
    public function trashPayment($id)
    {
        $bookingTaxpayment = Booking_tax_payment::onlyTrashed()->where('payer_id', $id)->get();
        return view('vat.booking.trashPayment', ['bookingTaxpayment'=>$bookingTaxpayment]);
    }

    //restore payment
    public function restorePayment($id)
    {
        $bookingTaxpayment = Booking_tax_payment::onlyTrashed()->where('id', $id);
        $shopId = $bookingTaxpayment->first()->shop_id;
        $bookingTaxpayment->restore();
        return redirect()->route('booking-payments', ['shop_id'=>$shopId])->with('status', 'Payment restored successfully');
    }


    public function removeBooking($shop_id)
    {
        $bookingTax = Booking_tax::find($shop_id);
        $bookingTax-> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    public function trashBooking($payer_id)
    {
        $bookingTax = Booking_tax::onlyTrashed()->where('payer_id', $payer_id)->get();
        return view('vat.booking.trashBooking', ['bookingTax'=>$bookingTax]);
    }

    public function restoreBooking($id)
    {
        $bookingTax = Booking_tax::onlyTrashed()->where('id', $id);
        $payerId = $bookingTax->first()->payer_id;
        $bookingTax->restore();
        return redirect()->route('booking-profile', ['id'=>$payerId])->with('status', 'shop restored successfully');
    }



}
