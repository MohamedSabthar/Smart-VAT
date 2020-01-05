<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Vat;

use Auth;

use App\Business_tax_shop;
use App\Industrial_tax_shop;
use App\Entertainment_tax_tickets_payment;
use App\Entertainment_tax_performance_payment;
use App\Land_tax;

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
            return view('employee.employeeDashboard');      //returning employeeDashobard if user is an Employee
        }
    }

    private function getPayerCount()
    {
        $vatPayerCounts = new VatPayerCount;
        $vatPayerCounts->business = Business_tax_shop::businessTaxPayers()->count();
        $vatPayerCounts->industrial = Industrial_tax_shop::industrialTaxPayers()->count();
        $vatPayerCounts->entertainment = Entertainment_tax_performance_payment::entertainmentPerformancePayers()->merge(Entertainment_tax_tickets_payment::entertainmentTicketPayers())->unique()->count();

        return $vatPayerCounts;
    }
}

class VatPayerCount
{
};