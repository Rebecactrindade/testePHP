<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $idade = $_POST['idade'] ?? '';
    $cpf = $_POST['cpf'] ?? '';

    echo "<h1>Dados Recebidos:</h1>";
    echo "Nome: " . htmlspecialchars($nome) . "<br>";
    echo "Idade: " . htmlspecialchars($idade) . "<br>";
    echo "CPF: " . htmlspecialchars($cpf) . "<br>";
} else {
    echo "Acesso inválido!";
}
?>
