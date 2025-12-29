<?php
require_once '../vendor/autoload.php';
use App\Container;
use App\Services\AnimalPresenter;
use App\Services\FeedingService;
use App\Services\MovementService;

$zoo = Container::getZoo();

$animals = $zoo->getAnimals();

// Initialiser les services
$presenter = new AnimalPresenter();
$feeder = new FeedingService();
$mover = new MovementService();

ob_start();
?>

    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">
            <i class="fas fa-binoculars text-blue-500 mr-3"></i>Visite Guidée du Zoo
        </h1>
        <p class="text-gray-600 text-lg">Découvrez nos magnifiques animaux et leurs caractéristiques</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($animals as $animal): ?>
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition duration-300 hover:scale-[1.02] hover:shadow-2xl">
                <!-- En-tête de la carte -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold"><?= $animal->getName() ?></h3>
                        </div>
                        <div class="text-4xl">
                            <img src="<?= $animal->getIconUrl() ?>" alt="<?= $animal->getName() ?>" width="64">
                        </div>
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="p-6">
                    <!-- Caractéristiques -->
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-volume-up text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Son caractéristique</h4>
                                <p class="text-gray-600"><?= $animal->makeSound() ?></p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-green-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-utensils text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Alimentation</h4>
                                <p class="text-gray-600"><?= ucfirst($animal->eat()) ?></p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-purple-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-running text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Déplacement</h4>
                                <p class="text-gray-600"><?= ucfirst($animal->move()) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Badges de capacités -->
                    <div class="mt-6 pt-6 border-t">
                        <h4 class="font-bold text-gray-800 mb-3">Capacités</h4>
                        <div class="flex flex-wrap gap-2">
                            <?php if ($animal instanceof App\Interfaces\WalkableInterface): ?>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                        <i class="fas fa-walking mr-1"></i>Marche
                    </span>
                            <?php endif; ?>

                            <?php if ($animal instanceof App\Interfaces\FlyableInterface): ?>
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                        <i class="fas fa-dove mr-1"></i>Vol
                    </span>
                            <?php endif; ?>

                            <?php if ($animal instanceof App\Interfaces\SwimmableInterface): ?>
                                <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">
                        <i class="fas fa-water mr-1"></i>Nage
                    </span>
                            <?php endif; ?>

                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                        <i class="fas fa-utensils mr-1"></i>Mange
                    </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Statistiques -->
    <div class="mt-12 bg-gradient-to-r from-gray-800 to-gray-900 text-white p-8 rounded-2xl shadow-xl">
        <h2 class="text-3xl font-bold mb-6 text-center">Statistiques du Zoo</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-4xl font-bold"><?= count($animals) ?></div>
                <div class="text-gray-300">Espèces</div>
            </div>
            <div>
                <div class="text-4xl font-bold">
                    <?= count(array_filter($animals, fn($a) => $a instanceof App\Interfaces\WalkableInterface)) ?>
                </div>
                <div class="text-gray-300">Marchent</div>
            </div>
            <div>
                <div class="text-4xl font-bold">
                    <?= count(array_filter($animals, fn($a) => $a instanceof App\Interfaces\FlyableInterface)) ?>
                </div>
                <div class="text-gray-300">Volent</div>
            </div>
            <div>
                <div class="text-4xl font-bold">
                    <?= count(array_filter($animals, fn($a) => $a instanceof App\Interfaces\SwimmableInterface)) ?>
                </div>
                <div class="text-gray-300">Nagent</div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
$title = "Visite du Zoo";
require_once '../app/views/layout.php';
