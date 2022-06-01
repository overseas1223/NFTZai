<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'first_name'=>'Mr.',
            'last_name'=>'Admin',
            'email'=>'admin@email.com',
            'role'=>USER_ROLE_ADMIN,
            'status'=>STATUS_SUCCESS,
            'is_verified'=>1,
            'password'=>\Illuminate\Support\Facades\Hash::make('123456'),
        ]);
        User::insert([
            'first_name'=>'John',
            'last_name'=>'Doe',
            'bio' => 'Wonderful serenity has taken possession of my entire soul, these mornings',
            'photo' => '1.jpg',
            'country' => 'Australia',
            'email'=>'user1@email.com',
            'role'=>USER_ROLE_USER,
            'status'=>STATUS_SUCCESS,
            'is_verified'=>1,
            'password'=>\Illuminate\Support\Facades\Hash::make('123456'),
        ]);
        User::insert([
            'first_name'=>'Hnik',
            'last_name'=>'Zairiya',
            'bio' => 'Wonderful serenity has taken possession of my entire soul, these mornings',
            'photo' => '2.jpg',
            'country' => 'Australia',
            'email'=>'user2@email.com',
            'role'=>USER_ROLE_USER,
            'status'=>STATUS_SUCCESS,
            'is_verified'=>1,
            'website' => 'https://example.com',
            'password'=>\Illuminate\Support\Facades\Hash::make('123456'),
        ]);
        User::insert([
            'first_name'=>'Robert',
            'last_name'=>'Gomez',
            'bio' => 'Wonderful serenity has taken possession of my entire soul, these mornings',
            'photo' => '3.jpg',
            'country' => 'Australia',
            'email'=>'user3@email.com',
            'role'=>USER_ROLE_USER,
            'status'=>STATUS_SUCCESS,
            'is_verified'=>1,
            'website' => 'https://example.com',
            'password'=>\Illuminate\Support\Facades\Hash::make('123456'),
        ]);
        User::insert([
            'first_name'=>'MacKensie',
            'last_name'=>'Duke',
            'bio' => 'Wonderful serenity has taken possession of my entire soul, these mornings',
            'photo' => '4.jpg',
            'country' => 'Australia',
            'email'=>'user4@email.com',
            'role'=>USER_ROLE_USER,
            'status'=>STATUS_SUCCESS,
            'is_verified'=>1,
            'website' => 'https://example.com',
            'password'=>\Illuminate\Support\Facades\Hash::make('123456'),
        ]);
        User::insert([
            'first_name'=>'Petra',
            'last_name'=>'Garza',
            'bio' => 'Wonderful serenity has taken possession of my entire soul, these mornings',
            'photo' => '5.jpg',
            'country' => 'Australia',
            'email'=>'user5@email.com',
            'role'=>USER_ROLE_USER,
            'status'=>STATUS_SUCCESS,
            'is_verified'=>1,
            'website' => 'https://example.com',
            'password'=>\Illuminate\Support\Facades\Hash::make('123456'),
        ]);
    }
}
