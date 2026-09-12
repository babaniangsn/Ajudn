<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bureau de l'association - AJUDN</title>

    <style>
        @page { margin: 15mm; }

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

        .center { text-align: center; }
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
        <h3>Bureau de l'association</h3>
        <p>Liste des responsables et leurs fonctions</p>
        <p>Générée le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30%">Nom</th>
                <th width="25%">Rôle</th>
                <th width="20%">Téléphone</th>
                <th width="25%">Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($membres as $membre)
                <tr>
                    <td>{{ $membre->nom_complet }}</td>
                    <td>{{ $membre->role }}</td>
                    <td>{{ $membre->telephone ?? '-' }}</td>
                    <td class="center">{{ $membre->statut == 'actif' ? 'ACTIF' : 'INACTIF' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        AJUDN • Bureau de l'association • {{ now()->year }}
    </div>
</body>
</html>
