<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;
use Illuminate\Pagination\Paginator;

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
    }
}
