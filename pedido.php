<?php
session_start();
include('db.php');


if (empty($_SESSION['carrinho'])) {
    echo "O seu carrinho está vazio!";
    exit();
}

foreach ($_SESSION['carrinho'] as $item) {
    $query = "INSERT INTO tb_itens_pedido(idUsuario, idItem, quantidade, preco, status) 
              VALUES (:idUsuario, :idItem, :quantidade, :preco, 'pendente')";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':idUsuario', $_SESSION['user_id']);
    $stmt->bindParam(':idItem', $item['idItem']);
    $stmt->bindParam(':quantidade', $item['quantidade']);
    $stmt->bindParam(':preco', $item['preco']);
    $stmt->execute();
}


unset($_SESSION['carrinho']);
header('Location: sucesso.php');
exit();
?>
