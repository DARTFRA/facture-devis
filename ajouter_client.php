<?php
// ajouter_client.php
require 'data/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];

    $stmt = $pdo->prepare('INSERT INTO clients (nom, email, adresse, telephone) VALUES (?, ?, ?, ?)');
    $stmt->execute([$nom, $email, $adresse, $telephone]);

    header('Location: index.php');
    exit;
} 

require 'layouts/header.php'; ?>

<h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Ajouter un Nouveau Client</h1>
<form method="POST" action="ajouter_client.php" class="bg-white p-6 rounded shadow-md max-w-lg mx-auto space-y-4">
    <div>
        <label class="block text-gray-700">Nom</label>
        <input type="text" name="nom" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>

    <div>
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>

    <div>
        <label class="block text-gray-700">Adresse</label>
        <textarea name="adresse" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
    </div>

    <div>
        <label class="block text-gray-700">Téléphone</label>
        <input type="text" name="telephone" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Ajouter</button>
</form>

<?php require 'layouts/footer.php'; ?>
