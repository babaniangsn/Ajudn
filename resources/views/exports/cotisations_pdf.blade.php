<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des cotisations</title>

    <style>
        @page {
            margin: 15mm;
        }

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
            color:#2c3e50;
        }

        .header{
            text-align:center;
            border-bottom:2px solid #0d6efd;
            padding-bottom:12px;
            margin-bottom:20px;
        }

        .header h2{
            margin:0;
            color:#0d6efd;
            font-size:24px;
        }

        .header p{
            margin:4px 0;
            color:#6c757d;
            font-size:12px;
        }

        .info{
            margin-bottom:15px;
        }

        .info table{
            width:100%;
            border:none;
        }

        .info td{
            border:none;
            padding:2px 0;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        thead{
            background:#0d6efd;
            color:#fff;
        }

        th{
            padding:10px;
            border:1px solid #d9d9d9;
            text-align:left;
            font-size:12px;
        }

        td{
            padding:8px;
            border:1px solid #d9d9d9;
        }

        tbody tr:nth-child(even){
            background:#f8f9fa;
        }

        tfoot td{
            background:#d1e7dd;
            font-weight:bold;
            font-size:13px;
        }

        .text-right{
            text-align:right;
        }

        .footer{
            position:fixed;
            bottom:-10px;
            left:0;
            right:0;
            text-align:center;
            color:#6c757d;
            font-size:11px;
            border-top:1px solid #ddd;
            padding-top:6px;
        }
    </style>

</head>
<body>

<div class="header">
    <h2>AJUDN</h2>

    <p>
        Association des Jeunes Unis pour le Développement de Nianghène
    </p>

    <p>
        Historique des cotisations
    </p>
</div>

<div class="info">
    <table>
        <tr>
            <td>
                <strong>Date d'impression :</strong>
                {{ now()->format('d/m/Y H:i') }}
            </td>

            <td class="text-right">
                <strong>Nombre de paiements :</strong>
                {{ $cotisations->count() }}
            </td>
        </tr>
    </table>
</div>

<table>

    <thead>
        <tr>
            <th>#</th>
            <th>Membre</th>
            <th>Période</th>
            <th>Montant</th>
            <th>Date de paiement</th>
        </tr>
    </thead>

    <tbody>

    @foreach($cotisations as $cotisation)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>{{ $cotisation->membre->nom_complet }}</td>

            <td>{{ $cotisation->periode_libelle }}</td>

            <td class="text-right">
                {{ number_format($cotisation->montant,0,',',' ') }} FCFA
            </td>

            <td>
                {{ $cotisation->date_paiement->format('d/m/Y') }}
            </td>

        </tr>

    @endforeach

    </tbody>

    <tfoot>

        <tr>

            <td colspan="3">
                TOTAL GÉNÉRAL
            </td>

            <td class="text-right">
                {{ number_format($cotisations->sum('montant'),0,',',' ') }} FCFA
            </td>

            <td></td>

        </tr>

    </tfoot>

</table>

<div class="footer">

    Document généré automatiquement par le système de gestion des cotisations AJUDN.

</div>

</body>
</html>