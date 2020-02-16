<?php

namespace App\Http\Controllers\vat;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleParkTaxController extends Controller
{
    public function _construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware(['vat']);
    }
    
    public function ticketingOfficers()
    {
        return view('vat.vehiclePark.vehicleParkTicketingOfficers');
    }

    public function vehicleParkPayments()
    {
        return view('vat.vehiclePark.vehicleParkPayments');
    }
}