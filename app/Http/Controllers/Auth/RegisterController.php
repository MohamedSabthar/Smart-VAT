<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Auth;

class RegisterController extends Controller
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);  //checking for email verification
        $this->middleware('admin');               //allow if user is admin
    }


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

        // redirecting to employee profile page with success notification
        return redirect()->route('employee-profile', ['id'=>$user->id])->with('status', ' Employee registerd successfully');
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
            'name' => ['required','alpha', 'string', 'max:255'],
            'userName' => ['required', 'string', 'max:255', 'unique:users'],   //   username should be unique
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nic' => ['required','string','regex:/[0-9]{9}([x|X|v|V]$|[0-9]{3}$)/','unique:users'],     //   validation for nic
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
            'name' => $data['name'],
            'userName'=> $data['userName'],
            'email' => $data['email'],
            'nic'=> $data['nic'],
            'phone' => $data['phone'],
            'password' => Hash::make('council@123'),         // default password
            'adminId' => Auth::user()->id,                   // setting up adminId FK

        ]);
    }
}