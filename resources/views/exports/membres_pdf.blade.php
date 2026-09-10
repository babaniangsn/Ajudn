<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des membres - AJUDN</title>

    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #2d3748;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #0d6efd;
            font-size: 22px;
        }

        .header h3 {
            margin: 5px 0;
            font-size: 15px;
            color: #374151;
        }

        .header p {
            margin: 2px;
            color: #6b7280;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #0d6efd;
            color: #fff;
            padding: 8px;
            border: 1px solid #dee2e6;
            font-size: 12px;
        }

        td {
            border: 1px solid #dee2e6;
            padding: 7px;
            font-size: 11px;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .center {
            text-align: center;
        }

        .badge-actif {
            color: #198754;
            font-weight: bold;
        }

        .badge-inactif {
            color: #dc3545;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 8px;
        }
    </style>

</head>

<body>

    <div class="header">
        <h1>AJUDN</h1>
        <h3>Association des Jeunes Unis pour le Développement de Nianghène</h3>

        <p><strong>Liste officielle des membres</strong></p>

        <p>
            Générée le {{ now()->format('d/m/Y à H:i') }}
        </p>

        <p>
            Nombre total de membres :
            <strong>{{ $membres->count() }}</strong>
        </p>
    </div>

    <table>

        <thead>
            <tr>
                <th width="6%">N°</th>
                <th width="22%">Prénom</th>
                <th width="22%">Nom</th>
                <th width="20%">Téléphone</th>
                <th width="15%">Adhésion</th>
                <th width="15%">Statut</th>
            </tr>
        </thead>

        <tbody>

            @foreach($membres as $membre)

            <tr>

                <td class="center">{{ $loop->iteration }}</td>

                <td>{{ $membre->prenom }}</td>

                <td>{{ $membre->nom }}</td>

                <td>{{ $membre->telephone ?? '-' }}</td>

                <td class="center">
                    {{ optional($membre->date_adhesion)->format('d/m/Y') }}
                </td>

                <td class="center">
                    @if($membre->statut == 'actif')
                    <span class="badge-actif">ACTIF</span>
                    @else
                    <span class="badge-inactif">INACTIF</span>
                    @endif
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

    <div class="footer">
        AJUDN • Application de Gestion des Cotisations • {{ now()->year }}
    </div>

</body>

</html>