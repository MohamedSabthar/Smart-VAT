<?php

namespace App\Http\Controllers\Auth;

use App\Vat_payer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\VATpayerRegisterRequest;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Auth;

class VATpayerRegisterController extends Controller
{
    
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($vat_payer = $this->create($request->all())));

        // redirecting to BUsiness VAT payers' page with success notification
        return redirect()->back()->with('status', ' New Payer registerd successfully');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */ 
    protected function validator(array $data)
    { 
        return Validator::make(
            $data,
            [
            'first_name' => ['required','alpha', 'string', 'max:255'],
            'Last_name' => ['required','alpha', 'string', 'max:255'],
            'doorNo' =>['required','alpha_num','max:100'],                              
            'street'=>['required','alpha_num', 'max:255'],
            'city'  =>['required','alpha', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:vat_payers'],        //   Validate to be a unique email
            'nic' => ['required','string','regex:/[0-9]{9}([x|X|v|V]$|[0-9]{3}$)/','unique:vat_payers'],     //   validation for nic
            'phone' => ['required','regex:/[+94|0][0-9]{9}$/'],
        ]
        );
    }

    /**
     * Create a new VAT Payer instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'Last_name' => $data['Last_name'],
            'doorNo' =>$data['doorNo'],
            'street' => $data['street'],
            'city'  => $data['city'],
            'email' => $data['email'],
            'nic'=> $data['nic'],
            'phone' => $data['phone']
        ]);
    }
}