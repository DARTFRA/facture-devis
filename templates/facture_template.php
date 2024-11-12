<?php
// templates/facture_template.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Facture <?= htmlspecialchars($facture['id']) ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; }
        .details { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        .total { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= ucfirst(htmlspecialchars($facture['type'])) ?></h1>
        <h2>Numéro: <?= htmlspecialchars($facture['id']) ?></h2>
    </div>

    <div class="details">
        <strong>Client :</strong><br>
        <?= htmlspecialchars($facture['nom']) ?><br>
        <?= htmlspecialchars($facture['adresse']) ?><br>
        Email: <?= htmlspecialchars($facture['email']) ?><br>
        Téléphone: <?= htmlspecialchars($facture['telephone']) ?><br><br>

        <strong>Date :</strong> <?= htmlspecialchars($facture['date_facture']) ?><br>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantité</th>
                <th>Prix Unitaire (€)</th>
                <th>Total (€)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= htmlspecialchars($article['description']) ?></td>
                    <td><?= htmlspecialchars($article['quantite']) ?></td>
                    <td><?= htmlspecialchars(number_format($article['prix_unitaire'], 2)) ?></td>
                    <td><?= htmlspecialchars(number_format($article['total'], 2)) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" class="total"><strong>Total :</strong></td>
                <td><strong><?= htmlspecialchars(number_format($total, 2)) ?> €</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
