<?php

namespace App\Http\Controllers\Auth;

use App\Vat_payer;
use App\Business_type;
use App\Business_tax_shop;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\VATpayerRegisterRequest;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Auth;

class VATpayerRegisterController extends Controller
{
    public function viewFrom()
    {
        $businessTypes = Business_type::all();
        return view('vatPayer.registerPayer', ['businessTypes'=>$businessTypes]);
    }

    public function register(VATpayerRegisterRequest $request)
    {   
        $this->validator($request->all())->validate();

        $vatPayer = new Vat_payer();
        $vatPayer->first_name= $request->first_name;
        $vatPayer->middle_name = $request->middle_name;
        $vatPayer->last_name = $request->last_name;
        $vatPayer->door_no = $request->door_no;
        $vatPayer->street = $request->street;
        $vatPayer->city = $request->city;
        $vatPayer->employee_id = Auth::user()->id;
        
        $vatPayer-> save();

        // redirecting to BUsiness VAT payers' page with success notification
        return redirect()->route('vat-payer-registration')->with('status', ' New Payer registerd successfully');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */ 
    public function validator(array $data)
    { 
        return Validator::make(
            $data,
            [
            'first_name' => ['required','alpha', 'string', 'max:255'],
            'last_name' => ['required','alpha', 'string', 'max:255'],
            'doorNo' =>['required','alpha_num','max:100'],                              
            'street'=>['required','alpha_num', 'max:255'],
            'city'  =>['required','alpha', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:vat_payers'],        //   Validate to be a unique email
            'nic' => ['required','string','regex:/[0-9]{9}([x|X|v|V]$|[0-9]{3}$)/','unique:vat_payers'],     //   validation for nic
            'phone' => ['required','regex:/[+94|0][0-9]{9}$/'],
        ]
        );
    }

}