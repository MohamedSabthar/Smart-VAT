<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Vat;
use App\User_vat;
use Illuminate\Support\Arr;
use App\Http\Requests\UpdateEmployeeProfileRequest;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);  //checking for email verification
        $this->middleware('admin');               //allow if user is admin
    }

    public function manageEmployee()
    {
        $employees = User::all()->where('role', 'employee');   //get all employees details
        return view('admin.manageEmployee', ['employees'=>$employees]);
    }

    public function employeeProfile($id)
    {
        $employee = User::where('id', $id)->firstOrFail();      //returning paticular user's data
        $vats = Vat::all();                                     //returning all vat categories
        $assingedVats = User_vat::all()->where('user_id', $id)->pluck('vat_id')->all();         //returning all assigned vat categories for the user
        
        // dd($assingedVats);
        return view('profile.employeeProfile', ['employee'=>$employee,'vats'=>$vats,'assignedVats'=>$assingedVats]);
    }

    public function updateEmployeeProfile($id, UpdateEmployeeProfileRequest $request)
    {
        $employee = User::findOrFail($id);

        //updating new employee details
        $employee->name = $request->name;
        $employee->userName = $request->userName;
        $employee->nic = $request->nic;
        $employee->email = $request->email;
        $employee->phone = $request->phone;

        $employee->save();
        return redirect()->back()->with('status', 'Employee details updated successfuly');
    }

    public function assignVatCategories(Request $request)
    {
        $pastAssignedVats = User_vat::all()->where('user_id', $request->id);
        foreach ($pastAssignedVats as $userVat) {   //removing past assigned vats from the user_vats table
            $userVat->delete();
        }

        $currentAssingedVatsIds = $request->all();
        Arr::pull($currentAssingedVatsIds, '_token');
        Arr::pull($currentAssingedVatsIds, 'id');
        // dd($currentAssingedVatsIds);    //removed addition inputs other than vat id

        foreach ($currentAssingedVatsIds as $vatId) {   //creating new records for newly updated vat in user_vats table
            $userVat = new User_vat();
            $userVat->user_id = $request->id;
            $userVat->vat_id = $vatId;
            $userVat->save();
        }

        return redirect()->back()->with('status', 'Categories assigned successfully');  //redirecting back to employee-profile page with success message
    }
}