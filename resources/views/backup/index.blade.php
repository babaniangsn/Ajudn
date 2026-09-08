@extends('layouts.app')

@section('titre', 'Sauvegarde de la base de données')

@section('contenu')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><i class="bi bi-database-fill-down me-2"></i>Sauvegarde de la base de données</h3>
        <form method="POST" action="{{ route('backup.creer') }}">
            @csrf
            <button class="btn btn-primary"><i class="bi bi-cloud-arrow-down me-1"></i> Nouvelle sauvegarde</button>
        </form>
    </div>

    <div class="alert alert-info">
        <i class="bi bi-info-circle me-1"></i>
        La sauvegarde utilise l'outil <code>mysqldump</code>, qui doit être installé et accessible sur le serveur
        (inclus par défaut avec la plupart des installations MySQL / XAMPP / WAMP / Laragon).
    </div>

    <div class="card">
        <div class="card-header">Sauvegardes disponibles</div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Fichier</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sauvegardes as $fichier)
                        <tr>
                            <td><i class="bi bi-file-earmark-zip me-1"></i> {{ basename($fichier) }}</td>
                            <td class="text-end">
                                <a href="{{ route('backup.telecharger', basename($fichier)) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download"></i> Télécharger
                                </a>
                                <form action="{{ route('backup.supprimer', basename($fichier)) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette sauvegarde ?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center text-muted py-4">Aucune sauvegarde disponible.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
