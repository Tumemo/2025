<?php
session_start();
$numero1 = $_SESSION['numero1']; 
$numero2 = $_SESSION['numero2'];

$multiplicação = $numero1*$numero2;

$resultado = (int)$_POST['resp'];

if($resultado == $multiplicação){
    header('location: acerto.php');
} else {
    header('location:erro.php');
}