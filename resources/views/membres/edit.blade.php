@extends('layouts.app')

@section('titre', 'Modifier le membre')

@section('contenu')

    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('membres.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
        <h3 class="fw-bold mb-0">Modifier {{ $membre->nom_complet }}</h3>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('membres.update', $membre) }}">
                @csrf
                @method('PUT')
                @include('membres._form', ['membre' => $membre])
            </form>
        </div>
    </div>

@endsection
