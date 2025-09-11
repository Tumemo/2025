<?php 
session_start();

$numero1 = rand(0,10);
$numero2 = rand(0,10);

$_SESSION['numero1'] = $numero1;
$_SESSION['numero2'] = $numero2;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tabuada</title>
</head>
<body>
    <div>
        <form action="verificar.php" method="post">
        <h1>Qual o resultado da conta?</h1>
        <p><?php 
            echo $numero1 . "x" . $numero2 . "="
        ?></p>
        <input type="text" name="resp" placeholder="Digite sua resposta..."><br>
        <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>