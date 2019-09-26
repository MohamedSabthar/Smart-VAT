<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Auth;

class VATpayerRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * overriding registerfuntion
     *
     *
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);  //autologin after registration dissabled

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
            'f_name' => ['required','alpha', 'string', 'max:255'],
            'L_name' => ['required','alpha', 'string', 'max:255'],
            'doorNo' =>['required','alpha','varchar','max:100'],                              
            'street'=>['required','alpha', 'string', 'max:255'],
            'city'  =>['required','alpha', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:vat_payers'],        //   Validate to be a unique email
            'nic' => ['required','string','regex:/[0-9]{9}([x|X|v|V]$|[0-9]{3}$)/','unique:vat_payers'],     //   validation for nic
            'phone' => ['required','regex:/[+94|0][0-9]{9}$/'],
        ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'f_name' => $data['f_name'],
            'L_name' => $data['L_name'],
            'doorNo' =>$data['doorNo'],
            'street' => $data['street'],
            'city'  => $data['city'],
            'email' => $data['email'],
            'nic'=> $data['nic'],
            'phone' => $data['phone'],
            'password' => Hash::make('council@123'),         // default password
            'adminId' => Auth::user()->id,                   // setting up adminId FK

        ]);
    }
}