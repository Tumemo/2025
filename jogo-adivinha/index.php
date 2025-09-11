<!-- php 
session_start();

$estado = $_SESSION['estado'];
if($estado == "perdeu" || $estado == "ganhou"){
    $_SESSION['estado'] = "inicio";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo-Adivinha</title>
</head>
<body>
    <div>
        <form action="palpite.php" method="post">
            <h1>Quer jogar o Jogo da Adivinhação?</h1>
            <button type="submit">Jogar</button>
        </form>
    </div>
</body>
</html> -->
<?php
session_start();

if (!isset($_SESSION['jogo_iniciado']) || $_SESSION['jogo_iniciado'] === false) {
    $_SESSION['numero_sorteado'] = rand(0, 100);
    $_SESSION['vidas'] = 5;
    $_SESSION['jogo_iniciado'] = true;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Jogo da Adivinhação</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <h1>Jogo da Adivinhação</h1>
        <p>Adivinhe um número entre 0 e 100. Você tem 5 vidas para acertar!</p>
        <form action="palpite.php" method="GET">
            <button type="submit">Começar a Jogar</button>
        </form>
    </div>
</body>
</html>