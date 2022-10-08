<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\partida;
use Laravel\Passport\Passport;

class GameTest extends TestCase

{

use RefreshDatabase;   

/** @test */
public function unauth_user_cant_get_ranking_winner() {

    
    $this->artisan('passport:install');

    
    $user= User::factory()->create();
 
    $response = $this->get('/api/players/ranking/winner');

        $this->assertGuest($guard = null); // not auth user

            $response->assertRedirect(route('login')); // redirect to login

}


/** @test */
public function auth_user_can_get_ranking_winner() {

    $this->artisan('passport:install');

    Passport::actingAs(
    User::factory()
    ->create()
    );
 
    $response = $this->get('/api/players/ranking/winner');

        $this->assertAuthenticated();


    }



/** @test */
public function unauth_user_can_get_ranking_loser() {

    $this->artisan('passport:install');

    $user= User::factory()->create();
 
    $response = $this->get('/api/players/ranking/loser');

        $this->assertGuest($guard = null); // not auth user

            $response->assertRedirect(route('login')); // redirect to login




    }


/** @test */
public function auth_user_can_get_ranking_loser() {

    $this->artisan('passport:install');

    Passport::actingAs(
    User::factory()
    ->create()
    );
 
    $response = $this->get('/api/players/ranking/loser');

        $this->assertAuthenticated();




    }


/** @test */
public function role_user_cant_get_ranking_winner() {

    $this->artisan('passport:install');

    Passport::actingAs(
        User::factory()
        ->create(['is_admin' => NULL ])); 
 
    $response = $this->get('/api/players/');

        $response->assertStatus(401); // Unauthorized


        $message = "Access denied";

            $response->assertSee($message, $escaped = true);



}



/** @test */
public function role_admin_can_get_ranking_winner() {

    $this->artisan('passport:install');

    Passport::actingAs(
        User::factory()
        ->create(['is_admin' => 1 ])); 
 
    $response = $this->get('/api/players/');

    $message = "WinsPercentage";

        $response->assertSee($message, $escaped = true);

    

}

/** @test */
public function role_admin_can_get_users_ranking() {

    $this->artisan('passport:install');

    Passport::actingAs(
        User::factory()
        ->create(['is_admin' => 1 ])); 
 
    $response = $this->get('api/players/ranking');

    $message = "PorcentajeMedioExitos";

        $response->assertSee($message, $escaped = true);

    

}




/** @test */
public function role_user_cant_get_users_ranking() {

    $this->artisan('passport:install');

    Passport::actingAs(
        User::factory()
        ->create(['is_admin' => NULL ])); 
 
    $response = $this->get('api/players/ranking');

    $response->assertStatus(401); // Unauthorized

    $message = "Access denied";

        $response->assertSee($message, $escaped = true);

    

}


/** @test */
public function role_user_can_get_they_plays() {

    $this->artisan('passport:install');

    Passport::actingAs(
       $user= User::factory()
        ->create([
        'is_admin' => NULL,
     ])); 


    $userID = $user['id'];
 
    $response = $this->get('api/players/' . $userID .  '/games');

    $response->assertOk(200);



}


/** @test */
public function role_user_cant_get_others_plays() {

    $this->artisan('passport:install');

    Passport::actingAs(
       $user= User::factory()
        ->create([
        'is_admin' => NULL,
     ])); 


    $userID = $user['id'] + 1;
 
    $response = $this->get('api/players/' . $userID .  '/games');

    $response->assertStatus(401); // Unauthorized

    $message = "Unauthorized.";

        $response->assertSee($message, $escaped = true);



}



/** @test */
public function admin_user_can_get_any_user_plays() {

    $this->artisan('passport:install');

    Passport::actingAs(
       $user= User::factory()
        ->create([
        'is_admin' => 1,
     ])); 


    $userID = $user['id'] + 1;
 
    $response = $this->get('api/players/' . $userID .  '/games');

    $response->assertStatus(200);


}



/** @test */
public function user_can_remove_they_own_plays() {

    $this->artisan('passport:install');

    Passport::actingAs(
    $user = User::factory()
       ->has(partida::factory()->count(2))
        ->create()); 

 
    $response = $this->delete('api/players/' . $user->id . '/games');


    $message = "Plays deleted successfully";

        $response->assertSee($message, $escaped = true);

    $response->assertStatus(200);


}



/** @test */
public function user_cant_remove_other_user_plays() {

    $this->artisan('passport:install');

    Passport::actingAs(
    $user = User::factory()
       ->has(partida::factory()->count(2))
        ->create()); 

 
    $response = $this->delete('api/players/{id}/games');


        $response->assertStatus(401);


}



 /** @test */
 public function auth_user_can_play_using_they_own_id()
   
 {

    $this->artisan('passport:install');
        
        Passport::actingAs(
        $user = User::factory()
        ->create());
        
        $this->post('api/players/'. $user->id . '/games');

        $this->assertDatabaseHas('partidas', [
            'user_id' => $user->id,
        ]);

        

    }

 /** @test */
 public function unth_user_cant_play()
    
    {

        $this->artisan('passport:install');
        
        $user = User::factory()
        ->create();
        
        $this->post('api/players/'. $user->id . '/games')
        ->assertRedirect(route('login')); // redirect to login

        

    }


}