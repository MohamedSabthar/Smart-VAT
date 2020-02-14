<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Authentication extends TestCase
{
   
    /** @test */
    public function tryToAccesDashboardWithoutLogin()
    {
        $response = $this->get('/home');
        $response->assertStatus(302);   //redirect to email verification
    }

    /** @test */
    public function tryToAccesDashboardWithLogin()
    {
        //get the firsrt user from database and login
          Auth::login(User::find(1)); //login as admin
  
          $response = $this->get('/home');
        $response->assertStatus(200);   //status should be 'request has succeeded'
        Auth::logout();
    }
}