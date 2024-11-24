<?php
session_start();
include('db.php');

if (!isset($_SESSION['IdUsuario'])) {
    header('Location: /banco/login.php');
    exit();
}

$idUsuario = $_SESSION['IdUsuario'];

if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
    foreach ($_SESSION['carrinho'] as $item) {
        $query = "INSERT INTO tb_itens_pedido(idUsuario, idItem, quantidade, preco) 
                  VALUES (:idUsuario, :idItem, :quantidade, :preco)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':idUsuario' => $idUsuario,
            ':idItem' => $item['idItem'],
            ':quantidade' => $item['quantidade'],
            ':preco' => $item['preco']
        ]);
    }

    // Limpar o carrinho após finalizar o pedido
    unset($_SESSION['carrinho']);

    echo "Pedido finalizado com sucesso!";
} else {
    echo "Carrinho vazio!";
}
?>
