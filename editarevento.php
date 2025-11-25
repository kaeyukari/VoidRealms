<?php
    require_once 'bd/conexao.php';

    // Recebe o id do usuario via GET
    $id_eve = (isset($_GET['id'])) ? $_GET['id'] : '';

    // Valida se existe um id e se ele é numérico
    if (!empty($id_eve) && is_numeric($id_eve)):

        // Captura os dados do cliente solicitado
        $conexao = conexao::getInstance();
        $sql = 'SELECT * FROM eventos WHERE eve_codigo = :id';
        $stm = $conexao -> prepare($sql);
        $stm -> bindValue(':id', $id_eve);
        $stm -> execute();
        $evento = $stm->fetch(PDO::FETCH_OBJ);
    endif;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição de Usuário</title>
    <!--- link css bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <!-- css bootstrap máquina -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <div class="container">
        <fieldset>
            <legend>
                <h1>Formulário - Edição de eventos</h1>
            </legend>
            <?php if(empty($evento)):?>
            <h3 class="text-center text-danger">evento não encontrado!</h3>
            <?php else: ?>
            <form action="actionevento.php" method="post" id="form-contato" enctype='multipart/form-data'>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?=$evento->eve_nome?>"
                        placeholder="Informe o Nome">
                    <span class="msg-erro msg-nome"></span>
                </div>
                <div class="form-group">
                    <label for="datainicio">Data início</label>
                    <input type="date" class="form-control" id="datainicio" name="datainicio" value="<?=$evento->eve_datainicio?>"
                        placeholder="Informe a Data de Início" maxlength="30">
                    <span class="msg-erro msg-datainicio"></span>
                </div>

                <div class="form-group">
                    <label for="datafim">Data fim</label>
                    <input type="date" class="form-control" id="data-fim" name="datafim" value="<?=$evento->eve_datafim?>"
                        placeholder="Informe a Data de Fim" maxlength="30">
                    <span class="msg-erro msg-datafim"></span>
                </div>

                <div class="form-group">
                    <label for="descritivo">Descritivo</label>
                    <input type="text" class="form-control" id="descritivo" name="descritivo" value="<?=$evento->eve_descritivo?>"
                        placeholder="Informe o Descritivo" maxlength="30">
                    <span class="msg-erro msg-descritivo"></span>
                </div>

                <div class="form-group">
                    <label for="periodo">Período</label>
                    <input type="text" class="form-control" id="periodo" name="periodo" placeholder="Informe o Período" value="<?=$evento->eve_periodo?>"
                        maxlength="30">
                    <span class="msg-erro msg-periodo"></span>
                </div>

                <div class="form-group">
                    <label for="area">Área</label>
                    <input type="text" class="form-control" id="area" name="area" placeholder="Informe a Área" value="<?=$evento->eve_area?>"
                        maxlength="30">
                    <span class="msg-erro msg-area"></span>
                </div>

                <div class="form-group">
                    <label for="local">Local</label>
                    <input type="text" class="form-control" id="local" name="local" placeholder="Informe o Local" value="<?=$evento->eve_local?>"
                        maxlength="30">
                    <span class="msg-erro msg-local"></span>
                </div>

                <div class="form-group   bordasup">
                    <input type="hidden" name="acao" value="editar">
                    <input type="hidden" name="id" value="<?=$evento->eve_codigo?>">
                    <button type="submit" class="btn btn-primary" id="botao">
                        Gravar
                    </button>
                    <a href="indexevento.php" class="btn btn-danger pull-right">Voltar</a>
                </div>
            </form>
            <?php endif; ?>
        </fieldset>

    </div>
    <script type="text/javascript" src="js/customeve.js"></script>
</body>

</html>