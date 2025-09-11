<?php
// Mapeamento de opções
$opcoes = ["pedra", "papel", "tesoura"];

// Recebe a escolha do usuário
$escolha_usuario = isset($_POST['escolha']) ? $_POST['escolha'] : null;

// Sorteia a escolha do computador
$escolha_computador = $opcoes[array_rand($opcoes)];

$resultado = "";

// Verifica se a escolha do usuário é válida
if ($escolha_usuario === null || !in_array($escolha_usuario, $opcoes)) {
    $resultado = "Por favor, faça uma escolha válida.";
} else {
    // Lógica do jogo
    if ($escolha_usuario == $escolha_computador) {
        $resultado = "Empate!";
        $classe_resultado = "draw";
    } elseif (
        ($escolha_usuario == "pedra" && $escolha_computador == "tesoura") ||
        ($escolha_usuario == "papel" && $escolha_computador == "pedra") ||
        ($escolha_usuario == "tesoura" && $escolha_computador == "papel")
    ) {
        $resultado = "Você ganhou! 🎉";
        $classe_resultado = "win";
    } else {
        $resultado = "Você perdeu! 😔";
        $classe_resultado = "lose";
    }
}

// Mensagem completa para ser exibida
$mensagem_final = "Sua escolha: " . ucfirst($escolha_usuario) . "<br>";
$mensagem_final .= "Escolha do computador: " . ucfirst($escolha_computador) . "<br><br>";
$mensagem_final .= $resultado;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Jo-Ken-Po</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f4f8; /* Cinza claro */
            color: #333;
        }
        .container {
            background-color: #d1d8e0; /* Azul acinzentado */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 2px solid #a3b2c1;
        }
        h1 {
            color: #4b6584; /* Azul escuro */
            margin-bottom: 30px;
        }
        .result {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 1.5em;
        }
        .win {
            background-color: #82cc59; /* Verde claro */
            color: white;
        }
        .lose {
            background-color: #eb6b5c; /* Vermelho claro */
            color: white;
        }
        .draw {
            background-color: #f6b93b; /* Amarelo */
            color: white;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            font-size: 1.1em;
            color: #fff;
            background-color: #6a89cc;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #4a69bd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado do Jogo</h1>
        <div class="result <?php echo $classe_resultado; ?>">
            <?php echo $mensagem_final; ?>
        </div>
        <a href="index.html">Jogar novamente</a>
    </div>
</body>
</html>