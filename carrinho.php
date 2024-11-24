<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aumentar a quantidade
    if (isset($_POST['increase_quantity'])) {
        $index = $_POST['index'] ?? null;
        if ($index !== null && isset($_SESSION['carrinho'][$index])) {
            $_SESSION['carrinho'][$index]['quantidade']++;
        }
    }

    // Diminuir a quantidade
    if (isset($_POST['decrease_quantity'])) {
        $index = $_POST['index'] ?? null;
        if ($index !== null && isset($_SESSION['carrinho'][$index]) && $_SESSION['carrinho'][$index]['quantidade'] > 1) {
            $_SESSION['carrinho'][$index]['quantidade']--;
        }
    }

    // Remover item do carrinho
    if (isset($_POST['remove_from_cart'])) {
        $index = $_POST['index'] ?? null;
        if ($index !== null && isset($_SESSION['carrinho'][$index])) {
            unset($_SESSION['carrinho'][$index]);
            // Reindexa o carrinho após remoção
            $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
        }
    }

    // Finalizar pedido
    if (isset($_POST['finalizar_pedido'])) {
        unset($_SESSION['carrinho']);

        // Redirecionar para a página de agradecimento
        header('Location: obrigado.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - BonApettit</title>
    <link rel="stylesheet" href="carrinho.css">
    <style>
        /* Estilos para o cabeçalho */
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
    <!-- Menu de Navegação -->
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

    <!-- Carrinho de Compras -->
    <section class="cart-container">
        <h2>Carrinho de Compras</h2>
        <div class="cart-items">
            <?php if (!empty($_SESSION['carrinho'])): ?>
                <ul>
                    <?php 
                    $valorTotal = 0;
                    foreach ($_SESSION['carrinho'] as $index => $item): 
                        $nome = isset($item['nome']) ? htmlspecialchars($item['nome']) : 'Produto sem nome';
                        $quantidade = isset($item['quantidade']) ? (int)$item['quantidade'] : 0;
                        $preco = isset($item['preco']) ? (float)$item['preco'] : 0.00;
                        $subtotal = $quantidade * $preco;
                        $valorTotal += $subtotal;
                    ?>
                        <li class="cart-item">
                            <h3><?= $nome; ?></h3>
                            <p>Quantidade: <?= $quantidade; ?></p>
                            <p>Preço unitário: R$ <?= number_format($preco, 2, ',', '.'); ?></p>
                            <p>Subtotal: R$ <?= number_format($subtotal, 2, ',', '.'); ?></p>
                            
                            <!-- Botões de Aumentar e Diminuir Quantidade -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="index" value="<?= $index; ?>">
                                <button type="submit" name="decrease_quantity" class="btn-quantidade">-</button>
                                <button type="submit" name="increase_quantity" class="btn-quantidade">+</button>
                            </form>

                            <!-- Botão de Remover -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="index" value="<?= $index; ?>">
                                <button type="submit" name="remove_from_cart" class="btn-remover">Remover</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="cart-total">
                    <h3>Valor Total: R$ <?= number_format($valorTotal, 2, ',', '.'); ?></h3>
                </div>
                <form method="POST">
                    <button type="submit" name="finalizar_pedido" class="btn-finalizar">Finalizar Pedido</button>
                </form>
            <?php else: ?>
                <p>Seu carrinho está vazio.</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
