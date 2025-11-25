<?php
session_start();
require_once 'bd/conexao.php';

//  ID do passe via GET
$id_passe = isset($_GET['id']) ? $_GET['id'] : '';

//  ID é numérico
if (!empty($id_passe) && is_numeric($id_passe)):
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM passes WHERE id = :id';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':id', $id_passe);
    $stm->execute();
    $passe = $stm->fetch(PDO::FETCH_OBJ);
endif;

// se o passe foi encontrado
if (empty($passe)):
    echo "<h3 class='text-center text-danger'>Passe não encontrado!</h3>";
else:
    // usuário está logado
    $logado = isset($_SESSION["logado099"]) && $_SESSION["logado099"];
    ?>

    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Detalhes do Passe</title>
        <style>
            body {
                background: #111133;
                font-family: "Poppins", sans-serif;
                color: #e0e0ff;
            }

            h1 {
                text-align: center;
                font-weight: 600;
                margin-bottom: 30px;
                color: #111133;
            }

            .container {
                max-width: 700px;
                background-color: #fff;
                border-radius: 15px;
                padding: 40px;
                margin-top: 150px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
                backdrop-filter: blur(10px);
            }

            img {
                display: block;
                margin: 0 auto 20px auto;
                border-radius: 10px;
                width: 300px;
                object-fit: cover;
                border: 2px solid #3d2b88;
            }

            p,
            p strong {
                color: #1a0033;
            }

            .btn {
                border-radius: 10px;
                padding: 10px 25px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            /* comprar passe */
            .btn-success {
                background: linear-gradient(135deg, #6a0dad, #9b59b6);
                border: none;
                color: #fff;
            }

            .btn-success:hover {
                background: linear-gradient(135deg, #8e44ad, #b47ede);
                transform: scale(1.05);
            }

            /* Botão "Voltar para Loja" - azul do tema */
            .btn-primary {
                background: linear-gradient(135deg, #2b2bff, #5a4eff);
                border: none;
                color: #fff;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, #3a3aff, #7a6fff);
                transform: scale(1.05);
            }

            /* Modal */
            .modal-content {
                border-radius: 12px;
                background-color: #1b1833;
                color: #fff;
                border: 1px solid #3a3370;
            }

            .modal-body {
                background-color: #fff;
            }

            .modal-header,
            .modal-footer {
                border-color: #3a3370;
            }

            .btn-secondary {
                background-color: #3a3370;
                border: none;
            }

            .btn-secondary:hover {
                background-color: #504799;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <h1><?= htmlspecialchars($passe->nome) ?></h1>
            <img src="<?= htmlspecialchars($passe->imagem) ?>" alt="<?= htmlspecialchars($passe->nome) ?>"
                class="img-fluid mb-3" style="max-height: 400px;">
            <p><strong>Descrição:</strong> <?= htmlspecialchars($passe->descricao) ?></p>
            <p><strong>Preço:</strong> <?= htmlspecialchars($passe->preco) ?> créditos</p>

            <!-- Botões de interação -->
            <div class="mt-4 text-center">
                <?php if ($logado): ?>
                    <a href="comprar_passe.php?id=<?= $passe->id ?>" class="btn btn-success">Comprar Passe</a>
                <?php else: ?>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">Comprar Passe</button>
                <?php endif; ?>
            </div>

            <div class="mt-4 text-center">
                <a href="loja.php" class="btn btn-primary">Voltar para a Loja</a>
            </div>
        </div>

        <!-- avisar sobre login -->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Aviso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Você precisa estar logado para comprar este passe.</p>
                    </div>
                    <div class="modal-footer">
                        <a href="login.php" class="btn btn-primary">Fazer Login</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts do Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>

<?php endif; ?>