<?php

namespace Database\Seeders;

use App\Models\User;
use Bcampti\Larabase\Enums\UserTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSuporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Admin',
            'email'=>'suporte@mailinator.com',
            'password'=>Hash::make('password'),
            'type'=>UserTypeEnum::SUPORTE->name,
            'email_verified_at'=>now()
        ]);
    }
}
