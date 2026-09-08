<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des membres</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1f2937; }
        h2 { text-align: center; color: #2563eb; margin-bottom: 4px; }
        p.sous-titre { text-align: center; color: #6b7280; margin-top: 0; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        th { background: #eef2ff; color: #1e3a8a; }
        tr:nth-child(even) { background: #f9fafb; }
    </style>
</head>
<body>
    <h2>AJUDN — Liste des membres</h2>
    <p class="sous-titre">Générée le {{ now()->format('d/m/Y à H:i') }} — {{ $membres->count() }} membre(s)</p>
    <table>
        <thead>
            <tr>
                <th>Prénom</th><th>Nom</th><th>Téléphone</th><th>Adhésion</th><th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($membres as $membre)
                <tr>
                    <td>{{ $membre->prenom }}</td>
                    <td>{{ $membre->nom }}</td>
                    <td>{{ $membre->telephone }}</td>
                    <td>{{ $membre->date_adhesion->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($membre->statut) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
