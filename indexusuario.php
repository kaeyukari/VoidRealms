<?php
session_start(); // Adicionar para iniciar a sessão
require 'bd/conexao.php';

// recebe o termo de pesquisa se existir
$termo = (isset($_GET['termo'])) ? $_GET['termo'] : '';
$_SESSION["termo"] = $termo;

$conexao = conexao::getInstance();

if (empty($termo)):
    $sql = 'SELECT * FROM usuario ORDER BY usu_nome';
else:
    $sql = 'SELECT * FROM usuario WHERE usu_nome LIKE :usu_nome';
endif;

$stm = $conexao->prepare($sql);

if (!empty($termo)) {
    $stm->bindValue(':usu_nome', $termo . '%');
}

$stm->execute();
$usuario = $stm->fetchAll(PDO::FETCH_OBJ);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>usuarios</title>
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
                <h1 style="margin-top: 20px">Listagem de Usuários</h1>
            </legend>
            <!-- Formulario de Pesquisa -->
            <form action="" method="get" id="form-contato" class="">
                <label for="termo" class="col-md-4 control-label" style="margin: 10px"> <b> Pesquisar: </b> </label>
                <div class="limpar" style="width: 100%; ">
                    <input type="text" class="form-control" id="termo" name="termo" placeholder=" Informe o usuario "
                        style="border-color: #000000; width: 80%;">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                </div>
            </form>
            <div style="width: 100%; display: flex; flex-direction: row; justify-content: space-between;">
                <!-- Link para pagina de cadastro -->
                <a href="addusuario.php" class="btn btn-success" style="margin-bottom: 15px">Cadastrar Usuário</a>
                <!-- link para imprimir -->
                <a href="imprimirusuario.php"><button class="btn btn-danger">Imprimir</button></a>
            </div>
            <div class="clearfix"></div>
            <?php if (!empty($usuario)): ?>

                <!-- Tabela de usuarios -->

                <table class="table table-striped">
                    <tr class="active">
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>

                    <?php foreach ($usuario as $usua): ?>
                        <tr>
                            <td><?= $usua->usu_codigo ?></td>
                            <td><?= $usua->usu_nome ?></td>
                            <td><?= $usua->usu_email ?></td>
                            

                            <td>
                                <a href="editarusuario.php?id=<?= $usua->usu_codigo ?>" class="btn btn-primary">Editar</a>
                                <form action="actionusuario.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="acao" value="excluir">
                                <input type="hidden" name="id" value="<?= $usua->usu_codigo ?>">
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</button>
                            </form>
                            </td>
                            

                        </tr>
                    <?php endforeach; ?>

                </table>
            <?php else: ?>
                <!-- Mensagem caso nao exista clientes ou nao encontrado -->
                <h3 class="text-center text-primary">Não existem usuários cadastrados!</h3>
            <?php endif; ?>
        </fieldset>
                <div class="mt-3">
                    <a href="index.php" class="btn btn-secondary w-100">Voltar para a Página Principal</a>
                </div>

    </div>
    
    <script type="text/javascript" src="js/customusu.js"></script>
</body>

</html>