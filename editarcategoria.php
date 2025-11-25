<?php
    require 'bd/conexao.php';

    // Recebe o id do usuario via GET
    $id_cat = (isset($_GET['id'])) ? $_GET['id'] : '';

    // Valida se existe um id e se ele é numérico
    if (!empty($id_cat) && is_numeric($id_cat)):

        // Captura os dados do cliente solicitado
        $conexao = conexao::getInstance();
        $sql = 'SELECT cat_codigo, cat_nome FROM categorias WHERE cat_codigo = :id';
        $stm = $conexao -> prepare($sql);
        $stm -> bindValue(':id', $id_cat);
        $stm -> execute();
        $categoria = $stm->fetch(PDO::FETCH_OBJ);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <!-- css bootstrap máquina -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <fieldset>
            <legend><h1>Formulário - Edição de Categorias</h1></legend>
            <?php if(empty($categoria)):?>
                <h3 class="text-center text-danger">Categoria não encontrado!</h3>
            <?php else: ?>
                <form action="actioncategoria.php" method="post" id="form-contato" enctype='multipart/form-data'>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?=$categoria->cat_nome?>" placeholder="Informe o Nome">
                    <span class="msg-erro msg-nome" ></span>
                </div>
                <div class="form-group   bordasup">                    
                    <input type="hidden" name="acao" value="editar">
                    <input type="hidden" name="id" value="<?=$categoria->cat_codigo?>">
                    <button type="submit" class="btn btn-primary" id="botao">
                        Gravar
                    </button>
                    <a href="indexcategoria.php" class="btn btn-danger pull-right">Voltar</a>
                </div>
            </form>
                <?php endif; ?>
        </fieldset>

    </div>
    <script type="text/javascript" src="js/customcat.js"></script>
</body>
</html>