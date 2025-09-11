<!-- php 
session_start();

$estado = $_SESSION['estado'];
$vida = 5;
if($estado == "inicio"){
     $num1 = rand(0,100);
}
$_SESSION['num1'] = $num1;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo</title>
</head>
<body>
    <div>
        php 
        echo $num1;
        ?>
        <form action="verificar.php" method="post">
            <h1>Tente adivinhar o número...</h1>
            <input type="text" name="resp" placeholder="Digite aqui...">
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html> -->

<?php
session_start();

if (!isset($_SESSION['jogo_iniciado']) || $_SESSION['jogo_iniciado'] === false) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Seu Palpite</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <h2>Faça seu Palpite</h2>
        <p>Vidas restantes: <?php echo $_SESSION['vidas']; ?></p>
        <form action="verificar.php" method="POST">
            <label for="palpite">Digite seu palpite:</label>
            <input type="number" id="palpite" name="palpite" min="0" max="100" required>
            <button type="submit">Verificar</button>
        </form>
    </div>
    <script>
        console.log("Número secreto para fins de teste: " + <?php echo $_SESSION['numero_sorteado']; ?>);
    </script>
</body>
</html>