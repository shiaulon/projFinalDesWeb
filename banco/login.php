<?php
session_start();
include('../db.php');

if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM tb_usuario WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
 
        if (password_verify($senha, $usuario['senha'])) {
     
            $_SESSION['IdUsuario'] = $usuario['id'];
            $_SESSION['NomeUsuario'] = $usuario['nome'];
            header('Location: ../menu.php');
        } else {
            $erro = "E-mail ou senha inválidos!";
        }
    } else {
        $erro = "E-mail ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BonApettit - Login</title>
    <link rel="stylesheet" href="../login.css">
    <script src="../script.js"></script>
</head>
<body>

<section class="login-page">
    <h1>Login</h1>


    <?php if (isset($erro)): ?>
        <div class="error-message"><?= $erro; ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST" class="login-form">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit" class="login-button">Entrar</button>
    </form>

    <p>Ainda não tem uma conta? <a href="../cadastro.php">Cadastre-se aqui</a></p>
</section>

</body>
</html>


