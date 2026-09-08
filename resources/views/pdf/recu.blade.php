<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu {{ $cotisation->reference }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 12px; }
        .entete { text-align: center; border-bottom: 3px solid #2563eb; padding-bottom: 10px; margin-bottom: 20px; }
        .entete h1 { font-size: 18px; color: #2563eb; margin: 0; }
        .entete p { margin: 2px 0; color: #555; }
        .titre-recu { text-align: center; background: #eef2ff; padding: 8px; font-size: 15px; font-weight: bold; color: #1e3a8a; border-radius: 4px; margin-bottom: 20px; }
        table.infos { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.infos td { padding: 6px 4px; border-bottom: 1px solid #e5e7eb; }
        table.infos td.libelle { font-weight: bold; width: 40%; color: #374151; }
        .montant-box { text-align: center; background: #dcfce7; color: #166534; font-size: 20px; font-weight: bold; padding: 14px; border-radius: 6px; margin-bottom: 20px; }
        .pied { margin-top: 40px; font-size: 10px; color: #6b7280; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 10px; }
        .signature { margin-top: 40px; text-align: right; }
    </style>
</head>
<body>

    <div class="entete">
        <h1>AJUDN — ASSOCIATION</h1>
        <p>Reçu officiel de cotisation</p>
    </div>

    <div class="titre-recu">REÇU DE COTISATION</div>

    <table class="infos">
        <tr>
            <td class="libelle">Membre</td>
            <td>{{ $cotisation->membre->nom_complet }}</td>
        </tr>
        <tr>
            <td class="libelle">Téléphone</td>
            <td>{{ $cotisation->membre->telephone ?: '—' }}</td>
        </tr>
        <tr>
            <td class="libelle">Période concernée</td>
            <td>{{ $cotisation->periode_libelle }}</td>
        </tr>
        <tr>
            <td class="libelle">Date de paiement</td>
            <td>{{ $cotisation->date_paiement->format('d/m/Y') }}</td>
        </tr>
    </table>

    <div class="montant-box">
        Montant payé : {{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA
    </div>

    <div class="signature">
        Fait à Kaolack, le {{ now()->format('d/m/Y') }}<br><br>
        Le Trésorier / L'Administrateur
    </div>

    <div class="pied">
        Document généré automatiquement par l'application de gestion des cotisations — AJUDN
    </div>

</body>
</html>
