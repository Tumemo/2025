const canvas = document.getElementById('game-canvas');
const startButton = document.getElementById('start-button');
const scoreDisplay = document.getElementById('current-score');
const highScoresList = document.getElementById('high-scores-list');
const loginSection = document.getElementById('login-section');
const gameSection = document.getElementById('game-section');
const loginForm = document.getElementById('login-form');

// --- Configurações do Jogo ---
// Ajustei o gridSize para que a cobra e a bolinha não fiquem tão pequenas.
// Se quiser algo diferente, ajuste este valor.
const gridSize = 20; // Tamanho de cada "quadrado" no tabuleiro
const canvasSize = 400; // Tamanho total do canvas em pixels (deve ser múltiplo de gridSize)
const tileCount = canvasSize / gridSize; // Número de tiles no tabuleiro

// Aumentei o tamanho inicial da cobra e a posição inicial para não começar colidindo.
let snake = [{ x: Math.floor(tileCount / 2) - 1, y: Math.floor(tileCount / 2) }]; // Cobra começa no centro
let food = {};
let dx = 0;
let dy = 0;
let score = 0;
let gameInterval;
let gameSpeed = 150; // Velocidade inicial (quanto menor, mais rápido)
let username = '';
let isGameOver = false; // Flag para controlar o estado do jogo

// --- Event Listeners ---
loginForm.addEventListener('submit', handleLogin);
startButton.addEventListener('click', startGame);
// Evento de teclado para controlar a cobra
document.addEventListener('keydown', changeDirection);

// --- Funções de Login e Pontuação ---

function handleLogin(event) {
    event.preventDefault();
    const usernameInput = document.getElementById('username');
    username = usernameInput.value.trim(); // Remove espaços em branco no início e fim

    if (username) {
        loginSection.style.display = 'none';
        gameSection.style.display = 'block';
        loadHighScores();
        resetGame(); // Reseta o jogo para um estado inicial antes de jogar
    } else {
        alert('Por favor, insira um nome de usuário.');
    }
}

function loadHighScores() {
    fetch('login.php?action=get_scores')
        .then(response => {
            // Verifica se a resposta foi bem sucedida
            if (!response.ok) {
                // Se a resposta não for OK, lança um erro com o status
                throw new Error(`Erro HTTP: ${response.status} ${response.statusText}`);
            }
            return response.json(); // Converte a resposta em JSON
        })
        .then(data => {
            highScoresList.innerHTML = ''; // Limpa a lista atual
            if (data && Array.isArray(data) && data.length > 0) {
                // Ordena os scores na ordem decrescente (maior pontuação primeiro)
                data.sort((a, b) => b.score - a.score);
                data.forEach(entry => {
                    const li = document.createElement('li');
                    // Exibe o nome de usuário e a pontuação
                    li.textContent = `${entry.username}: ${entry.score} pontos`;
                    highScoresList.appendChild(li);
                });
            } else {
                // Mensagem se não houver pontuações registradas
                highScoresList.innerHTML = '<li>Nenhuma pontuação registrada ainda.</li>';
            }
        })
        .catch(error => {
            console.error('Erro ao carregar pontuações:', error);
            highScoresList.innerHTML = '<li>Erro ao carregar pontuações.</li>';
        });
}

function saveScore() {
    // Verifica se o nome de usuário é válido antes de tentar salvar
    if (!username) {
        console.error("Nome de usuário não definido, não é possível salvar pontuação.");
        return;
    }

    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'save_score',
            username: username,
            score: score
        }),
    })
    .then(response => {
        if (!response.ok) {
            // Se a resposta não for OK, tenta ler a mensagem de erro do JSON, se disponível
            return response.json().then(err => { throw new Error(`HTTP error ${response.status}: ${err.message || 'Unknown error'}`); });
        }
        return response.json();
    })
    .then(data => {
        console.log('Resposta do servidor ao salvar pontuação:', data);
        if (data.status === 'success') {
            console.log('Pontuação salva com sucesso!');
            loadHighScores(); // Atualiza o placar após salvar
        } else {
            console.error('Falha ao salvar pontuação:', data.message);
            alert(`Erro ao salvar pontuação: ${data.message}`);
        }
    })
    .catch(error => {
        console.error('Erro na requisição para salvar pontuação:', error);
        alert(`Não foi possível salvar sua pontuação. Erro: ${error.message}`);
    });
}

// --- Lógica do Jogo ---

function resetGame() {
    // Reseta o estado do jogo
    snake = [{ x: Math.floor(tileCount / 2) - 1, y: Math.floor(tileCount / 2) }]; // Começa no centro
    dx = 0;
    dy = 0;
    score = 0;
    scoreDisplay.textContent = score;
    gameSpeed = 150; // Reseta a velocidade
    isGameOver = false; // Reseta a flag de game over

    generateFood(); // Gera a primeira comida
    drawGame(); // Desenha o estado inicial

    startButton.style.display = 'block'; // Mostra o botão de iniciar
    if (gameInterval) {
        clearInterval(gameInterval); // Limpa qualquer intervalo ativo anterior
    }
}

