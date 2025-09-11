<?php
// reset.php
session_start();

// Destrói a sessão para zerar o placar
session_destroy();

// Redireciona de volta para a página inicial
header('Location: index.php');
exit();
?>