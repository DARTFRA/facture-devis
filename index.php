<?php 
require 'layouts/header.php'; 
require 'data/config.php';

// Récupérer les statistiques de la base de données
// Nombre total de clients
$total_clients = $pdo->query('SELECT COUNT(*) FROM clients')->fetchColumn();

// Nombre total de factures et devis
$total_factures = $pdo->query('SELECT COUNT(*) FROM factures')->fetchColumn();

// Total des revenus générés (montant des factures uniquement)
// Total des revenus générés (montant des factures uniquement)
$total_revenus = $pdo->query("SELECT SUM(montant_total) FROM factures WHERE type = 'facture'")->fetchColumn();
$total_revenus = $total_revenus ?? 0; // Si $total_revenus est null, le remplacer par 0

// Récupérer les dernières factures et devis
$recent_factures = $pdo->query("SELECT f.id, f.date_facture, f.montant_total, f.type, c.nom AS client_nom 
                                FROM factures f 
                                JOIN clients c ON f.client_id = c.id 
                                ORDER BY f.date_facture DESC 
                                LIMIT 5")->fetchAll();
?>

<div class="max-w-4xl mx-auto text-center mt-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Tableau de Bord</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Statistique 1: Total Clients -->
        <div class="bg-white p-6 rounded shadow text-center">
            <h2 class="text-xl font-semibold text-gray-700">Total Clients</h2>
            <p class="text-3xl font-bold text-blue-600 mt-2"><?= $total_clients ?></p>
        </div>

        <!-- Statistique 2: Total Factures et Devis -->
        <div class="bg-white p-6 rounded shadow text-center">
            <h2 class="text-xl font-semibold text-gray-700">Total Devis et Factures</h2>
            <p class="text-3xl font-bold text-green-600 mt-2"><?= $total_factures ?></p>
        </div>

        <!-- Statistique 3: Revenus Totaux -->
        <div class="bg-white p-6 rounded shadow text-center">
            <h2 class="text-xl font-semibold text-gray-700">Revenus Totaux</h2>
            <p class="text-3xl font-bold text-purple-600 mt-2"><?= number_format($total_revenus, 2) ?> €</p>
            </div>
    </div>

    <!-- Liste des Dernières Factures et Devis -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Dernières Factures et Devis</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="border-b p-4 text-gray-600 font-semibold">ID</th>
                    <th class="border-b p-4 text-gray-600 font-semibold">Client</th>
                    <th class="border-b p-4 text-gray-600 font-semibold">Date</th>
                    <th class="border-b p-4 text-gray-600 font-semibold">Type</th>
                    <th class="border-b p-4 text-gray-600 font-semibold">Montant</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_factures as $facture): ?>
                    <tr>
                        <td class="border-b p-4"><?= htmlspecialchars($facture['id']) ?></td>
                        <td class="border-b p-4"><?= htmlspecialchars($facture['client_nom']) ?></td>
                        <td class="p-4"><?= htmlspecialchars((new DateTime($facture['date_facture']))->format('d/m/Y')) ?></td>
                        <td class="border-b p-4"><?= ucfirst(htmlspecialchars($facture['type'])) ?></td>
                        <td class="border-b p-4"><?= number_format($facture['montant_total'], 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'layouts/footer.php'; ?>
