<?php
 
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
 
class UserSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */

  public function run()
    {

        DB::table('users')->insert([

    
            [
                'name' => 'Admin',
                'nickname' => 'admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin'),
                'is_admin'=> 1,
                'remember_token' => Str::random(),
            ] ,
            [
                'name' => 'User2',
                'nickname' => 'user2',
                'email' => 'user2@user2.com',
                'email_verified_at' => now(),
                'password' => Hash::make('user2'),
                'is_admin'=> NULL,
                'remember_token' => Str::random(),
            ] ,
            [
                'name' => 'User3',
                'nickname' => 'user3',
                'email' => 'user3@user3.com',
                'email_verified_at' => now(),
                'password' => Hash::make('user3'),
                'is_admin'=> NULL,
                'remember_token' => Str::random(),
            ] ,
            [
                'name' => 'User4',
                'nickname' => 'user4',
                'email' => 'user4@user4.com',
                'email_verified_at' => now(),
                'password' => Hash::make('user4'),
                'is_admin'=> NULL,
                'remember_token' => Str::random(),
            ] ,

            [
                'name' => 'User5',
                'nickname' => 'user5',
                'email' => 'user5@user5.com',
                'email_verified_at' => now(),
                'password' => Hash::make('user5'),
                'is_admin'=> NULL,
                'remember_token' => Str::random(),
            ]
        
        ]);
    }
            }