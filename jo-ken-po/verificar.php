<?php
// verificar.php
session_start();

// Valida se uma escolha foi feita
if (!isset($_POST['escolha'])) {
    header('Location: index.php');
    exit();
}

// Opções do jogo
$opcoes = ['pedra', 'papel', 'tesoura'];

// Escolhas
$escolhaUsuario = $_POST['escolha'];
$escolhaOponente = $opcoes[array_rand($opcoes)];

// Armazena as jogadas na sessão para exibir na tela de resultado
$_SESSION['jogada_usuario'] = $escolhaUsuario;
$_SESSION['jogada_oponente'] = $escolhaOponente;

// Lógica de Verificação
if ($escolhaUsuario == $escolhaOponente) {
    // Empate
    header('Location: empate.php');
    exit();
} elseif (
    ($escolhaUsuario == 'pedra' && $escolhaOponente == 'tesoura') ||
    ($escolhaUsuario == 'papel' && $escolhaOponente == 'pedra') ||
    ($escolhaUsuario == 'tesoura' && $escolhaOponente == 'papel')
) {
    // Vitória do Usuário
    $_SESSION['placar_usuario']++;
    header('Location: vitoria.php');
    exit();
} else {
    // Derrota do Usuário
    $_SESSION['placar_oponente']++;
    header('Location: derrota.php');
    exit();
}
?>