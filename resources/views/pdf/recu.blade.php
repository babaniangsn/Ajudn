<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu {{ $cotisation->reference }}</title>

    <style>
        body{
            font-family: DejaVu Sans,sans-serif;
            color:#333;
            font-size:12px;
            margin:35px;
        }

        .header{
            text-align:center;
            border-bottom:3px solid #0d6efd;
            padding-bottom:12px;
            margin-bottom:25px;
        }

        .header h1{
            margin:0;
            color:#0d6efd;
            font-size:24px;
        }

        .header p{
            margin:3px 0;
            color:#666;
        }

        .titre{
            text-align:center;
            font-size:18px;
            font-weight:bold;
            background:#eaf3ff;
            color:#0d47a1;
            padding:10px;
            margin-bottom:25px;
            border-radius:6px;
        }

        .reference{
            text-align:right;
            font-weight:bold;
            margin-bottom:15px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        td{
            padding:9px;
            border:1px solid #ddd;
        }

        td.label{
            width:35%;
            background:#f5f5f5;
            font-weight:bold;
        }

        .montant{
            margin:25px 0;
            text-align:center;
            background:#d1fae5;
            border:2px solid #10b981;
            padding:18px;
            font-size:24px;
            font-weight:bold;
            color:#065f46;
            border-radius:8px;
        }

        .observation{
            margin-top:20px;
            border:1px dashed #999;
            padding:10px;
            min-height:45px;
        }

        .signature{
            margin-top:60px;
            width:100%;
        }

        .signature td{
            border:none;
            text-align:center;
            padding-top:40px;
        }

        .footer{
            margin-top:50px;
            text-align:center;
            color:#777;
            font-size:10px;
            border-top:1px solid #ddd;
            padding-top:10px;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>AJUDN</h1>
    <p>Association des Jeunes pour l'Union et le Développement</p>
    <p>Gestion des Cotisations</p>
</div>

<div class="titre">
    REÇU OFFICIEL DE COTISATION
</div>

<div class="reference">
    N° {{ $cotisation->reference }}
</div>

<table>
    <tr>
        <td class="label">Nom du membre</td>
        <td>{{ $cotisation->membre->nom_complet }}</td>
    </tr>

    <tr>
        <td class="label">Téléphone</td>
        <td>{{ $cotisation->membre->telephone ?: 'Non renseigné' }}</td>
    </tr>

    <tr>
        <td class="label">Période</td>
        <td>{{ $cotisation->periode_libelle }}</td>
    </tr>

    <tr>
        <td class="label">Date de paiement</td>
        <td>{{ $cotisation->date_paiement->format('d/m/Y') }}</td>
    </tr>

    <!-- <tr>
        <td class="label">Mode de paiement</td>
        <td>{{ $cotisation->mode_paiement }}</td>
    </tr> -->
</table>

<div class="montant">
    {{ number_format($cotisation->montant,0,',',' ') }} FCFA
</div>

@if($cotisation->observation)
<div class="observation">
    <strong>Observation :</strong><br>
    {{ $cotisation->observation }}
</div>
@endif

<table class="signature">
    <tr>
        <td>
            Le bénéficiaire
            <br><br><br>
            ________________________
        </td>

        <td>
            Fait à Kaolack, le {{ now()->format('d/m/Y') }}
            <br><br><br>
            Le Trésorier
            <br>
            ________________________
        </td>
    </tr>
</table>

<div class="footer">
    Document généré automatiquement le {{ now()->format('d/m/Y à H:i') }}<br>
    AJUDN — Gestion des Cotisations
</div>

</body>
</html>