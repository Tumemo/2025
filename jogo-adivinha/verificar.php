<!-- php 
session_start();

$num1 = (int)$_SESSION['num1'];
$resp = (int)$_POST['resp'];

if($resp == $num1){
    header('Location: ganhou.php');
} else {
    header('Location: erro.php');
}
?> -->

<?php
session_start();

if (!isset($_SESSION['jogo_iniciado']) || $_SESSION['jogo_iniciado'] === false || !isset($_POST['palpite'])) {
    header("Location: index.php");
    exit();
}

$palpite = (int)$_POST['palpite'];
$numero_sorteado = $_SESSION['numero_sorteado'];

if ($palpite == $numero_sorteado) {
    header("Location: ganhou.php");
    exit();
} else {
    $_SESSION['vidas']--;
    
    $_SESSION['ultimo_palpite'] = $palpite;
    
    header("Location: errou.php");
    exit();
}
?>