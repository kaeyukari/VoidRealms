<?php 
session_start();
if (!isset($_SESSION["logado099"])) {
    $_SESSION["logado099"] = false;
    $_SESSION["id"] = 0; 
    $_SESSION["nome"] = 'Visitante'; 
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Eventos - Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css"> 
    
    <style>
        body {
            background: #fff;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background: linear-gradient(90deg, #1a0033, #000010, #001f3f);
            color: white;
            height: 120px;
            padding: 15px 0;
            box-shadow: 0 0 15px rgba(138, 43, 226, 0.5);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%;
            color: #fff;
        }

        header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            align-items: center;
            justify-content: center;
            letter-spacing: 1px;
        }

        .user-login img {
            vertical-align: middle;
            border-radius: 50%;
            margin-right: 8px;
        }

        .user-login a {
            color: #b084f0;
            font-weight: 500;
            text-decoration: none;
            transition: 0.3s;
        }

        .user-login a:hover {
            color: #8a2be2;
        }

        nav.nav-center {
            text-align: center;
            background-color: rgba(0, 0, 40, 0.7);
            padding: 10px 0;
            border-top: 1px solid rgba(138, 43, 226, 0.3);
            border-bottom: 1px solid rgba(138, 43, 226, 0.3);
        }

        nav a {
            color: #b084f0;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #8a2be2;
        }

        .content {
            padding: 40px 0;
        }

        .eventos-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .evento {
            background-color: rgba(20, 20, 40, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(138, 43, 226, 0.3);
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .evento:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 25px rgba(138, 43, 226, 0.6);
        }

        .evento img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .evento h2 {
            font-size: 1.3rem;
            color: #b084f0;
            margin-bottom: 8px;
        }

        .evento p {
            color: #dcdcdc;
            font-size: 0.95rem;
        }

        footer {
            background-color: #0a0a0f;
            color: #aaa;
            text-align: center;
            padding: 15px 0;
            font-size: 0.9rem;
            border-top: 1px solid rgba(138, 43, 226, 0.2);
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <h1>Eventos- NightFall</h1>
            <div class="user-login">
                <img src="uploads/icon.png" alt="Usuário" style="width: 24px; height: 24px;">
                <?php if ($_SESSION["logado099"]): ?>
                    <span class="text-white mx-2">Olá, <?= htmlspecialchars($_SESSION["nome"]) ?></span>
                    <a href="logout.php" class="mx-2">Sair</a>
                <?php else: ?>
                    <a href="login.php" class="mx-2">Fazer login</a>
                <?php endif; ?>
            </div>
        </div>
        
    </header>

    <div class="container content">
        <h2 class="text-center">Eventos</h2>
        <div class="eventos-container">
            <?php
            require 'bd/conexao.php';
            $conexao = conexao::getInstance();
            $sql = 'SELECT * FROM eventos';
            $stm = $conexao->prepare($sql);
            $stm->execute();
            $eventos = $stm->fetchAll(PDO::FETCH_OBJ);

            foreach ($eventos as $evento):
            ?>
            <div class="evento">
                <a href="eventodetalhe.php?id=<?= $evento->eve_codigo ?>" style="text-decoration: none; color: inherit;">
                    <img src="uploads/<?= $evento->eve_imagem ?>" alt="Imagem do Evento">
                    <h2><?= htmlspecialchars($evento->eve_nome) ?></h2>
                    <p><?= htmlspecialchars($evento->eve_descritivo) ?></p>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date("Y") ?> Equipe NightFall </p>
    </footer>
</body>
</html>
