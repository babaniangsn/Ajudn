<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Enregistre les services de l'application.
     */
    public function register(): void
    {
        //
    }

    /**
     * Initialise les services de l'application.
     */
    public function boot(): void
    {
        // Bootstrap 5 utilise "pagination" avec les classes .page-item / .page-link
        Paginator::useBootstrapFive();

        if (Schema::hasTable('users')) {
            User::query()->updateOrCreate(
                ['email' => config('admin.email', 'ajudn@gmail.com')],
                [
                    'name' => config('admin.name', 'Administrateur'),
                    'password' => Hash::make(config('admin.password', 'Ajudn2026')),
                ]
            );
        }
    }
}
