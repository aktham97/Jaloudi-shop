<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
           'name'=>'AKtham Aljaloudi' ,
            'email'=>'aktham97.aaj@gmail.com',
            'password'=>Hash::make('admin123'),
            'role'=>'administrator'
        ]);
    }
}
