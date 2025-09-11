<?php
session_start();
// Se não houver jogadas na sessão, redireciona para o início
if (!isset($_SESSION['jogada_usuario'])) {
    header('Location: index.php');
    exit();
}

// Mapeia as escolhas para emojis
$mapa_emoji = [
    'pedra' => '✊',
    'papel' => '✋',
    'tesoura' => '✌️'
];

$emoji_usuario = $mapa_emoji[$_SESSION['jogada_usuario']];
$emoji_oponente = $mapa_emoji[$_SESSION['jogada_oponente']];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Você Venceu!</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container resultado-container">
        <h1 class="resultado-titulo resultado-vitoria">Você Venceu!</h1>
        <div class="jogadas">
            <div class="jogada-item">Você<span><?php echo $emoji_usuario; ?></span></div>
            <div class="jogada-item">Oponente<span><?php echo $emoji_oponente; ?></span></div>
        </div>
        <a href="index.php" class="btn-acao">Jogar Novamente</a>
    </div>
</body>
</html>
