@extends('layouts.app')

@section('titre', 'Modifier le membre')

@section('contenu')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-pencil-square text-warning me-2"></i>
            Modifier un membre
        </h2>

        <p class="text-muted mb-0">
            Mettre à jour les informations de <strong>{{ $membre->nom_complet }}</strong>.
        </p>
    </div>

    <a href="{{ route('membres.index') }}" class="btn btn-outline-secondary mt-3 mt-md-0">
        <i class="bi bi-arrow-left me-1"></i>
        Retour
    </a>

</div>

<div class="card border-0 shadow rounded-4">

    <div class="card-header bg-white border-0 py-3">

        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-person-gear text-warning me-2"></i>
            Informations du membre
        </h5>

    </div>

    <div class="card-body p-4">

        

        <form method="POST" action="{{ route('membres.update', $membre) }}">

            @csrf
            @method('PUT')

            @include('membres._form', [
                'membre' => $membre
            ])

        </form>

    </div>

</div>

@endsection