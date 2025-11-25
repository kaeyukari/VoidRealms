<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* ======= Fundo escuro com gradiente ======= */
        body {
            background: url('images/bgblur.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
        }

        /* ======= Card central ======= */
        .card {
            background: rgba(20, 20, 30, 0.85);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(98, 0, 255, 0.4);
            padding: 40px 30px;
            width: 100%;
            max-width: 500px;
        }

        h1 {
            text-align: center;
            font-family: 'Times New Roman';
            font-weight: 600;
            color: #fff;
            margin-bottom: 25px;
            text-shadow: 0 0 10px rgba(165, 102, 255, 0.4);
        }

        /* ======= Inputs ======= */
        label {
            font-weight: 500;
            color: #fff;
        }

        .form-control {
            background-color: rgba(40, 40, 60, 0.9);
            border: 1px solid #2b1a4a;
            color: #fff; /* texto digitado fica branco */
            border-radius: 10px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: #ccc; /* cor do texto do placeholder */
            opacity: 0.8;
        }

        .form-control:focus {
            background-color: rgba(50, 50, 80, 1);
            border-color: #7b2ff7;
            box-shadow: 0 0 10px rgba(123, 47, 247, 0.5);
            color: #fff; /* mantém o texto branco mesmo no foco */
        }

        /* ======= Botão principal ======= */
        #botao {
            background: linear-gradient(90deg, #5e17eb, #2e0b91);
            border: none;
            border-radius: 10px;
            transition: 0.3s;
            width: 100%;
            font-weight: 500;
            color: #ffffff;
            box-shadow: 0 0 12px rgba(123, 47, 247, 0.4);
        }

        #botao:hover {
            background: linear-gradient(90deg, #7b2ff7, #4b0aff);
            box-shadow: 0 0 18px rgba(155, 85, 255, 0.6);
        }

        /* ======= Botão Voltar ======= */
        .btn-danger {
            background: linear-gradient(90deg, #16213e, #0f3460);
            border: none;
            border-radius: 10px;
            width: 100%;
            margin-top: 10px;
            color: #c0c0c0;
            transition: 0.3s;
        }

        .btn-danger:hover {
            background: linear-gradient(90deg, #1a1a2e, #16213e);
            color: #fff;
            box-shadow: 0 0 15px rgba(33, 33, 77, 0.6);
        }

        /* ======= Efeito de foco no formulário ======= */
        .card:hover {
            box-shadow: 0 0 35px rgba(130, 60, 255, 0.6);
            transition: 0.4s;
        }
    </style>
</head>

<body>
    <div class="card">
        <form action="actionusuario.php" method="post" id="form-contato" enctype='multipart/form-data'>
            <h1>Cadastro de Usuário</h1>

            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Informe o nome" maxlength="30" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Informe o email" maxlength="30" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Informe a senha" maxlength="30" required>
            </div>

            <input type="hidden" name="acao" value="incluir">
            <button type="submit" class="btn btn-primary" id="botao">Finalizar cadastro</button>
            <a href="index.php" class="btn btn-danger">Voltar</a>
        </form>
    </div>

    <script type="text/javascript" src="js/customusu.js"></script>
</body>

</html>
