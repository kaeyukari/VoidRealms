<?php
session_start();
require_once 'bd/conexao.php';
$conn = conexao::getInstance();

// Verifica login
if (!isset($_SESSION['id']) || $_SESSION['id'] == 0) {
    echo "<script>alert('Você precisa estar logado para comprar créditos!'); window.location.href='login.php';</script>";
    exit;
}

$usu_codigo = $_SESSION['id']; // ID do usuário logado
$valor = floatval($_POST['valor']);

if ($valor <= 0) {
    echo "<script>alert('Selecione um valor válido.'); window.history.back();</script>";
    exit;
}

try {
    // Verifica se o usuário já tem registro de créditos
    $stmt = $conn->prepare("SELECT * FROM creditos WHERE usu_codigo = :usu_codigo");
    $stmt->bindParam(':usu_codigo', $usu_codigo);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Atualiza saldo existente
        $sql = "UPDATE creditos SET saldo = saldo + :valor WHERE usu_codigo = :usu_codigo";
    } else {
        // Cria novo registro
        $sql = "INSERT INTO creditos (usu_codigo, saldo) VALUES (:usu_codigo, :valor)";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usu_codigo', $usu_codigo);
    $stmt->bindParam(':valor', $valor);
    $stmt->execute();

    echo "<script>alert('Compra concluída! Créditos adicionados com sucesso.'); window.location.href='loja.php';</script>";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
