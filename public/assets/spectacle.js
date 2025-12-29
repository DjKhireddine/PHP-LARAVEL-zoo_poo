const totalAnimals = document.getElementById('totalAnimals').innerText
console.log({totalAnimals})
let currentAnimal = 0;
let isPlaying = true;
let autoPlayInterval = null;
const DURATION = 7000; // 7 secondes

// Éléments DOM
const performances = document.querySelectorAll('.animal-performance');
const currentIndexEl = document.getElementById('currentIndex');
const progressBar = document.getElementById('progressBar');
const playPauseBtn = document.getElementById('playPauseBtn');
const playPauseText = document.getElementById('playPauseText');
const nextBtn = document.getElementById('nextBtn');
const restartBtn = document.getElementById('restartBtn');
const replayBtn = document.getElementById('replayBtn');
const endMessage = document.getElementById('endMessage');

function showAnimal(index) {
    performances.forEach(p => p.classList.remove('active'));
    if (index < totalAnimals) {
        performances[index].classList.add('active');
        currentIndexEl.textContent = index + 1;
    }
}

function nextAnimal() {
    currentAnimal++;
    if (currentAnimal >= totalAnimals) {
        stopShow();
        document.getElementById('animalStage').style.display = 'none';
        nextBtn.style.display = 'none';
        endMessage.classList.remove('hidden');
    } else {
        showAnimal(currentAnimal);
        resetProgress();
    }
}

function startAutoPlay() {
    isPlaying = true;
    playPauseBtn.innerHTML = '<i class="fas fa-pause mr-2"></i><span>Pause</span>';
    startProgress();
}

function pauseAutoPlay() {
    isPlaying = false;
    playPauseBtn.innerHTML = '<i class="fas fa-play mr-2"></i><span>Lecture</span>';
    clearInterval(autoPlayInterval);
}

function stopShow() {
    pauseAutoPlay();
    progressBar.style.width = '100%';
}

function restart() {
    currentAnimal = 0;
    showAnimal(0);
    endMessage.classList.add('hidden');
    document.getElementById('animalStage').style.display = 'block';
    nextBtn.style.display = 'inline-block';
    resetProgress();
    startAutoPlay();
}

function startProgress() {
    let progress = 0;
    progressBar.style.width = '0%';

    autoPlayInterval = setInterval(() => {
        if (isPlaying) {
            progress += 100 / (DURATION / 100);
            progressBar.style.width = progress + '%';

            if (progress >= 100) {
                clearInterval(autoPlayInterval);
                nextAnimal();
            }
        }
    }, 100);
}

function resetProgress() {
    clearInterval(autoPlayInterval);
    if (isPlaying && currentAnimal < totalAnimals) {
        startProgress();
    }
}

// Event listeners
playPauseBtn.addEventListener('click', () => {
    if (isPlaying) {
        pauseAutoPlay();
    } else {
        startAutoPlay();
    }
});

nextBtn.addEventListener('click', () => {
    clearInterval(autoPlayInterval);
    nextAnimal();
});

restartBtn.addEventListener('click', restart);
replayBtn.addEventListener('click', restart);

// Démarrage automatique
startAutoPlay();
