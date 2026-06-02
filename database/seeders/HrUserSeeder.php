<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class HrUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name'=>'Ghisna',   'email'=>'ghisna@arisamandiri.com',  'password'=>'ghisna123'],
            ['name'=>'Nisa',     'email'=>'nisa@arisamandiri.com',    'password'=>'nisa123'],
            ['name'=>'Wiwit',    'email'=>'wiwit@arisamandiri.com',   'password'=>'wiwit123'],
            ['name'=>'HR Admin', 'email'=>'admin@arisamandiri.com',   'password'=>'admin123'],
        ];

        foreach ($users as $u) {
            User::create([
                'name'     => $u['name'],
                'email'    => $u['email'],
                'password' => bcrypt($u['password']),
                'email_verified_at' => now(),
            ]);
        }
    }
}
