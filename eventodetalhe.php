<?php
session_start();
require_once 'bd/conexao.php';

// Recebe o ID do evento via GET
$id_eve = (isset($_GET['id'])) ? $_GET['id'] : '';

// Verifica se o ID é numérico
if (!empty($id_eve) && is_numeric($id_eve)):
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM eventos WHERE eve_codigo = :id';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':id', $id_eve);
    $stm->execute();
    $evento = $stm->fetch(PDO::FETCH_OBJ);
endif;

// Verifica se o evento foi encontrado
if (empty($evento)):
    echo "<h3 class='text-center text-danger mt-5'>Evento não encontrado!</h3>";
else:
    // Verificar se o usuário está logado
    $logado = isset($_SESSION["logado099"]) && $_SESSION["logado099"];

    // Verificar se o usuário está inscrito no evento
    if ($logado):
        $usuario_id = $_SESSION["id"];
        $sql_inscricao = 'SELECT * FROM usuario_eventos WHERE usu_codigo = :usuario_id AND eve_codigo = :evento_id';
        $stm_inscricao = $conexao->prepare($sql_inscricao);
        $stm_inscricao->bindValue(':usuario_id', $usuario_id);
        $stm_inscricao->bindValue(':evento_id', $id_eve);
        $stm_inscricao->execute();
        $inscrito = $stm_inscricao->fetch(PDO::FETCH_OBJ);
    else:
        $inscrito = false;
    endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0a0a0f,#111133 , #1a0033);
            color: white;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h3 {
            color:#111133 ;
            text-align: center;
            font-weight: 600;
        }

        .container {
            background-color: #fff;
            border-radius: 20px;
            padding: 40px;
            margin-top: 50px;
            box-shadow: 0 0 30px rgba(150, 100, 255, 0.3);
            width: 1000px;
            height: 1000px;
        }

        img {
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(120, 80, 255, 0.4);
            display: block;
            margin: 40px auto 40px auto;
            width: 600px;
        }
        .descricoes {
            margin-top: 60px;
            margin-bottom: 20px;
            margin-left: 40px;
        }
        p {
            font-size: 1.1rem;
            color: #111133;
        }

        strong {
            color: #a366ff;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-success {
            background-color: #4b0082;
            border: none;
        }

        .btn-success:hover {
            background-color: #7a33cc;
        }

        .btn-dark {
            background-color: #111133;
            border: 1px solid #7a33cc;
        }

        .btn-dark:hover {
            background-color: #1f1f3a;
        }

        .btn-danger {
            background-color: #661a1a;
            border: none;
        }

        .btn-danger:hover {
            background-color: #992222;
        }

        .btn-primary {
            background-color: #001f66;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0040cc;
        }

        footer {
            text-align: center;
            padding: 15px;
            color: #999;
            margin-top: auto;
        }

        .modal-content {
            background-color: #1a0033;
            color: white;
            border: 1px solid #7a33cc;
        }

        .modal-header {
            border-bottom: 1px solid #7a33cc;
        }

        .btn-close {
            filter: invert(1);
        }
    </style>
</head>
<body>

    <div class="container">
        <h1><?= $evento->eve_nome ?></h1>
        <img src="uploads/<?= $evento->eve_imagem ?>" alt="<?= $evento->eve_nome ?>" class="img-fluid mb-3" style="max-height: 400px;">
        <div class="descricoes"> 
        <p><strong>Descrição:</strong> <?= $evento->eve_descritivo ?></p>
        <p><strong>Data de Início:</strong> <?= $evento->eve_datainicio ?></p>
        <p><strong>Data de Fim:</strong> <?= $evento->eve_datafim ?></p>
        <p><strong>Período:</strong> <?= $evento->eve_periodo ?></p>
        <p><strong>Área:</strong> <?= $evento->eve_area ?></p>
        <p><strong>Local:</strong> <?= $evento->eve_local ?></p>
    </div>

        <div class="mt-4 text-center">
            <?php if ($logado): ?>
                <?php if ($inscrito): ?>
                    <button class="btn btn-dark" disabled>Já Inscrito!</button>
                    <a href="cancelar_inscricao.php?id=<?= $evento->eve_codigo ?>" class="btn btn-danger mx-2">Cancelar Inscrição</a>
                <?php else: ?>
                    <a href="inscrever.php?id=<?= $evento->eve_codigo ?>" class="btn btn-success">Inscrever-se</a>
                <?php endif; ?>
            <?php else: ?>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">Inscrever-se</button>
            <?php endif; ?>
        </div>

        <div class="mt-4 text-center">
            <a href="indexeve.php" class="btn btn-primary">Voltar para a Lista de Eventos</a>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date("Y") ?> ETEC Professor Milton Gazzetti</p>
    </footer>

    <!-- Modal de login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Aviso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Você precisa estar logado para se inscrever neste evento.</p>
                </div>
                <div class="modal-footer">
                    <a href="login.php" class="btn btn-primary">Fazer Login</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php endif; ?>
