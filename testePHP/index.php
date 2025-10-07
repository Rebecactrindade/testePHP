<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $idade = trim($_POST['idade'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');

    if (empty($nome) || empty($idade) || empty($cpf)) {
        echo "<h1>Erro: Todos os campos são obrigatórios!</h1>";
        echo "<br><a href='index.php'>Voltar</a>";
        exit;
    }

    if (!is_numeric($idade) || $idade < 0 || $idade > 999) {
        echo "<h1>Erro: Idade inválida. Deve estar entre 0 e 999.</h1>";
        echo "<br><a href='index.php'>Voltar</a>";
        exit;
    }

    if (!preg_match('/^\d{11}$/', $cpf)) {
        echo "<h1>Erro: CPF inválido. Deve conter exatamente 11 números.</h1>";
        echo "<br><a href='index.php'>Voltar</a>";
        exit;
    }

    $host = 'localhost';
    $usuario = 'root';
    $senha = ''; 
    $banco = 'cadastro_php';

    $conn = new mysqli($host, $usuario, $senha, $banco);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO pessoas (nome, idade, cpf) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nome, $idade, $cpf);

    if ($stmt->execute()) {
        echo "<h1>Dados Recebidos e Salvos com Sucesso:</h1>";
        echo "Nome: " . htmlspecialchars($nome) . "<br>";
        echo "Idade: " . htmlspecialchars($idade) . "<br>";
        echo "CPF: " . htmlspecialchars($cpf) . "<br>";
    } else {
        echo "<h1>Erro ao salvar dados: " . htmlspecialchars($stmt->error) . "</h1>";
    }

    $stmt->close();
    $conn->close();

    echo "<br><a href='index.php'>Voltar</a>";
    exit; 
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Pessoa</title>
</head>
<body>
    <h1>Formulário de Cadastro</h1>
    <form action="index.php" method="post">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="idade">Idade:</label><br>
        <input 
            type="text" 
            id="idade" 
            name="idade" 
            required 
            maxlength="3" 
            pattern="\d{1,3}" 
            title="Digite uma idade entre 0 e 999" 
            inputmode="numeric"
        ><br><br>

        <label for="cpf">CPF:</label><br>
        <input 
            type="text" 
            id="cpf" 
            name="cpf" 
            required 
            maxlength="11" 
            pattern="\d{11}" 
            title="Digite exatamente 11 números" 
            inputmode="numeric"
        ><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
