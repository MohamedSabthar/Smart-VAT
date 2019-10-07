<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

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
        Auth::login(User::find(1));

        $response = $this->get('/home');
        $response->assertStatus(200);   //status should be 'request has succeeded'
    }
}