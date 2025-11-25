<?php
session_start();
require 'bd/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $conexao = conexao::getInstance();
    $sql = "SELECT * FROM usuario WHERE usu_email = :email";
    $stm = $conexao->prepare($sql);
    $stm->bindParam(':email', $email);
    $stm->execute();
    $usuario = $stm->fetch(PDO::FETCH_OBJ);

    if ($usuario && $senha === $usuario->usu_senha) {
        $_SESSION["logado099"] = true;
        $_SESSION["id"] = $usuario->usu_codigo;
        $_SESSION["nome"] = $usuario->usu_nome;
        header("Location: index.php");
        exit;
    } else {
        $erro = "Email ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
           background: url('images/bgblur.png') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #3b0066;
            border: none;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #52008f;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .alert {
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #3b0066;
            font-weight: 500;
        }

        a:hover {
            color: #52008f;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>

        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <div class="mt-3 text-center">
            <p>Não tem uma conta? <a href="addusuario.php">Cadastre-se aqui</a></p>
            <a href="index.php" class="btn btn-secondary w-100 mt-2">Voltar para a Página Principal</a>
        </div>
    </div>
</body>

</html>
