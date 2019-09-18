<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Auth;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);  //checking for email verification
    }


    public function showChangePasswordForm()
    {
        return view('auth.passwords.changepassword');
    }

    public function changePassword($id, ChangePasswordRequest $request)
    {
        //validation is done via ChangePasswordRequest
        $user=Auth::user(); //get the current user
        $user->password = Hash::make($request->new_password);
        $user->save();    //updating the password
        return redirect()->back()->with('status', 'password Changed successfully');    //redirecting back with success notification
    }
}