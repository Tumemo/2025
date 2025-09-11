<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Calcular</title>
    <style>
        body{
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <?php 
     $num1 = (float)$_GET['num1'];
     $num2 = (float)$_GET['num2'];
     $operador = $_GET['operacao'];
     switch ($operador) {
         case '+':
             $resultado = $num1 + $num2;
             break;
         case '-':
             $resultado = $num1 - $num2;
             break;
         case '*':
             $resultado = $num1 * $num2;
             break;
         case '/':
             if ($num2 == 0) {
                 echo "Não é possível realizar divisão por zero.";
             } else {
                 $resultado = $num1 / $num2;
             }
             break;
         default:
             echo "Operador inválido.";
             exit();
     }
    ?>
    <div>
    <?php 
        echo "<h1>$resultado</h1>";
    ?>
    </div>
</body>
</html>