<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{

    use RefreshDatabase;

     /** @test */
     public function user_can_register()

     {

     $this->artisan('passport:install');

     $this->post('api/players', [
     'name' => 'user6',
     'nickname' => 'user6',
     'email' => 'user6@user6.com',
     'password' => 'user6',
     'password_confirmation' => 'user6'])
     ->assertStatus(200);
         $this->assertDatabaseCount('users', 1);
    
    }
 
 
 
   /** @test */
      public function user_can_register_with_empty_name()
     
      {

        $this->artisan('passport:install');

        $this->post('api/players', [
        'name' => "",
        'nickname' => 'user2',
        'email' => 'user2@user2.net',
        'password' => '123456',
        'password_confirmation' => '123456'
        ])
        ->assertStatus(200);
     
      }

   /** @test */
   public function user_gets_anonimo_username_when_leaves_nickname_empty()
     
   {

     $this->artisan('passport:install');

     $this->post('api/players', [
     'name' => "user2",
     'nickname' => '',
     'email' => 'user2@user2.net',
     'password' => '123456',
     'password_confirmation' => '123456'
     ]);
     $this->assertDatabaseHas('users', [
      'nickname' => 'Anonimo',
  ]);
  
   }

 
 
 
  /** @test */
   public function user_cant_register_with_empty_password()
   
   {

    $this->artisan('passport:install');

     $this->post('api/players', [
     'name' => "user2",
     'nickname' => 'user2',
     'email' => 'user2@user2.net',
     'password' => '',
     'password_confirmation' => '123456'
     ])
     ->assertInvalid([
      'password' => 'The password field is required.',
 
  ]);
  
   }
 
 
 
 /** @test */
 public function user_cant_register_with_empty_password_confirmation()
 
 {

   $this->artisan('passport:install');

   $this->post('api/players', [
   'name' => "user2",
   'nickname' => 'user2',
   'email' => 'user2@user2.net',
   'password' => '123456',
   'password_confirmation' => ''
   ])
   ->assertInvalid([
    'password' => 'The password confirmation does not match.',
 
   
 
 
 ]);
 
  
     }
}
