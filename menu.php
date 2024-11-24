<?php
session_start();
include('db.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['IdUsuario'])) {
    header('Location: ./banco/login.php');
    exit();
}

$carrinhoCount = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - BonApettit</title>
    <link rel="stylesheet" href="menu.css?v=<?php echo time(); ?>">
    <style>
        body {
            background-color: #f8d7e3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        header {
            background-color: #333;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            box-sizing: border-box;
        }

        .menu-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            text-align: center;
        }

        .category-box {
            background-color: #333; /* Nova cor de fundo */
            color: white;
            padding: 30px; /* Mais espaço interno */
            width: 200px; /* Largura maior */
            height: 150px; /* Altura maior */
            border: 1px solid #ccc;
            border-radius: 15px; /* Bordas arredondadas */
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .category-box:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }

        #iconeCarrinho {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 1.2rem;
        }

        #iconeCarrinho:hover {
            color: #f90;
        }

        a[href="logout.php"] {
            background-color: red;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
        }

        a[href="logout.php"]:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <header>
        <div id="iconeCarrinho" onclick="window.location.href='carrinho.php'">
            🛒 <span>Carrinho (<?= $carrinhoCount > 0 ? $carrinhoCount : '0'; ?>)</span>
        </div>
        <?php if (isset($_SESSION['IdUsuario'])): ?>
            <a href="logout.php">🔌 Sair</a>
        <?php else: ?>
            <a href="./banco/login.php">Login</a> | <a href="cadastro.php">Cadastrar</a>
        <?php endif; ?>
    </header>

    <div class="menu-container">
        <div class="category-box" onclick="window.location.href='sorvete.php'">
            <h2>Sorvetes</h2>
        </div>
        <div class="category-box" onclick="window.location.href='tacas.php'">
            <h2>Taças</h2>
        </div>
        <div class="category-box" onclick="window.location.href='bebidas.php'">
            <h2>Bebidas</h2>
        </div>
        <div class="category-box" onclick="window.location.href='especiais.php'">
            <h2>Especiais</h2>
        </div>
    </div>
</body>
</html>
