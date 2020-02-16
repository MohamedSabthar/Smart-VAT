<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

use App\User;

class Authentication extends TestCase
{
    /** @test */
    public function checkingForAuthentication()
    {
        Auth::logout(); //accessing without login
        $response = $this->get('/business');
        $response->assertStatus(302);   //should redirected to verify
        $response->assertRedirect('/email/verify');
    }

    /** @test */
    public function CheckingForvalidCredentials()
    {
        $credentials = ['username'=>'sabthar','password'=>'council@123'];
        $this->assertCredentials($credentials);
    }

    /** @test */
    public function CheckingForInvalideCredentials()
    {
        $credentials = ['username'=>'sabthar','password'=>'notLegitimate'];
        $this->assertInvalidCredentials($credentials);
    }
}