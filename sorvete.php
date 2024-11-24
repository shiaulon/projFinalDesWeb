<?php
session_start();
include('db.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['IdUsuario'])) {
    header('Location: login.php');
    exit();
}

// Categoria de sorvetes
$categoria = 'Sorvetes';
$query = "SELECT i.id, i.nome, i.descricao, i.preco, i.foto 
          FROM tb_itens i
          JOIN tb_categoria c ON i.idCategoria = c.id
          WHERE c.nome = :categoria";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
$stmt->execute();
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar itens no carrinho
$totalCarrinho = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;

// Adicionando ao carrinho
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $idItem = $_POST['idItem'] ?? null;
    $preco = $_POST['preco'] ?? null;
    $nome = $_POST['nome'] ?? 'Produto sem nome';

    if ($idItem && $preco) {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        $_SESSION['carrinho'][] = [
            'idItem' => $idItem,
            'quantidade' => 1,
            'preco' => $preco,
            'nome' => $nome
        ];
        $totalCarrinho = count($_SESSION['carrinho']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorvetes - BonApettit</title>
    <link rel="stylesheet" href="categoria.css">
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
    background-color: #f8d7e3;
    padding: 10px;
    border-radius: 10px;
}

.items-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Ajuste dinâmico para diferentes tamanhos de tela */
    gap: 20px;
    padding: 20px;
}

.category-item {
    background-color: #fff;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Ajusta os itens verticalmente */
    height: 400px; /* Garante que todos os itens tenham a mesma altura */
    width: 100%; /* Garante que os itens se expandam até preencher a largura do grid */
    box-sizing: border-box; /* Inclui o padding no cálculo da largura */
}

.category-item img {
    max-width: 100%;
    height: 150px; /* Definindo uma altura fixa para as imagens */
    object-fit: cover; /* Garante que a imagem não distorça */
    border-radius: 10px;
}

.category-item h3 {
    font-size: 1.2rem;
    margin-top: 10px;
    word-wrap: break-word; /* Garante que o texto quebre corretamente */
}

.category-item p {
    font-size: 1rem;
    margin: 10px 0;
    word-wrap: break-word; /* Garante que o texto se ajuste dentro do item */
    overflow: hidden; /* Esconde o conteúdo extra que ultrapassar a largura */
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

        <!-- Ícone do carrinho com contador -->
        <div id="iconeCarrinho" onclick="window.location.href='carrinho.php'">
            🛒 Carrinho
            <?php if ($totalCarrinho > 0): ?>
                <span><?= $totalCarrinho ?></span>
            <?php endif; ?>
        </div>

        <!-- Botão de logout -->
        <?php if (isset($_SESSION['IdUsuario'])): ?>
            <a href="logout.php">🔌 Sair</a>
        <?php endif; ?>
    </header>

    <section class="category-page-container">
        <div class="category-title">
            <h1>Sorvetes Disponíveis</h1>
        </div>
        
        <div class="items-container">
            <?php if (!empty($itens)): ?>
                <?php foreach ($itens as $item): ?>
                    <div class="category-item">
                        <img src="data:image/jpeg;base64,<?= base64_encode($item['foto']); ?>" alt="<?= htmlspecialchars($item['nome']); ?>">
                        <h3><?= htmlspecialchars($item['nome']); ?></h3>
                        <p><?= htmlspecialchars($item['descricao']); ?></p>
                        <p>Preço: R$ <?= number_format($item['preco'], 2, ',', '.'); ?></p>
                        <form method="POST">
                            <input type="hidden" name="idItem" value="<?= $item['id']; ?>">
                            <input type="hidden" name="preco" value="<?= $item['preco']; ?>">
                            <input type="hidden" name="nome" value="<?= htmlspecialchars($item['nome']); ?>">
                            <button type="submit" name="add_to_cart" class="btn-adicionar">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Não há sorvetes disponíveis no momento.</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
