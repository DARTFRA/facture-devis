<?php
// generate_pdf.php
require 'data/config.php';
require 'vendor/autoload.php';

use Dompdf\Dompdf;

// Récupérer l'ID de la facture
if (!isset($_GET['id'])) {
    die('ID de la facture manquant.');
}

$facture_id = intval($_GET['id']);

// Récupérer les données de la facture
$stmt = $pdo->prepare('SELECT factures.*, clients.nom, clients.email, clients.adresse, clients.telephone FROM factures JOIN clients ON factures.client_id = clients.id WHERE factures.id = ?');
$stmt->execute([$facture_id]);
$facture = $stmt->fetch();

if (!$facture) {
    die('Facture non trouvée.');
}

// Récupérer les articles
$stmt = $pdo->prepare('SELECT * FROM articles WHERE facture_id = ?');
$stmt->execute([$facture_id]);
$articles = $stmt->fetchAll();

// Calculer le total
$total = 0;
foreach ($articles as $article) {
    $total += $article['total'];
}

// Charger le template HTML
ob_start();
include 'templates/facture_template.php';
$html = ob_get_clean();

// Initialiser Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optionnel) Configurer le format du papier
$dompdf->setPaper('A4', 'portrait');

// Rendre le HTML en PDF
$dompdf->render();

// Sortie du PDF
$dompdf->stream("facture_{$facture_id}.pdf", ["Attachment" => true]);
?>
