<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class EmployeeController extends Controller
{
    public function myProfile()
    {
        return view('profile.myProfile');
    }

    public function markNotification()
    {
        Auth::User()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}