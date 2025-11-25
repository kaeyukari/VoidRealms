<?php
require 'bd/conexao.php';

// Recebe o termo de pesquisa, se existir
$termo = (isset($_GET['termo'])) ? $_GET['termo'] : '';

// Conexão com o banco de dados
$conexao = conexao::getInstance();

if (empty($termo)) {
    // Consulta completa se o termo estiver vazio
    $sql = 'SELECT * FROM eventos ORDER BY eve_nome';
} else {
    // Consulta com base no termo
    $sql = 'SELECT * FROM eventos WHERE eve_nome LIKE :eve_nome';
}

$stm = $conexao->prepare($sql);

if (!empty($termo)) {
    $stm->bindValue(':eve_nome', $termo . '%');
}

$stm->execute();
$eventos = $stm->fetchAll(PDO::FETCH_OBJ);

// Retorna os eventos em formato JSON
header('Content-Type: application/json');
echo json_encode($eventos);
