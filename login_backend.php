<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $email = $_POST['email'] ?? null;
    $senha = $_POST['senha'] ?? null;

    if ($email && $senha) {
        // Busca o usuário no banco de dados
        $query = "SELECT * FROM tb_usuarios WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e a senha está correta
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Inicia a sessão e armazena os dados do usuário
            $_SESSION['IdUsuario'] = $usuario['id'];
            $_SESSION['NomeUsuario'] = $usuario['nome'];
            $_SESSION['EmailUsuario'] = $usuario['email'];

            // Redireciona para a página principal ou a página de produtos
            header('Location: index.php');
            exit();
        } else {
            // Mensagem de erro caso o login falhe
            $erro = "E-mail ou senha incorretos!";
        }
    } else {
        // Mensagem de erro caso o formulário não seja preenchido corretamente
        $erro = "Por favor, preencha todos os campos!";
    }
}
?>
