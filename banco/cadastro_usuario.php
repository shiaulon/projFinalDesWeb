<?php
// Incluir o arquivo de conexão com o banco de dados
include('../db.php');

// Verificar se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = $_POST['telefone'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);  // Criptografar a senha
    $cep = $_POST['cep'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $complemento = $_POST['complemento'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    // Prepare a consulta SQL para inserção dos dados
    $sql = "INSERT INTO tb_usuario (nome, email, data_nascimento, telefone, senha, cep, rua, numero, bairro, complemento, cidade, estado) 
            VALUES (:nome, :email, :data_nascimento, :telefone, :senha, :cep, :rua, :numero, :bairro, :complemento, :cidade, :estado)";
    
    // Verificar se a conexão foi bem-sucedida
    if ($pdo) {
        try {
            // Preparar a consulta SQL
            $stmt = $pdo->prepare($sql);
            
            // Associar os parâmetros da consulta com as variáveis
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':data_nascimento', $data_nascimento);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':cep', $cep);
            $stmt->bindParam(':rua', $rua);
            $stmt->bindParam(':numero', $numero);
            $stmt->bindParam(':bairro', $bairro);
            $stmt->bindParam(':complemento', $complemento);
            $stmt->bindParam(':cidade', $cidade);
            $stmt->bindParam(':estado', $estado);

            // Executar a consulta e verificar o sucesso
            if ($stmt->execute()) {
                echo "Cadastro realizado com sucesso!";
                header('Location: ../menu.php');
            } else {
                echo "Erro ao realizar o cadastro. Tente novamente mais tarde.";
            }
        } catch (PDOException $e) {
            // Caso haja erro na execução da consulta
            echo "Erro ao inserir dados: " . $e->getMessage();
        }
    } else {
        echo "Erro ao conectar ao banco de dados.";
    }
}
?>
