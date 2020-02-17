<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Vat;

use Auth;


use App\User_vat;
use App\Business_tax_shop;
use App\Industrial_tax_shop;
use App\Entertainment_tax_tickets_payment;
use App\Entertainment_tax_performance_payment;
use App\Land_tax;
use App\Club_licence_tax;
use App\Advertisement_tax_payment;
use App\Shop_rent_tax;
use App\Booking_tax_payments_type;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);  //checking for email verification
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return view('admin.adminDashboard', ['vatPayerCount'=>$this->getPayerCount()]);            //returning adminDashboard if user is an Admin
        } elseif (Auth::user()->role === 'employee') {
            $authorizedVat = User_vat::where('user_id', Auth::user()->id)->get()->map->vat;
            $authorizedVat = $authorizedVat->mapWithKeys(function ($o) {
                return [$o->route => $o];
            })->all();
            return view(
                'employee.employeeDashboard',
                ['vatPayerCount'=>$this->getPayerCount(),
                'authorizedVat'=>$authorizedVat]
            );      //returning employeeDashobard if user is an Employee
        }
    }

    private function getPayerCount()
    {
        $vatPayerCounts = new class {
        };
        $vatPayerCounts->business = Business_tax_shop::businessTaxPayers()->count();
        $vatPayerCounts->industrial = Industrial_tax_shop::industrialTaxPayers()->count();
        $vatPayerCounts->entertainment = Entertainment_tax_performance_payment::entertainmentPerformancePayers()->merge(Entertainment_tax_tickets_payment::entertainmentTicketPayers())->unique()->count();
        $vatPayerCounts->land =   Land_tax::landTaxPayers()->count();
        $vatPayerCounts->clubLicence = Club_licence_tax::clubLicenceTaxPayers()->count();
        $vatPayerCounts->advertisement = Advertisement_tax_payment::advertisementTaxPayers()->count();
        $vatPayerCounts->shoprent=Shop_rent_tax::shopRentTaxPayers()->count();
        $vatPayerCounts->booking=Booking_tax_payments_type::bookingTaxPayers()->count();

        return $vatPayerCounts;
    }
}