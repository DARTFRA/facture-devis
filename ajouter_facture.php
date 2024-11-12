<?php
// ajouter_facture.php
require 'data/config.php';

$clients = $pdo->query('SELECT * FROM clients')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $date_facture = $_POST['date_facture'];
    $type = $_POST['type'];
    
    // Décoder la chaîne JSON en tableau PHP
    $articles = json_decode($_POST['articles'], true);

    // Vérifiez si l'encodage JSON est correct
    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Erreur dans le format des articles.");
    }

    // Calcul du montant total
    $total = 0;
    foreach ($articles as $article) {
        $total += $article['quantite'] * $article['prix_unitaire'];
    }

    // Insertion de la facture
    $stmt = $pdo->prepare('INSERT INTO factures (client_id, date_facture, montant_total, type) VALUES (?, ?, ?, ?)');
    $stmt->execute([$client_id, $date_facture, $total, $type]);
    $facture_id = $pdo->lastInsertId();

    // Insertion des articles
    $stmt = $pdo->prepare('INSERT INTO articles (facture_id, description, quantite, prix_unitaire) VALUES (?, ?, ?, ?)');
    foreach ($articles as $article) {
        $stmt->execute([$facture_id, $article['description'], $article['quantite'], $article['prix_unitaire']]);
    }

    header('Location: afficher_factures.php');
    exit;
}

?>

<?php require 'layouts/header.php'; ?>

<h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Ajouter une Facture ou un Devis</h1>
<form method="POST" action="ajouter_facture.php" class="bg-white p-6 rounded shadow-md max-w-2xl mx-auto space-y-4">
    <div>
        <label class="block text-gray-700">Client</label>
        <select name="client_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            <?php foreach ($clients as $client): ?>
                <option value="<?= htmlspecialchars($client['id']) ?>"><?= htmlspecialchars($client['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label class="block text-gray-700">Date</label>
        <input type="date" name="date_facture" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>

    <div>
        <label class="block text-gray-700">Type</label>
        <select name="type" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            <option value="devis">Devis</option>
            <option value="facture">Facture</option>
        </select>
    </div>

    <h3 class="text-lg font-semibold text-gray-800">Articles</h3>
    <div class="space-y-4">
        <div>
            <label class="block text-gray-700">Description</label>
            <input type="text" id="description" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <div>
            <label class="block text-gray-700">Quantité</label>
            <input type="number" id="quantite" min="1" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <div>
            <label class="block text-gray-700">Prix Unitaire</label>
            <input type="number" id="prix_unitaire" step="0.01" min="0.01" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <button type="button" onclick="addArticle()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajouter Article</button>
    </div>

    <ul id="liste_articles" class="mt-4 space-y-2"></ul>

    <input type="hidden" name="articles" id="articles">

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Enregistrer</button>
</form>

<?php require 'layouts/footer.php'; ?>


<script>
        let articles = [];

        function addArticle() {
            const description = document.getElementById('description').value;
            const quantite = parseInt(document.getElementById('quantite').value);
            const prix_unitaire = parseFloat(document.getElementById('prix_unitaire').value);

            if (description && quantite > 0 && prix_unitaire > 0) {
                articles.push({ description, quantite, prix_unitaire });
                document.getElementById('articles').value = JSON.stringify(articles);
                displayArticles();
                document.getElementById('description').value = '';
                document.getElementById('quantite').value = '';
                document.getElementById('prix_unitaire').value = '';
            }
        }

        function displayArticles() {
            const list = document.getElementById('liste_articles');
            list.innerHTML = '';
            articles.forEach((article, index) => {
                list.innerHTML += `<li>${article.description} - ${article.quantite} x ${article.prix_unitaire} = ${article.quantite * article.prix_unitaire} <button type="button" onclick="removeArticle(${index})">Supprimer</button></li>`;
            });
        }

        function removeArticle(index) {
            articles.splice(index, 1);
            document.getElementById('articles').value = JSON.stringify(articles);
            displayArticles();
        }
    </script>