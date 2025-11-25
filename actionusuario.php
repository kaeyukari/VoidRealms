<?php
session_start();
require_once 'bd/conexao.php';

try {
    // Conexão com o banco
    $conexao = conexao::getInstance();

    // Recebendo os dados via POST
    $acao  = $_POST['acao'] ?? '';
    $id    = $_POST['id'] ?? '';
    $nome  = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    // Validação básica (exceto na exclusão)
    if ($acao !== 'excluir') {
        $mensagem = '';

        if (empty($nome) || strlen($nome) < 3) {
            $mensagem .= '<li>Favor preencher o nome corretamente (mínimo 3 caracteres).</li>';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mensagem .= '<li>Favor preencher um e-mail válido.</li>';
        }

        if ($acao === 'incluir' && (empty($senha) || strlen($senha) < 6)) {
            $mensagem .= '<li>Senha deve ter pelo menos 6 caracteres.</li>';
        }

        if (!empty($mensagem)) {
            echo "<div class='alert alert-danger' role='alert'><ul>$mensagem</ul></div>";
            exit;
        }
    }

    // === INCLUIR USUÁRIO ===
    if ($acao === 'incluir') {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha

        $sql = 'INSERT INTO usuario (usu_nome, usu_email, usu_senha) 
                VALUES (:nome, :email, :senha)';
        
        $stm = $conexao->prepare($sql);
        $stm->bindValue(':nome', $nome);
        $stm->bindValue(':email', $email);
        $stm->bindValue(':senha', $senhaHash);

        $retorno = $stm->execute();

        if ($retorno) {
            header('Location: indexusuario.php');
            exit;
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div>";
        }
    }

    // === EDITAR USUÁRIO ===
    if ($acao === 'editar') {
        if (!empty($senha)) {
            // Atualiza nome, e-mail e senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = 'UPDATE usuario 
                    SET usu_nome = :nome, usu_email = :email, usu_senha = :senha 
                    WHERE usu_codigo = :usu_codigo';
            $stm = $conexao->prepare($sql);
            $stm->bindValue(':senha', $senhaHash);
        } else {
            // Atualiza apenas nome e e-mail
            $sql = 'UPDATE usuario 
                    SET usu_nome = :nome, usu_email = :email 
                    WHERE usu_codigo = :usu_codigo';
            $stm = $conexao->prepare($sql);
        }

        $stm->bindValue(':nome', $nome);
        $stm->bindValue(':email', $email);
        $stm->bindValue(':usu_codigo', $id);

        $retorno = $stm->execute();

        if ($retorno) {
            header('Location: indexusuario.php');
            exit;
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro ao editar registro!</div>";
        }
    }

    // === EXCLUIR USUÁRIO ===
    if ($acao === 'excluir') {
        $sql = 'DELETE FROM usuario WHERE usu_codigo = :id';
        $stm = $conexao->prepare($sql);
        $stm->bindValue(':id', $id);
        $retorno = $stm->execute();

        if ($retorno) {
            header('Location: indexusuario.php');
            exit;
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro ao excluir registro!</div>";
        }
    }

} catch (PDOException $e) {
    // Evita expor dados sensíveis do banco em produção
    echo "<div class='alert alert-danger' role='alert'>Erro no sistema: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>
