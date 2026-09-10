@extends('layouts.app')

@section('titre', 'Cartes de membre')

@section('contenu')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 no-print">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-credit-card-2-front-fill text-primary me-2"></i>
            Cartes des membres
        </h2>
        <p class="text-muted mb-0">
            Cartes officielles des adhérents AJUDN
        </p>
    </div>

    <div class="mt-3 mt-md-0">
        <a href="{{ route('membres.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>

        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Imprimer
        </button>
    </div>
</div>

<div class="row g-4">

@forelse($membres->where('carte',1) as $membre)

<div class="col-lg-4 col-md-6">

<div class="member-card">

    <div class="member-card-header">

        <div>
            <small>ASSOCIATION</small>
            <h5>AJUDN</h5>
        </div>

        <div class="logo-circle">
            <i class="bi bi-people-fill"></i>
        </div>

    </div>

    <div class="member-card-body">

        <div class="text-center mb-3">

            <div class="avatar">
                <i class="bi bi-person-fill"></i>
            </div>

            <h4 class="mt-2 mb-0">
                {{ strtoupper($membre->prenom.' '.$membre->nom) }}
            </h4>

            <small class="text-light">
                Carte de membre
            </small>

        </div>

        <table class="table table-borderless table-sm text-white mb-0">
            <tr>
                <td><strong>Matricule</strong></td>
                <td>{{ $membre->matricule }}</td>
            </tr>

            <tr>
                <td><strong>Téléphone</strong></td>
                <td>{{ $membre->telephone ?: '---' }}</td>
            </tr>

            <tr>
                <td><strong>Statut</strong></td>
                <td>{{ ucfirst($membre->statut) }}</td>
            </tr>

            <tr>
                <td><strong>Adhésion</strong></td>
                <td>{{ $membre->date_adhesion?->format('d/m/Y') }}</td>
            </tr>
        </table>

    </div>

    <div class="member-card-footer">

        <span>N° {{ $membre->matricule }}</span>

        <span>
            <i class="bi bi-patch-check-fill"></i>
            VALIDE
        </span>

    </div>

</div>

</div>

@empty

<div class="col-12">
    <div class="alert alert-info text-center">
        Aucun membre avec carte.
    </div>
</div>

@endforelse

</div>

<style>

.member-card{
    border-radius:20px;
    overflow:hidden;
    background:linear-gradient(135deg,#0d6efd,#1e3a8a);
    color:white;
    box-shadow:0 12px 25px rgba(0,0,0,.25);
    transition:.3s;
}

.member-card:hover{
    transform:translateY(-6px);
}

.member-card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 22px;
}

.member-card-header small{
    letter-spacing:2px;
    opacity:.8;
}

.member-card-header h5{
    margin:0;
    font-weight:700;
}

.logo-circle{
    width:60px;
    height:60px;
    border-radius:50%;
    background:rgba(255,255,255,.2);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
}

.member-card-body{
    padding:20px;
}

.avatar{
    width:90px;
    height:90px;
    margin:auto;
    border-radius:50%;
    background:white;
    color:#0d6efd;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:48px;
}

.member-card-footer{
    background:rgba(0,0,0,.18);
    display:flex;
    justify-content:space-between;
    padding:15px 20px;
    font-weight:600;
}

.table td{
    color:white;
    padding:3px 0;
}

@media print{

.no-print{
    display:none!important;
}

body{
    background:white;
}

.member-card{
    box-shadow:none;
    page-break-inside:avoid;
}

}

</style>

@endsection