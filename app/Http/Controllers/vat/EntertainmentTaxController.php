<?php

namespace App\Http\Controllers\Vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\AddEntertainmentTicketPaymentRequest;

use Auth;

use App\Vat_payer;
use App\Entertainment_type;
use App\Entertainment_tax_tickets_payment;

class EntertainmentTaxController extends Controller
{
    private function calculateTicketTax($id, $ticketAmmout, $effectiveTickets)
    {
        $entertainmentType = Entertainment_type::find($id);
        return $effectiveTickets*$ticketAmmout*($entertainmentType->vat_percentage/100);
    }

    public function entertainmentPayments($id)
    {
        $vatPayer = Vat_payer::find($id);
        $ticketTypes = Entertainment_type::all();
        return view('vat.entertainment.entertainmentPayments', ['vatPayer'=>$vatPayer,'ticketTypes'=>$ticketTypes]);
    }

    public function reciveEntertainmentPayments($id, AddEntertainmentTicketPaymentRequest $request)
    {
        $entertainmentTicketPayment = new Entertainment_tax_tickets_payment;
        $entertainmentTicketPayment->type_id = $request->ticketType;
        $entertainmentTicketPayment->payer_id = $id;
        $entertainmentTicketPayment->user_id = Auth::user()->id;
        $entertainmentTicketPayment->place_address = $request->placeAddress;
        $entertainmentTicketPayment->ticket_price = $request->ticketPrice;
        $entertainmentTicketPayment->quoted_tickets = $request->quotedTickets;
        $entertainmentTicketPayment->payment = $this->calculateTicketTax($request->ticketType, $request->ticketPrice, $request->quotedTickets);
        $entertainmentTicketPayment->save();

        return redirect()->back()->with('status', 'Payments successfully accepted');
    }
}