<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport d'Audit</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
        }

        .section {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 6px;
            text-align: left;
        }

        .summary {
            background: #f4f4f4;
            padding: 10px;
        }

        .positive {
            color: green;
            font-weight: bold;
        }

        .negative {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="title">RAPPORT D'AUDIT FINANCIER</div>
    <p>Unité : {{ $unite->nom }}</p>
    <p>Période : {{ $debut->format('d/m/Y') }} - {{ $fin->format('d/m/Y') }}</p>
</div>

<div class="section summary">
    <p>
        Au cours de mois <?= now()->year ?>, l’unité {{ $unite->nom }} a enregistré un total de ventes de {{ number_format($totalVentes, 0, ',', ' ') }} FCFA
    </p>
    <p>
        Les dépenses totales engagées par l’unité sur la même période s’élèvent à {{ number_format($totalDepenses, 0, ',', ' ') }} FCFA
    </p>
    <p>
        Après déduction des dépenses, le résultat net dégagé par {{ $unite->nom }} au titre du mois s’élève à {{ number_format($net, 0, ',', ' ') }} FCFA.
    </p>
    <p>
        En conclusion: {{ $analyse }} avec un bénéfice de {{ number_format($net, 0, ',', ' ') }} FCFA.
    </p>
</div>

<div class="section summary">
    <h3>Résumé exécutif</h3>

    <p><strong>Total ventes :</strong> {{ number_format($totalVentes, 0, ',', ' ') }} FCFA</p>
    <p><strong>Total dépenses :</strong> {{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</p>

    <p>
        <strong>Résultat net :</strong>
        <span class="{{ $net >= 0 ? 'positive' : 'negative' }}">
            {{ number_format($net, 0, ',', ' ') }} FCFA
        </span>
    </p>

    <p><strong>Conclusion :</strong> {{ $analyse }}</p>
</div>

<div class="section">
    <h3>Détail des ventes</h3>

    <table>
        <tr>
            <th>Date</th>
            <th>Montant</th>
        </tr>

        @foreach($ventes as $vente)
        <tr>
            <td>{{ $vente->created_at->format('d/m/Y') }}</td>
            <td>{{ number_format($vente->total_ttc, 0, ',', ' ') }} FCFA</td>
        </tr>
        @endforeach
    </table>
</div>

<div class="section">
    <h3>Détail des dépenses</h3>

    <table>
        <tr>
            <th>Date</th>
            <th>Motif</th>
            <th>Montant</th>
        </tr>

        @foreach($depenses as $depense)
        <tr>
            <td>{{ $depense->created_at->format('d/m/Y') }}</td>
            <td>{{ $depense->libelle ?? 'N/A' }}</td>
            <td>{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</td>
        </tr>
        @endforeach
    </table>
</div>

</body>
</html>