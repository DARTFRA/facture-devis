<!-- layouts/header.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Devis et Factures</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <header class="bg-blue-600 text-white p-4 shadow">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Gestion de Devis et Factures</h1>
            <nav class="space-x-4">
                <a href="index.php" class="hover:underline">Accueil</a>
                <a href="ajouter_client.php" class="hover:underline">Ajouter Client</a>
                <a href="ajouter_facture.php" class="hover:underline">Ajouter Facture / Devis</a>
                <a href="afficher_factures.php" class="hover:underline">Liste des Factures</a>
            </nav>
        </div>
    </header>
    <main class="container mx-auto mt-8 px-4">
