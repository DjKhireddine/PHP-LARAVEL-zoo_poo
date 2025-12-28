<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo POO - <?= $title ?? 'Accueil' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-primary { background: #2c3e50; }
        .bg-secondary { background: #34495e; }
        .btn-primary { background: #3498db; }
        .btn-primary:hover { background: #2980b9; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<nav class="bg-primary text-white p-4 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">
            <i class="fas fa-paw mr-2"></i>Zoo POO
        </h1>
        <div class="space-x-4">
            <a href="index.php" class="hover:text-yellow-300">
                <i class="fas fa-home mr-1"></i>Accueil
            </a>
            <a href="visite.php" class="hover:text-yellow-300">
                <i class="fas fa-binoculars mr-1"></i>Visite
            </a>
            <a href="spectacle.php" class="hover:text-yellow-300">
                <i class="fas fa-theater-masks mr-1"></i>Spectacle
            </a>
        </div>
    </div>
</nav>

<main class="container mx-auto p-6">
    <?= $content ?>
</main>

<footer class="bg-secondary text-white p-4 mt-8">
    <div class="container mx-auto text-center">
        <p>Projet Zoo POO - Programmation Orientée Objet en PHP</p>
        <p class="text-sm text-gray-300 mt-2">Utilise les interfaces Animal, Walkable, Flyable, Swimmable, Eater</p>
    </div>
</footer>
</body>
</html>
