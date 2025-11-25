<?php
require_once 'bd/conexao.php';
$conn = conexao::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $imagemPath = '';

    // Verifica se tem imagem
    if (!empty($_FILES['imagem']['name'])) {
        $nomeImagem = uniqid() . "-" . basename($_FILES['imagem']['name']);
        $caminho = "uploads/" . $nomeImagem;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $imagemPath = $caminho;
        } else {
            echo "❌ Erro ao fazer upload da imagem.";
            exit;
        }
    }

    // Inserir no banco de dados
    $sql = "INSERT INTO passes (nome, descricao, preco, imagem) VALUES (:nome, :descricao, :preco, :imagem)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':imagem', $imagemPath);

    if ($stmt->execute()) {
        echo "✅ Passe cadastrado com sucesso!";
        header("Location: loja.php");
        exit;
    } else {
        echo "❌ Erro ao cadastrar passe.";
    }
}
?>
