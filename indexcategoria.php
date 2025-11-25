<?php
session_start(); // Adicionar para iniciar a sessão
require 'bd/conexao.php';

// recebe o termo de pesquisa se existir
$termo = (isset($_GET['termo'])) ? $_GET['termo'] : '';
$_SESSION["termo"] = $termo;

// Verifica se o termo de pesquisa esta vazio, se estivar executar uma consulta completa
$conexao = conexao::getInstance();

if (empty($termo)):
    $sql = 'SELECT cat_codigo, cat_nome FROM categorias ORDER BY cat_nome';
else:
    // Executa uma consulta baseada no termo de pesquisa passado como parâmetro
    $sql = 'SELECT cat_codigo, cat_nome FROM categorias WHERE cat_nome LIKE :cat_nome';
endif;

$stm = $conexao->prepare($sql);

if (!empty($termo)) {
    $stm->bindValue(':cat_nome', $termo . '%');
}

$stm->execute();
$categorias = $stm->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>Categorias</title>
    <!-- Link do css do bootstrap na maquina -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css.map">
    <!-- link css do bootstrap da barra de pesquisa -->
    <link rel="stylesheet" href="css/navbar-fixed.css">
    <!-- link css customizado -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        #nomeUsu {
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container">
        <fieldset>
            <!-- CabeÃ§alho da Listagem -->
            <legend>
                <h1 style="margin-top: 20px">Listagem de Categorias</h1>
            </legend>
            <!-- Formulario de Pesquisa -->
            <form action="" method="get" id="form-contato" class="">
                <label for="termo" class="col-md-4 control-label" style="margin: 10px"> <b> Pesquisar: </b> </label>
                <div class="limpar" style="width: 100%; ">
                    <input type="text" class="form-control" id="termo" name="termo" placeholder=" Informe a categoria "
                        style="border-color: #000000; width: 80%;">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                </div>

            </form>
            <div style="width: 100%; display: flex; flex-direction: row; justify-content: space-between;">
                <!-- Link para pagina de cadastro -->
                <a href="addcategoria.php" class="btn btn-success" style="margin-bottom: 15px">Cadastrar Categorias</a>
                <!-- link para imprimir -->
                <a href="imprimircategoria.php"><button class="btn btn-danger">Imprimir</button></a>
            </div>
            <div class="clearfix"></div>
            <?php if (!empty($categorias)): ?>

                <!-- Tabela de Categorias -->

                <table class="table table-striped">
                    <tr class="active">
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Ação</th>
                    </tr>

                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td><?= $categoria->cat_codigo ?></td>
                            <td><?= $categoria->cat_nome ?></td>
                            <td>
                                <a href="editarcategoria.php?id=<?= $categoria->cat_codigo ?>" class="btn btn-primary">Editar</a>
                                <a href="javascript:void(0)" class="btn btn-danger link_exclusao"
                                    rel="<?= $categoria->cat_codigo ?>">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </table>
            <?php else: ?>
                <!-- Mensagem caso nao exista clientes ou nao encontrado -->
                <h3 class="text-center text-primary">Não existem categorias cadastrados!</h3>
            <?php endif; ?>
        </fieldset>

    </div>
    <script type="text/javascript" src="js/customcat.js"></script>
</body>

</html>