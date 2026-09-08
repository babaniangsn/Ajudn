@extends('layouts.app')

@section('titre', 'Nouveau membre')

@section('contenu')

    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('membres.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
        <h3 class="fw-bold mb-0">Nouveau membre</h3>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('membres.store') }}">
                @csrf
                @include('membres._form', ['matricule' => $matricule])
            </form>
        </div>
    </div>

@endsection
