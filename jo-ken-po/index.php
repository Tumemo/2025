<?php
// index.php
session_start();

// Inicializa o placar se ele não existir na sessão
if (!isset($_SESSION['placar_usuario'])) {
    $_SESSION['placar_usuario'] = 0;
}
if (!isset($_SESSION['placar_oponente'])) {
    $_SESSION['placar_oponente'] = 0;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jokenpô Mania</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Jokenpô Mania</h1>
        <div class="placar">
            <div class="placar-item">
                Você
                <span><?php echo $_SESSION['placar_usuario']; ?></span>
            </div>
            <div class="placar-item">
                Oponente
                <span><?php echo $_SESSION['placar_oponente']; ?></span>
            </div>
        </div>

        <p>Faça sua escolha para a próxima rodada!</p>

        <form action="verificar.php" method="post">
            <div class="escolhas">
                <button type="submit" name="escolha" value="pedra" class="btn-escolha">
                    <span>✊</span>
                </button>
                <button type="submit" name="escolha" value="papel" class="btn-escolha">
                    <span>✋</span>
                </button>
                <button type="submit" name="escolha" value="tesoura" class="btn-escolha">
                    <span>✌️</span>
                </button>
            </div>
        </form>

        <a href="reset.php" class="reset-link">Zerar Placar</a>
    </div>
</body>
</html>
