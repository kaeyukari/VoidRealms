<?php
require 'bd/conexao.php';

$conexao = conexao::getInstance();
$sql = 'SELECT cat_codigo, cat_nome FROM categorias ORDER BY cat_nome';
$stm = $conexao->prepare($sql);
$stm->execute();
$categorias = $stm->fetchAll(PDO::FETCH_OBJ);

// Recebe o id do usuario via GET
$id_usu = (isset($_GET['id'])) ? $_GET['id'] : '';

// Valida se existe um id e se ele é numérico
if (!empty($id_usu) && is_numeric($id_usu)):

    // Captura os dados do cliente solicitado
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM usuario WHERE usu_codigo = :id';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':id', $id_usu);
    $stm->execute();
    $usuario = $stm->fetch(PDO::FETCH_OBJ);
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
                <h1>Formulário - Edição de usuários</h1>
            </legend>
            <?php if (empty($usuario)): ?>
                <h3 class="text-center text-danger">usuário não encontrado!</h3>
            <?php else: ?>
                <form action="actionusuario.php" method="post" id="form-contato" enctype='multipart/form-data'>
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= $usuario->usu_nome ?>"
                            placeholder="Informe o Nome">
                        <span class="msg-erro msg-nome"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Informe o Email"
                            value="<?= $usuario->usu_email ?>" maxlength="30">
                        <span class="msg-erro msg-email"></span>
                    </div>

                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" value="<?= $usuario->usu_senha ?>"
                            placeholder="Informe a Senha" maxlength="30">
                        <span class="msg-erro msg-senha"></span>
                    </div>

                    <div class="form-group">
                        <label for="cep">Cep</label>
                        <input type="text" class="form-control" id="cep" name="cep" placeholder="Informe o Cep"
                            value="<?= $usuario->usu_cep ?>" maxlength="30">
                        <span class="msg-erro msg-cep"></span>
                    </div>

                    <div class="form-group">
                        <label for="logradouro">Logradouro</label>
                        <input type="text" class="form-control" id="logradouro" name="logradouro"
                            value="<?= $usuario->usu_logradouro ?>" placeholder="Informe o Logradouro" maxlength="30">
                        <span class="msg-erro msg-logradouro"></span>
                    </div>

                    <div class="form-group">
                        <label for="numero">Numero</label>
                        <input type="text" class="form-control" id="numero" name="numero" placeholder="Informe o Numero"
                            value="<?= $usuario->usu_numero ?>" maxlength="30">
                        <span class="msg-erro msg-numero"></span>
                    </div>

                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" class="form-control" id="complemento" name="complemento"
                            value="<?= $usuario->usu_complemento ?>" placeholder="Informe o Complemento" maxlength="30">
                        <span class="msg-erro msg-complemento"></span>
                    </div>

                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Informe o Bairro"
                            value="<?= $usuario->usu_bairro ?>" maxlength="30">
                        <span class="msg-erro msg-bairro"></span>
                    </div>

                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Informe a Cidade"
                            value="<?= $usuario->usu_cidade ?>" maxlength="30">
                        <span class="msg-erro msg-cidade"></span>
                    </div>

                    <div class="form-group">
                        <label for="uf">Uf</label>
                        <input type="text" class="form-control" id="uf" name="uf" placeholder="Informe a Uf"
                            value="<?= $usuario->usu_uf ?>" maxlength="30">
                        <span class="msg-erro msg-uf"></span>
                    </div>

                    <div class="form-group">
                        <label for="categoria">Categoria</label>
                        <select class="form-control" name="categoria" id="categoria">
                            <option value="">Selecione a Categoria</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria->cat_codigo ?>"><?= $categoria->cat_nome ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group   bordasup">
                        <input type="hidden" name="acao" value="editar">
                        <input type="hidden" name="id" value="<?= $usuario->usu_codigo ?>">
                        <button type="submit" class="btn btn-primary" id="botao">
                            Gravar
                        </button>
                        <a href="indexusuario.php" class="btn btn-danger pull-right">Voltar</a>
                    </div>
                </form>
            <?php endif; ?>
        </fieldset>

    </div>
    <script type="text/javascript" src="js/customusu.js"></script>
</body>

</html>