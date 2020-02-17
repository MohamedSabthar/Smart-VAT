<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use Auth;
use App\User;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);  //checking for email verification
        $this->middleware('admin');               //allow if user is admin
    }
    
    public function myProfile()
    {
        return view('profile.myProfile');
    }

    public function markNotification()
    {
        Auth::User()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function updateProfile($id, UpdateProfileRequest $request)
    {
        $employee = User::findOrFail($id);

        //updating new employee details
        $employee->name = $request->name;
        $employee->userName = $request->userName;
        $employee->email = $request->email;
        $employee->phone = $request->phone;

        $employee->save();
        return redirect()->back()->with('status', 'Your details updated successfuly');
    }
}