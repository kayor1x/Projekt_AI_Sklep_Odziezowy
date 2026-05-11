<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(CategorySeeder::class);

        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'role' => User::ROLE_ADMIN,
                'password' => 'password',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'jan@example.com'],
            [
                'name' => 'Jan',
                'role' => User::ROLE_USER,
                'password' => 'password',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'yevhenii@example.com'],
            [
                'name' => 'Yevhenii',
                'role' => User::ROLE_USER,
                'password' => 'password',
            ]
        );
    }
}
