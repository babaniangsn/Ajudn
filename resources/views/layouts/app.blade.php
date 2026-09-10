<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('titre', 'Tableau de bord') | {{ config('app.name', 'AJUDN') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>

<body class="bg-light">

@auth

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top" style="background: #140035">

    <div class="container-fluid">

        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('dashboard') }}">
            <i class="bi bi-people-fill fs-3 me-2"></i>

            <div>
                <div>AJUDN</div>
                <small class="fw-normal" style="font-size:12px">
                    Gestion des Cotisations
                </small>
            </div>

        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i>
                        Tableau de bord
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('membres.*') ? 'active fw-bold' : '' }}"
                        href="{{ route('membres.index') }}">
                        <i class="bi bi-people me-1"></i>
                        Membres
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cotisations.*') ? 'active fw-bold' : '' }}"
                        href="{{ route('cotisations.index') }}">
                        <i class="bi bi-cash-stack me-1"></i>
                        Cotisations
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('backup.*') ? 'active fw-bold' : '' }}"
                        href="{{ route('backup.index') }}">
                        <i class="bi bi-cloud-arrow-down me-1"></i>
                        Sauvegarde
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav">

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">

                        <i class="bi bi-person-circle"></i>

                        {{ auth()->user()->name }}

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow">

                        <li>
                            <span class="dropdown-item-text text-muted small">
                                Connecté
                            </span>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>

                            <form action="{{ route('logout') }}" method="POST">

                                @csrf

                                <button class="dropdown-item text-danger">

                                    <i class="bi bi-box-arrow-right me-1"></i>

                                    Déconnexion

                                </button>

                            </form>

                        </li>

                    </ul>

                </li>

            </ul>

        </div>

    </div>

</nav>

@endauth

<div class="container-fluid py-4">

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show shadow-sm">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show shadow-sm">

            <i class="bi bi-exclamation-circle-fill me-2"></i>

            {{ session('error') }}

            <button class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-warning alert-dismissible fade show shadow-sm">

            <strong>
                <i class="bi bi-exclamation-triangle-fill"></i>
                Veuillez corriger les erreurs suivantes :
            </strong>

            <ul class="mt-2 mb-0">

                @foreach($errors->all() as $erreur)

                    <li>{{ $erreur }}</li>

                @endforeach

            </ul>

            <button class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    @yield('contenu')

</div>

<footer class="bg-white border-top py-3 mt-5">

    <div class="container text-center">

        <small class="text-muted">

            © {{ now()->year }}

            <strong>AJUDN</strong>

            — Application Professionnelle de Gestion des Cotisations

        </small>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>