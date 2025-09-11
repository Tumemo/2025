<!-- <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Errou</title>
</head>
<body>
    <div>
        <h1>Você errou, tente novamente!</h1>
        <button><a href="palpite.php">Voltar</a></button>
    </div>
</body>
</html> -->
<?php
session_start();

if (!isset($_SESSION['jogo_iniciado']) || $_SESSION['jogo_iniciado'] === false) {
    header("Location: index.php");
    exit();
}

$ultimo_palpite = $_SESSION['ultimo_palpite'];
$numero_sorteado = $_SESSION['numero_sorteado'];

if ($_SESSION['vidas'] <= 0) {
    header("Location: perdeu.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Errou!</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <h2>Você errou!</h2>
        <p>Seu palpite foi: <?php echo $ultimo_palpite; ?></p>
        <?php if ($ultimo_palpite < $numero_sorteado): ?>
            <p>O número é **maior**!</p>
        <?php else: ?>
            <p>O número é **menor**!</p>
        <?php endif; ?>
        <p>Vidas restantes: <?php echo $_SESSION['vidas']; ?></p>
        <form action="palpite.php" method="GET">
            <button type="submit">Tentar novamente</button>
        </form>
    </div>
</body>
</html>