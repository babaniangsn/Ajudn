<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des cotisations</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1f2937; }
        h2 { text-align: center; color: #2563eb; margin-bottom: 4px; }
        p.sous-titre { text-align: center; color: #6b7280; margin-top: 0; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        th { background: #eef2ff; color: #1e3a8a; }
        tr:nth-child(even) { background: #f9fafb; }
        tfoot td { font-weight: bold; background: #dcfce7; }
    </style>
</head>
<body>
    <h2>AJUDN — Historique des cotisations</h2>
    <p class="sous-titre">Générée le {{ now()->format('d/m/Y à H:i') }} — {{ $cotisations->count() }} paiement(s)</p>
    <table>
        <thead>
            <tr>
                <th>Membre</th><th>Période</th><th>Montant</th><th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cotisations as $cotisation)
                <tr>
                    <td>{{ $cotisation->membre->nom_complet }}</td>
                    <td>{{ $cotisation->periode_libelle }}</td>
                    <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $cotisation->date_paiement->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">TOTAL</td>
                <td>{{ number_format($cotisations->sum('montant'), 0, ',', ' ') }} FCFA</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
