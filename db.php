<?php

$host = 'localhost';     // Endereço do servidor (geralmente localhost)
$dbname = 'banco';  // Nome do banco de dados
$username = 'root';   // Nome de usuário do banco de dados
$password = '';     // Senha do banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configuração para tratar erros de forma adequada
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Exibe erro se a conexão falhar
    echo "Erro na conexão: " . $e->getMessage();
}
?>