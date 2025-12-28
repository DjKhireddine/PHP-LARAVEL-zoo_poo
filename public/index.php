<?php
require_once '../vendor/autoload.php';
use App\Container;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$zoo = Container::getZoo();
$animalCount = $zoo->countAnimals();
$hasAnimals = $animalCount > 0;

// Désactiver la visite et le spéctacle si pas d'animaux dans le zoo
$cursorHandler = $hasAnimals ? 'cursor-pointer' : 'cursor-not-allowed';

ob_start();
?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Formulaire d'ajout -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
                <i class="fas fa-plus-circle text-green-500 mr-2"></i>Ajouter un animal
            </h2>

            <form action="traitement.php" method="POST" class="space-y-4">
                <input type="hidden" name="action" value="create_animal">
                <div>
                    <label class="block text-gray-700 mb-2">Type d'animal</label>
                    <select name="animal_type" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="Dog">Chien</option>
                        <option value="Cat">Chat</option>
                        <option value="Eagle">Aigle</option>
                        <option value="Fish">Poisson</option>
                        <option value="Dolphin">Dauphin</option>
                        <option value="Snake">Serpent</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Nom (optionnel)</label>
                    <input type="text" name="animal_name"
                           class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
                           placeholder="Ex: Rex, Misty...">
                </div>

                <button type="submit"
                        class="w-full btn-primary text-white py-3 rounded-lg font-semibold hover:shadow-lg transition">
                    <i class="fas fa-plus mr-2"></i>Ajouter au zoo
                </button>
            </form>
        </div>

        <!-- Actions rapides -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Actions rapides</h2>
                <div class="grid grid-cols-2 gap-4">
                    <a href="<?= $hasAnimals ? 'visite.php' : '#'; ?>"
                        <?php $colorType = $hasAnimals ? 'green' : 'gray'; ?>
                       class="<?= "bg-$colorType-50 text-$colorType-800 hover:bg-$colorType-200 $cursorHandler" ?> block p-4 rounded-lg text-center transition">
                        <i class="fas fa-binoculars text-3xl mb-2"></i>
                        <div class="font-bold">Visite guidée</div>
                        <div class="text-sm">Découvrez nos animaux</div>
                    </a>
                    <a href="<?= $hasAnimals ? 'spectacle.php' : '#'; ?>"
                       <?php $colorType = $hasAnimals ? 'purple' : 'gray'; ?>
                       class="<?= "bg-$colorType-50 text-$colorType-800 hover:bg-$colorType-200 $cursorHandler" ?> block p-4 rounded-lg text-center transition">
                        <i class="fas fa-theater-masks text-3xl mb-2"></i>
                        <div class="font-bold">Spectacle</div>
                        <div class="text-sm">Voir le show</div>
                    </a>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Notre zoo</h2>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-4xl font-bold text-primary"><?= $zoo->countAnimals() ?></div>
                    <div class="text-gray-600">animaux dans le zoo</div>
                </div>
            </div>
        </div>
    </div>

<?php if ($zoo->countAnimals() > 0): ?>
    <div class="mt-8 bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Nos animaux</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <!-- Boucle sur les animaux -->
            <?php foreach ($zoo->getAnimals() as $animal): ?>
                <div class="bg-gray-50 p-4 rounded-lg text-center relative group">
                    <div class="flex flex-col gap-4 items-center">
                        <img src="<?= $animal->getIconUrl() ?>" alt="<?= $animal->getName() ?>" width="64">
                        <div class="font-semibold"><?= $animal->getName() ?></div>
                    </div>

                    <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button
                                class="bg-blue-500 hover:bg-blue-600 text-white p-1.5 rounded-lg text-xs"
                                onclick="editAnimal(<?= $animal->getId() ?>, '<?= $animal->getName() ?>')"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteAnimal(<?= $animal->getId() ?>, '<?= $animal->getName() ?>')"
                                class="bg-red-500 hover:bg-red-600 text-white p-1.5 rounded-lg text-xs">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

    <!-- Modal d'édition -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-96 shadow-2xl">
            <h3 class="text-xl font-bold mb-4">Modifier l'animal</h3>
            <form id="editForm" method="POST" action="traitement.php">
                <input type="hidden" name="action" value="edit_animal">
                <input type="hidden" name="animal_id" id="editId">

                <label class="block mb-2 font-semibold text-gray-700">Nom:</label>
                <input type="text" name="animal_name" id="editName"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>

                <div class="flex gap-2">
                    <button type="submit"
                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg font-semibold">
                        Enregistrer
                    </button>
                    <button type="button" onclick="closeModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 rounded-lg font-semibold">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Formulaire de suppression caché -->
    <form id="deleteForm" method="POST" action="traitement.php" class="hidden">
        <input type="hidden" name="action" value="delete_animal">
        <input type="hidden" name="animal_id" id="deleteId">
    </form>

    <script>
        const editAnimal = (id, name) => {
            console.log({id, name})
            document.getElementById('editId').value = id
            document.getElementById('editName').value = name
            document.getElementById('editModal').classList.remove('hidden')
        }

        const closeModal = () => document.getElementById('editModal').classList.add('hidden')

        const deleteAnimal = (id, name) => {
            if (confirm(`Êtes-vous sûr de vouloir supprimer ${name} ?`)) {
                document.getElementById('deleteId').value = id
                document.getElementById('deleteForm').submit()
            }
        }

        // Fermer la modal en cliquant à l'extérieur
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>

<?php
$content = ob_get_clean();
$title = "Accueil - Gestion du Zoo";
require_once '../app/views/layout.php';
