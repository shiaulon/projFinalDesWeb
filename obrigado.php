<?php
session_start();

// Gerando um número de pedido aleatório (você pode alterar isso para algo mais robusto)
$numeroPedido = rand(1000, 9999);

// Definindo a previsão de tempo para o pedido ficar pronto (exemplo: 30 minutos)
$tempoPrevisao = '30 minutos';


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agradecimento - BonApettit</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f8d7e3;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #333;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header div, header a {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        header a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: red;
        }

        header a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        #btnVoltar {
            cursor: pointer;
        }

        #iconeCarrinho {
            cursor: pointer;
            font-size: 1.5rem;
            position: relative;
        }

        #iconeCarrinho span {
            background-color: red;
            color: white;
            font-size: 0.8rem;
            font-weight: bold;
            border-radius: 50%;
            padding: 2px 5px;
            position: absolute;
            top: -10px;
            right: -10px;
        }

        /* Alterando o fundo da seção Sorvetes Disponíveis */
        .category-page-container {
            padding: 20px;
        }

        .category-title h1 {
            text-align: center;
            margin: 20px 0;
            background-color: #f8d7e3; /* Cor diferente para o título */
            padding: 10px;
            border-radius: 10px;
        }

        .items-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .category-item {
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .category-item img {
            max-width: 100%;
            border-radius: 10px;
        }

        .btn-adicionar {
            background-color: #f90;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-adicionar:hover {
            background-color: #e68a00;
        }
    </style>
</head>
<body>
<header>
        <!-- Botão de voltar -->
        <div id="btnVoltar" onclick="window.location.href='menu.php'">
            🔙 Voltar
        </div>

        

        <!-- Botão de logout -->
        <?php if (isset($_SESSION['IdUsuario'])): ?>
            <a href="logout.php">🔌 Sair</a>
        <?php endif; ?>
    </header>

    <!-- Conteúdo da Página -->
    <section class="thank-you-container">
        <h1>Obrigado pelo seu pedido!</h1>

        <p>Estamos felizes por você ter feito seu pedido no BonApettit!</p>

        <div class="order-info">
            <p><strong>Número do Pedido:</strong> <?= $numeroPedido; ?></p>
            <p><strong>Previsão de Entrega:</strong> <?= $tempoPrevisao; ?></p>
        </div>

        <div class="contact-info">
            <h3>Informações de Contato:</h3>
            <p>Telefone: (11) 1234-5678</p>
            <p>Email: contato@bonapettit.com.br</p>
            <p>Endereço: Rua São José, 123 - Centro</p>
        </div>
    </section>

</body>
</html>
