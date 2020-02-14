<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Authorization extends TestCase
{
    /** @test */
    public function checkingForAuthorization()
    {
        Auth::login(User::find(2)); //login as employee who doesn't have any access
        $response = $this->get('/business');
        $response->assertStatus(403);   //status should be 'unauthorized'
        Auth::logout();
    }
}