<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Crée le compte administrateur unique de l'application.
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => config('admin.email', 'ajudn@gmail.com')],
            [
                'name' => config('admin.name', 'Administrateur'),
                'password' => Hash::make(config('admin.password', 'Ajudn2026')),
            ]
        );
    }
}
