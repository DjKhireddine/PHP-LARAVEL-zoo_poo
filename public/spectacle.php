<?php
require_once '../vendor/autoload.php';
use App\Container;

$zoo = Container::getZoo();
$animals = $zoo->getAnimals();

ob_start();
?>

    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">
                <i class="fas fa-star text-yellow-500 mr-3"></i>Spectacle du Zoo
            </h1>
            <p class="text-gray-600 text-lg">Assistez aux performances incroyables de nos animaux</p>
        </div>

        <!-- Compteur et contrôles -->
        <div class="flex items-center justify-between mb-6">
            <div class="text-gray-600 font-semibold">
                Animal <span id="currentIndex">1</span> / <span id="totalAnimals"><?= count($animals) ?></span>
            </div>
            <div class="flex gap-3">
                <button id="playPauseBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-pause mr-2"></i><span id="playPauseText">Pause</span>
                </button>
                <button id="restartBtn" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-redo mr-2"></i>Recommencer
                </button>
            </div>
        </div>

        <!-- Barre de progression -->
        <div class="mb-6 bg-gray-200 rounded-full h-2 overflow-hidden">
            <div id="progressBar" class="bg-gradient-to-r from-blue-500 to-purple-600 h-full transition-all duration-300" style="width: 0%"></div>
        </div>

        <!-- Scène du spectacle -->
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-2xl p-12 min-h-[500px] relative overflow-hidden">
            <!-- Effet de rideau -->
            <div class="absolute inset-0 bg-gradient-to-b from-red-900/20 to-transparent pointer-events-none"></div>

            <!-- Contenu animal -->
            <div id="animalStage" class="relative z-10">
                <?php foreach ($animals as $index => $animal): ?>
                    <div class="animal-performance <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
                        <!-- Titre -->
                        <div class="text-center mb-8">
                            <div class="inline-block bg-white/10 backdrop-blur-sm px-6 py-3 rounded-full mb-4">
                                <span class="text-yellow-400 text-sm font-bold">★ NUMÉRO <?= $index + 1 ?> ★</span>
                            </div>
                            <h2 class="text-5xl font-bold text-white mb-2"><?= ucfirst($animal->getName()) ?></h2>
                            <p class="text-gray-300 text-xl">Début du numéro avec <?= $animal->getName() ?></p>
                        </div>

                        <!-- Icône animée -->
                        <div class="flex justify-center mb-8">
                            <div class="animal-icon-container">
                                <img src="<?= $animal->getIconUrl() ?>" alt="<?= $animal->getName() ?>" class="w-32 h-32">
                            </div>
                        </div>

                        <!-- Actions du spectacle -->
                        <div class="space-y-6 text-white text-center max-w-2xl mx-auto">
                            <div class="performance-step opacity-0" style="animation-delay: 0.5s">
                                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                                    <i class="fas fa-volume-up text-yellow-400 text-3xl mb-3"></i>
                                    <p class="text-xl font-semibold"><?= ucfirst($animal->getName()) ?> fait le bruit : <?= $animal->makeSound() ?></p>
                                </div>
                            </div>

                            <div class="performance-step opacity-0" style="animation-delay: 1.5s">
                                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                                    <i class="fas fa-running text-blue-400 text-3xl mb-3"></i>
                                    <p class="text-xl font-semibold"><?= ucfirst($animal->move()) ?>.</p>
                                </div>
                            </div>

                            <div class="performance-step opacity-0" style="animation-delay: 3s">
                                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                                    <i class="fas fa-utensils text-green-400 text-3xl mb-3"></i>
                                    <p class="text-xl font-semibold">Le dresseur lui donne une récompense : <?= ucfirst($animal->eat()) ?>.</p>
                                </div>
                            </div>

                            <div class="performance-step opacity-0" style="animation-delay: 4.5s">
                                <div class="text-center pt-4">
                                <span class="inline-block bg-red-500 text-white px-8 py-3 rounded-full text-lg font-bold animate-pulse">
                                    ■ Fin du numéro !
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Bouton suivant -->
            <div class="text-center mt-8 relative z-10">
                <button id="nextBtn" class="bg-white hover:bg-gray-100 text-gray-800 px-8 py-3 rounded-full font-bold text-lg shadow-lg transition transform hover:scale-105">
                    Suivant <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>

        <!-- Message de fin -->
        <div id="endMessage" class="hidden text-center mt-8 bg-gradient-to-r from-green-500 to-blue-500 text-white p-8 rounded-2xl shadow-xl">
            <i class="fas fa-trophy text-6xl mb-4"></i>
            <h2 class="text-3xl font-bold mb-2">Spectacle Terminé !</h2>
            <p class="text-xl mb-4">Merci d'avoir assisté à notre spectacle</p>
            <button id="replayBtn" class="bg-white text-gray-800 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
                <i class="fas fa-redo mr-2"></i>Revoir le spectacle
            </button>
        </div>
    </div>

<link rel="stylesheet" href="assets/spectacle.css">
<script src="assets/spectacle.js"></script>

<?php
$content = ob_get_clean();
$title = "Spectacle du Zoo";
require_once '../app/views/layout.php';
?>
