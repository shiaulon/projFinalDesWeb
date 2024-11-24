<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <div class="cadastro-container">
        <h2>Cadastro</h2>
        <form action="banco/cadastro_usuario.php" method="POST" onsubmit="return validarCadastro()">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="date" name="data_nascimento" placeholder="Data de Nascimento">
            <input type="text" name="telefone" placeholder="Telefone">
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="password" name="confirma_senha" placeholder="Confirmar Senha" required>
            <input type="text" name="cep" placeholder="CEP">
            <input type="text" name="rua" placeholder="Rua">
            <input type="text" name="numero" placeholder="Número">
            <input type="text" name="bairro" placeholder="Bairro">
            <input type="text" name="complemento" placeholder="Complemento">
            <input type="text" name="cidade" placeholder="Cidade">
            <input type="text" name="estado" placeholder="Estado">
            <button type="submit">Cadastrar</button>
        </form>
    </div>

    <script>
        function validarCadastro() {
            let senha = document.querySelector("input[name='senha']").value;
            let confirmaSenha = document.querySelector("input[name='confirma_senha']").value;
            if (senha !== confirmaSenha) {
                alert("As senhas não coincidem!");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
