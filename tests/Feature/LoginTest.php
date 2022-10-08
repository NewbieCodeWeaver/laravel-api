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
public function user_log_in()

{

    $this->artisan('passport:install');

    $user = User::factory()
    ->create(['password' => bcrypt($password = '123456')]);

    $this->post('api/login', 
    
    ['nickname' => $user->nickname,
     'password' => $password])
    ->assertStatus(200);
    
    $this->assertAuthenticated();
}



 /** @test */

public function user_log_in_with_empty_nickname()
{

    $this->artisan('passport:install');

    $user = User::factory()
    ->create(['password' => bcrypt($password = '123456')]);

    $this->post('api/login', 
    
    ['nickname' => '',
     'password' => $password])
     ->assertInvalid([
        'nickname' => 'The nickname field is required.',

    ]);
}


 /** @test */

public function user_log_in_WithEmptyPassword()

{

    $this->artisan('passport:install');

    $user = User::factory()
    ->create(['password' => bcrypt($password = '123456')]);

    $this->post('api/login', 
    
    ['nickname' => $user->nickname,
     'password' => ""])
     ->assertInvalid([
        'password' => 'The password field is required.',

    ]);
}




}