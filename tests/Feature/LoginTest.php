<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{

use RefreshDatabase;    

/** @test */
public function user_can_log_in()

{

    $this->artisan('passport:install');

    $user = User::factory()
    ->create(['password' => bcrypt($password = '123456')]

);

    $this->post('api/login', 
    
    ['email' => $user->email,
     'password' => $password])
    ->assertStatus(200);
    
    $this->assertAuthenticated();
}



 /** @test */

public function user_cant_log_in_with_empty_email()
{

    $this->artisan('passport:install');

    $user = User::factory()
    ->create(['password' => bcrypt($password = '123456')]);

    $this->post('api/login', 
    
    ['email' => '',
     'password' => $password])
     ->assertInvalid([
        'email' => 'The email field is required.',

    ]);
}


 /** @test */

public function user_cant_log_in_with_empty_password()

{

    $this->artisan('passport:install');

    $user = User::factory()
    ->create(['password' => bcrypt($password = '123456')]);

    $this->post('api/login', 
    
    ['email' => $user->email,
     'password' => ""])
     ->assertInvalid([
        'password' => 'The password field is required.',

    ]);
}




}