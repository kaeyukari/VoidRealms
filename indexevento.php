<?php
require_once 'bd/conexao.php';

// recebe o termo de pesquisa se existir
$termo = (isset($_GET['termo'])) ? $_GET['termo'] : '';
$_SESSION["termo"] = $termo;

// Verifica se o termo de pesquisa está vazio
if (empty($termo)):
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM eventos ORDER BY eve_nome';
    $stm = $conexao->prepare($sql);
    $stm->execute();
    $eventos = $stm->fetchAll(PDO::FETCH_OBJ);
else:
    // Executa uma consulta baseada no termo de pesquisa
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM eventos WHERE eve_nome LIKE :eve_nome';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':eve_nome', $termo . '%');
    $stm->execute();
    $eventos = $stm->fetchAll(PDO::FETCH_OBJ);
endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>Eventos</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <fieldset>
            <legend>
                <h1 style="margin-top: 20px">Listagem de Eventos</h1>
            </legend>

            <form action="" method="get" id="form-contato">
                <label for="termo" class="col-md-4 control-label" style="margin: 10px"> <b> Pesquisar: </b> </label>
                <div class="limpar" style="width: 100%;">
                    <input type="text" class="form-control" id="termo" name="termo" placeholder="Informe o evento" style="border-color: #000000; width: 80%;">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                </div>
            </form>

            <div style="width: 100%; display: flex; flex-direction: row; justify-content: space-between;">
                <a href="addevento.php" class="btn btn-success" style="margin-bottom: 15px">Cadastrar Evento</a>
                <a href="imprimirevento.php"><button class="btn btn-danger">Imprimir</button></a>
            </div>

            <?php if (!empty($eventos)): ?>
                <table class="table table-striped">
                    <tr class="active">
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Data de Início</th>
                        <th>Data de Fim</th>
                        <th>Descritivo</th>
                        <th>Período</th>
                        <th>Área</th>
                        <th>Local</th>
                        <th>Ações</th>
                    </tr>

                    <?php foreach ($eventos as $evento): ?>
                        <tr>
                            <td><?= $evento->eve_codigo ?></td>
                            <td><a href="eventodetalhe.php?id=<?= $evento->eve_codigo ?>"><?= $evento->eve_nome ?></a></td>
                            <td><?= $evento->eve_datainicio ?></td>
                            <td><?= $evento->eve_datafim ?></td>
                            <td><?= $evento->eve_descritivo ?></td>
                            <td><?= $evento->eve_periodo ?></td>
                            <td><?= $evento->eve_area ?></td>
                            <td><?= $evento->eve_local ?></td>
                            <td>
                                <a href="editarevento.php?id=<?= $evento->eve_codigo ?>" class="btn btn-primary">Editar</a>
                                <form action="actionevento.php" method="post" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este evento?');">
                                    <input type="hidden" name="acao" value="excluir">
                                    <input type="hidden" name="id" value="<?= $evento->eve_codigo ?>">
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <h3 class="text-center text-primary">Não existem eventos cadastrados!</h3>
            <?php endif; ?>
        </fieldset>
    </div>
    
    <script type="text/javascript" src="js/customeve.js"></script>
</body>
</html>
