<?php 
require 'layouts/header.php'; 
require 'data/config.php';

$factures = $pdo->query('SELECT factures.*, clients.nom AS client_nom FROM factures JOIN clients ON factures.client_id = clients.id ORDER BY factures.date_facture DESC')->fetchAll();
?>

<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow mt-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Liste des Factures et Devis</h1>
    <a href="ajouter_facture.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">
        Ajouter une Facture / Devis
    </a>

    <div class="overflow-x-auto mt-4">
        <table class="min-w-full border border-gray-300 bg-white rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border-b border-gray-300 p-4 text-left text-gray-600 font-semibold">ID</th>
                    <th class="border-b border-gray-300 p-4 text-left text-gray-600 font-semibold">Client</th>
                    <th class="border-b border-gray-300 p-4 text-left text-gray-600 font-semibold">Date</th>
                    <th class="border-b border-gray-300 p-4 text-left text-gray-600 font-semibold">Type</th>
                    <th class="border-b border-gray-300 p-4 text-left text-gray-600 font-semibold">Montant Total</th>
                    <th class="border-b border-gray-300 p-4 text-left text-gray-600 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($factures as $facture): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4"><?= htmlspecialchars($facture['id']) ?></td>
                        <td class="p-4"><?= htmlspecialchars($facture['client_nom']) ?></td>
                        <td class="p-4"><?= htmlspecialchars((new DateTime($facture['date_facture']))->format('d/m/Y')) ?></td>
                        <td class="p-4"><?= htmlspecialchars(ucfirst($facture['type'])) ?></td>
                        <td class="p-4"><?= number_format($facture['montant_total'], 2) ?> €</td>
                        <td class="p-4">
                            <a href="generate_pdf.php?id=<?= htmlspecialchars($facture['id']) ?>" target="_blank" class="text-blue-600 hover:underline">
                                Télécharger PDF
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'layouts/footer.php'; ?>
