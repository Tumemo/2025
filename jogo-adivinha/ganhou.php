<!-- <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganhou</title>
</head>
<body>
    <div>
        <h1>Parabéns!! Você acertou!</h1>
        <button><a href="index.html">Voltar</a></button>
    </div>
</body>
</html> -->
<?php
session_start();

if (!isset($_SESSION['jogo_iniciado']) || $_SESSION['jogo_iniciado'] === false) {
    header("Location: index.php");
    exit();
}

$_SESSION['jogo_iniciado'] = false;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Parabéns!</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <h1>Você Ganhou!</h1>
        <p>Parabéns, você acertou o número!</p>
        <form action="index.php" method="GET">
            <button type="submit">Jogar Novamente</button>
        </form>
    </div>
</body>
</html>