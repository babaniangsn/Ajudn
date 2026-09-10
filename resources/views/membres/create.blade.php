@extends('layouts.app')

@section('titre', 'Nouveau membre')

@section('contenu')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-person-plus-fill text-primary me-2"></i>
            Nouveau membre
        </h2>

        <p class="text-muted mb-0">
            Enregistrer un nouvel adhérent de l'AJUDN.
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
            <i class="bi bi-pencil-square text-primary me-2"></i>
            Informations du membre
        </h5>

    </div>

    <div class="card-body p-4">

        <div class="alert alert-primary d-flex align-items-center mb-4">

            <i class="bi bi-person-badge-fill fs-4 me-3"></i>

            <div>
                <strong>Matricule attribué</strong><br>
                <span class="fs-5 fw-bold">{{ $matricule }}</span>
            </div>

        </div>

        <form method="POST" action="{{ route('membres.store') }}">

            @csrf

            @include('membres._form', [
                'matricule' => $matricule
            ])

        </form>

    </div>

</div>

@endsection