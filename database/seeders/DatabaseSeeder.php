<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        User::create(['name'=>'Admin','email'=>'admin@test.com','password'=>Hash::make('password'),'role'=>'admin']);
        User::create(['name'=>'Reviewer','email'=>'reviewer@test.com','password'=>Hash::make('password'),'role'=>'reviewer']);
        User::create(['name'=>'Candidate','email'=>'candidate@test.com','password'=>Hash::make('password'),'role'=>'candidate']);
    }
}
