<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Admin One',
                'email' => 'admin1@abaash.com',
                'phone' => '01712345678',
                'password' => Hash::make(User::DEFAULT_PASSWORD),
            ],
            [
                'name' => 'Admin Two',
                'email' => 'admin2@abaash.com',
                'phone' => '01712345672',
                'password' => Hash::make(User::DEFAULT_PASSWORD),
            ],
            [
                'name' => 'Admin Three',
                'email' => 'admin3@abaash.com',
                'phone' => '01712345673',
                'password' => Hash::make(User::DEFAULT_PASSWORD),
            ],
            [
                'name' => 'Admin Four',
                'email' => 'admin4@abaash.com',
                'phone' => '01712345674',
                'password' => Hash::make(User::DEFAULT_PASSWORD),
            ],
            [
                'name' => 'Admin Five',
                'email' => 'admin5@abaash.com',
                'phone' => '01712345675',
                'password' => Hash::make(User::DEFAULT_PASSWORD),
            ],
        ];

        foreach ($admins as $admin){
            User::query()->create($admin);
        }
    }
}
