<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Vat;
use App\User_vat;

class Authorization extends TestCase
{
    /** @test */
    public function checkingForAuthorizationBlockUnAuthorizedEmployee()
    {
        Auth::login(User::find(2)); //login as employee who doesn't have any access
        foreach (Vat::get() as $vat) {
            $response = $this->get('/'.$vat->route);
            $response->assertStatus(403);   //status should be 'unauthorized'
        }
        Auth::logout();
    }

    /** @test */
    public function checkingForAuthorizationAllowOnlyAuthorizedRoutes()
    {
        $user = User::find(2); //get employees
        User_vat::where('user_id', $user->id)->delete(); //remove existing authorizations
        $vats = Vat::get();
        Auth::login($user);
        $i=0;
        foreach ($vats as $vat) {
            if ($i%2==0) {    //giving authorization to employees on some vat categories
                User_vat::create(['user_id'=>$user->id,'vat_id'=> $vat->id]);
            }
            $i++;
        }
        $i=0;
        
        foreach ($vats as $vat) {
            $response = $this->get('/'.$vat->route);
            echo "$vat->route \n";
            if ($i%2==0) {
                $response->assertStatus(200);
            }   //if authorized status should be 'success'
            else {
                $response->assertStatus(403);
            }   //status should be 'unauthorized'
            $i++;
        }
        Auth::logout();
    }
}