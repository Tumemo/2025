<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Calculadora</title>
</head>
<body>
    <div>
        <h1>Calculadora Simples</h1>
        <form action="calcular.php" method="get">
            <label for="num1">Número 1:</label><br>
            <input type="number" name="num1" required><br>
            <label for="num2">Número 2:</label><br>
            <input type="number" name="num2" required><br>
            <button type="submit" value="+" name="operacao">+</button>
            <button type="submit" value="-" name="operacao">-</button>
            <button type="submit" value="*" name="operacao">*</button>
            <button type="submit" value="/" name="operacao">/</button>
        </form>
    </div>
</body>
</html>