<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Connexion | {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Laravel 10/11 --}}
  

    {{-- Si tu n'utilises pas Vite, remplace par :--}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
</head>

<body class="login-body d-flex justify-content-center align-items-center min-vh-100">

<div class="login-card shadow-lg">

    <div class="text-center mb-4">
        <i class="bi bi-people-fill login-icon"></i>

        <h2 class="fw-bold mt-3 mb-1">
            {{ config('app.name', 'AJUDN') }}
        </h2>

        <p class="text-muted mb-0">
            Association des Jeunes Unis pour le Développement de Nianghène
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}" novalidate>

        @csrf

        <div class="mb-3">

            <label for="email" class="form-label">
                Adresse e-mail
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="exemple@gmail.com"
                    autocomplete="email"
                    autofocus
                    required>

            </div>

            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror

        </div>

        <div class="mb-3">

            <label for="password" class="form-label">
                Mot de passe
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>

                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required>
                <span class="input-group-text">
                    <i id="eye" class="fa-solid fa-eye md-3" onclick="masque(this)" style="position: relative; "></i>
                </span>
            </div>

            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror

        </div>

        <div class="form-check mb-4">

            <input
                class="form-check-input"
                type="checkbox"
                name="remember"
                id="remember"
                {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                Se souvenir de moi
            </label>

        </div>

        <button class="btn btn-primary w-100 py-2 fw-semibold">

            <i class="bi bi-box-arrow-in-right me-2"></i>

            Se connecter

        </button>

    </form>

</div>
<script>
    function masque(icon) {
        const pwd = document.getElementById("password");
        if (pwd.type === "password") {
            pwd.type = "text";
            icon.className = "fa-solid fa-eye-slash";
        } else {
            pwd.type = "password";
            icon.className = "fa-solid fa-eye";
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>