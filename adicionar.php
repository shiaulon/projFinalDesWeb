<?php
include('db.php');  // Inclui o arquivo com a conexão ao banco

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $categoria = $_POST['categoria'];  // Nome da categoria
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    // Formatação do preço (remove R$, substitui vírgula por ponto)
    $preco = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco']);

    // Processamento da imagem (caso tenha sido enviada)
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        // Lê o conteúdo da imagem e armazena em uma variável
        $foto = file_get_contents($_FILES['foto']['tmp_name']);
    }

    // Inserir categoria no banco (se não existir)
    try {
        // Verifica se a categoria já existe no banco
        $stmt = $pdo->prepare("SELECT id FROM tb_categoria WHERE nome = :categoria");
        $stmt->bindParam(':categoria', $categoria);
        $stmt->execute();
        $categoriaExistente = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se a categoria não existir, cria uma nova categoria
        if (!$categoriaExistente) {
            // Inserir nova categoria
            $stmt = $pdo->prepare("INSERT INTO tb_categoria (nome) VALUES (:categoria)");
            $stmt->bindParam(':categoria', $categoria);
            $stmt->execute();
            // Agora, recupera o id da nova categoria
            $idCategoria = $pdo->lastInsertId();
        } else {
            // Se a categoria já existir, usa o id da categoria existente
            $idCategoria = $categoriaExistente['id'];
        }

        // Agora, insere o item na tabela de itens
        $stmt = $pdo->prepare("INSERT INTO tb_itens (idCategoria, nome, descricao, foto, preco) 
                               VALUES (:idCategoria, :nome, :descricao, :foto, :preco)");

        // Liga os parâmetros da consulta com as variáveis
        $stmt->bindParam(':idCategoria', $idCategoria);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':preco', $preco);

        // Executa a consulta
        if ($stmt->execute()) {
            echo "Item adicionado com sucesso!";
        } else {
            echo "Erro ao adicionar item.";
        }
    } catch (PDOException $e) {
        echo "Erro na conexão ou no banco de dados: " . $e->getMessage();
    }
}
?>
