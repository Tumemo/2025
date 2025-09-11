<!-- <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Derrota</title>
</head>
<body>
    <div>
        <h1>Infelizmente você perdeu :(</h1>
        <button><a href="index.html">Voltar</a></button>
    </div>
</body>
</html> -->

<?php
session_start();

// Redireciona para o index se o jogo não estiver iniciado
if (!isset($_SESSION['jogo_iniciado']) || $_SESSION['jogo_iniciado'] === false) {
    header("Location: index.php");
    exit();
}

// Armazena o número sorteado antes de resetar a sessão
$numero_sorteado = $_SESSION['numero_sorteado'];

// Para o jogo
$_SESSION['jogo_iniciado'] = false;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Você Perdeu!</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <h1>Você Perdeu!</h1>
        <p>Suas vidas acabaram. O número era: **<?php echo $numero_sorteado; ?>**</p>
        <form action="index.php" method="GET">
            <button type="submit">Jogar Novamente</button>
        </form>
    </div>
</body>
</html>