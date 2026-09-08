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
            ['email' => env('ADMIN_EMAIL', 'ajudn@gmail.com')],
            [
                'name' => 'Administrateur',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Ajudn2026')),
            ]
        );
    }
}
