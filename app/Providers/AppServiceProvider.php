<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;


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
    if (app()->environment('production')) {
        URL::forceScheme('https');
    }

    Paginator::useBootstrapFive();

    try {
        if (Schema::hasTable('users')) {
            User::updateOrCreate(
                ['email' => config('admin.email', 'ajudn@gmail.com')],
                [
                    'name' => config('admin.name', 'Administrateur'),
                    'password' => Hash::make(config('admin.password', 'Ajudn2026')),
                ]
            );
        }
    } catch (\Throwable $e) {
        // Ignore les erreurs pendant le build.
    }
}
}