function startGame() {
    // Inicia o jogo
    if (isGameOver) return; // Não inicia se já acabou
    startButton.style.display = 'none'; // Esconde o botão de iniciar
    
    // Define a direção inicial ao clicar em iniciar
    dx = gridSize; // Começa movendo para a direita
    dy = 0;

    // Limpa qualquer intervalo anterior para evitar múltiplas execuções
    if (gameInterval) {
        clearInterval(gameInterval);
    }
    // Inicia o loop do jogo
    gameInterval = setInterval(gameLoop, gameSpeed);
}

function gameLoop() {
    if (isGameOver) return; // Para o loop se o jogo acabou

    moveSnake();
    checkCollision();
    drawGame();
}

function generateFood() {
    // Gera comida em uma posição aleatória que não esteja sobre a cobra
    food = {
        x: Math.floor(Math.random() * tileCount) * gridSize,
        y: Math.floor(Math.random() * tileCount) * gridSize
    };

    // Garante que a comida não apareça em cima da cobra
    snake.forEach(segment => {
        if (segment.x === food.x && segment.y === food.y) {
            generateFood(); // Gera novamente se houver colisão com a cobra
        }
    });
}

function drawGame() {
    canvas.innerHTML = ''; // Limpa o canvas antes de redesenhar

    // Desenha a comida
    const foodElement = document.createElement('div');
    foodElement.className = 'food';
    foodElement.style.position = 'absolute';
    foodElement.style.left = `${food.x}px`;
    foodElement.style.top = `${food.y}px`;
    foodElement.style.width = `${gridSize}px`;
    foodElement.style.height = `${gridSize}px`;
    canvas.appendChild(foodElement);

    // Desenha a cobra
    snake.forEach((segment, index) => {
        const snakeElement = document.createElement('div');
        snakeElement.className = 'snake-body';
        snakeElement.style.position = 'absolute';
        snakeElement.style.left = `${segment.x}px`;
        snakeElement.style.top = `${segment.y}px`;
        snakeElement.style.width = `${gridSize}px`;
        snakeElement.style.height = `${gridSize}px`;
        
        // Pinta a cabeça de uma cor diferente (opcional)
        if (index === 0) {
            snakeElement.style.backgroundColor = '#00ff7f'; // Verde mais claro para a cabeça
            snakeElement.style.borderColor = '#008000';
        }
        
        canvas.appendChild(snakeElement);
    });
}

function moveSnake() {
    // Calcula a nova posição da cabeça
    const head = { x: snake[0].x + dx, y: snake[0].y + dy };

    // Adiciona a nova cabeça ao início da cobra
    snake.unshift(head);

    // Verifica se a cobra comeu a comida
    if (head.x === food.x && head.y === food.y) {
        score += 1; // Ganha 1 ponto
        scoreDisplay.textContent = score;

        // Aumenta a velocidade do jogo
        if (gameSpeed > 50) { // Limite de velocidade para não ficar impossível
            gameSpeed -= 5; // Aumenta a velocidade a cada ponto
            clearInterval(gameInterval);
            gameInterval = setInterval(gameLoop, gameSpeed);
        }
        generateFood(); // Gera nova comida
    } else {
        // Se não comeu, remove o último segmento da cobra
        snake.pop();
    }
}

function checkCollision() {
    const head = snake[0];

    // Colisão com as bordas do canvas
    if (head.x < 0 || head.x >= canvasSize || head.y < 0 || head.y >= canvasSize) {
        gameOver();
        return;
    }

    // Colisão com o próprio corpo da cobra
    for (let i = 1; i < snake.length; i++) {
        if (head.x === snake[i].x && head.y === snake[i].y) {
            gameOver();
            return;
        }
    }
}

function changeDirection(event) {
    // Se o jogo acabou, não permite mudar a direção
    if (isGameOver) return;

    const LEFT_KEY = 37;
    const RIGHT_KEY = 39;
    const UP_KEY = 38;
    const DOWN_KEY = 40;

    const key = event.keyCode;

    // Previne o comportamento padrão do navegador para as teclas de seta (rolagem da página)
    if ([LEFT_KEY, RIGHT_KEY, UP_KEY, DOWN_KEY].includes(key)) {
        event.preventDefault();
    }

    // Define a nova direção, impedindo que a cobra volte para a direção oposta imediatamente
    const movingUp = dy === -gridSize;
    const movingDown = dy === gridSize;
    const movingLeft = dx === -gridSize;
    const movingRight = dx === gridSize;

    if (key === UP_KEY && !movingDown) {
        dx = 0;
        dy = -gridSize;
    }
    if (key === DOWN_KEY && !movingUp) {
        dx = 0;
        dy = gridSize;
    }
    if (key === LEFT_KEY && !movingRight) {
        dx = -gridSize;
        dy = 0;
    }
    if (key === RIGHT_KEY && !movingLeft) {
        dx = gridSize;
        dy = 0;
    }
}

function gameOver() {
    isGameOver = true; // Marca o jogo como terminado
    clearInterval(gameInterval); // Para o loop do jogo
    alert(`Fim de Jogo, ${username}! Sua pontuação foi: ${score}`);
    saveScore(); // Tenta salvar a pontuação
    resetGame(); // Reseta o jogo para poder jogar novamente
}

// Inicializa o placar ao carregar a página
loadHighScores();