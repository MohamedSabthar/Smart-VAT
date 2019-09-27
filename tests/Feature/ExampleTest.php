<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $response->assertRedirect('/email/verify');
        dd($response);
    }
}