<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;

class UserTest extends TestCase

{

use RefreshDatabase;

 /** @test */
 public function user_can_change_they_own_nickname()
    
    {

        $this->artisan('passport:install');
        
        Passport::actingAs(
        $user = User::factory()
        ->create());
        
        $this->put('api/players/' . $user->id, 
            ['nickname' => 'nuevo_nickname']);

        $this->assertDatabaseHas('users',
            ['nickname' => 'nuevo_nickname']);    

    }

    /** @test */
    public function user_cant_change_other_users_nickname()
    
    {

        $this->artisan('passport:install');
        
        Passport::actingAs(
        $user1 = User::factory()
        ->create());

        $user2 = User::factory()
        ->create();

        $message = "Unauthorized";
        
        $this->put('api/players/' . $user2->id, 
            ['nickname' => 'nuevo_nickname'])
            ->assertSee($message, $escaped = true);


    }


        /** @test */
        public function user_cant_change_nickname_with_empty_nickname_field()
    
        {
    
            $this->artisan('passport:install');
            
            Passport::actingAs(
                $user = User::factory()
                ->create());


            $message = "The nickname field is required.";    
            
            $this->put('api/players/' . $user->id, 
                ['nickname' => ''])->assertStatus(302);
    
    
        }


}