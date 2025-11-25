
<?php
session_start();
require_once 'bd/conexao.php';

if (isset($_GET['id']) && isset($_SESSION['logado099']) && $_SESSION['logado099']) {
    $usuario_id = $_SESSION['id'];
    $evento_id = $_GET['id'];

    $conexao = conexao::getInstance();
    $sql = 'INSERT INTO usuario_eventos (usu_codigo, eve_codigo) VALUES (:usuario_id, :evento_id)';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':usuario_id', $usuario_id);
    $stm->bindValue(':evento_id', $evento_id);
    $stm->execute();

    // Redirecionar para a página do evento
    header("Location: eventodetalhe.php?id=$evento_id");
    exit();
} else {
    echo "Você precisa estar logado para se inscrever.";
}
?>

