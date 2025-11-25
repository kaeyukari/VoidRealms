<!DOCTYPE html>
 <html lang="pt-br">
 <head>
     <meta charset="utf-8">
     <title>Sistema de Cadastro</title>
    <!--- link css bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <!-- css bootstrap máquina -->
    <link rel="stylesheet" href="css/bootstrap.min.css">    
    <link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
 <body>
    <?php
        require 'bd/conexao.php';
        // Atribui uma conexão PDO
        $conexao = conexao::getInstance();
        // Recebe os dados enviados pela submissão
        $acao = (isset ($_POST['acao'])) ? $_POST['acao'] : '';
        $id = (isset ($_POST['id'])) ? $_POST['id'] : '';
        $nome = (isset ($_POST['nome'])) ? $_POST['nome'] : '';
        // Valida os dados recebidos
        $mensagem = '';
        // Se for ação diferente de excluir valida os dados obrigatórios
        if ($acao != 'excluir'):
            if ($nome == '' || strlen($nome) < 3):
                $mensagem .= '<li>Favor preencher o Nome. </li>';
            endif;
            if ($mensagem != ''):
                $mensagem = '<ul>' . $mensagem . '</ul>';
                echo "<div class='alert alert-danger' role='alert'>" . $mensagem. "</div> ";
                exit;
            endif;
        endif;

        // Verifica se foi solicitada a inclusão de dados
        if ($acao == 'incluir'):

        $sql = 'INSERT INTO categorias (cat_nome) VALUES (:nome)';
        $stm = $conexao->prepare($sql);
        $stm->bindValue(':nome', $nome);
        $retorno = $stm->execute();

        if ($retorno):
            //echo "<div class='alert alert-success' role= 'alert'>Registro inserido com sucesso, aguarde você está sendo redirecionado ...</div> ";
            echo "<meta http-equiv=refresh content= '0;URL=indexcategoria.php')";
        else:
            echo "<div class= 'alert alert-danger' role= 'alert'>Erro ao inserir registro!</div> ";
            echo "<meta http-equiv=refresh content= '2;URL=indexcategoria.php')";
        endif;

    endif;

    // Verifica se foi solicitada a edição de dados
    if($acao == 'editar'):

        $sql = 'UPDATE categorias SET cat_nome=:nome ';
        $sql .= ' WHERE cat_codigo=:id';
        
        $stm = $conexao->prepare($sql);
        $stm->bindValue(':nome', $nome);
        $stm->bindValue(':id', $id);
        $retorno = $stm->execute();

        if ($retorno):
            //echo "<div class='alert alert-success' role='alert'>Registro editado com sucesso, aguarde você está sendo redirecionado ...</div>";
            echo"<meta http-equiv=refresh content='0;URL=indexcategoria.php'>";
        else:
            echo "<div class='alert alert-danger' role='alert'>Erro ao editar registro!</div>";
            echo"<meta http-equiv=refresh content='2;URL=indexcategoria.php'>";
        endif;

    endif;

    // Verifica se foi solicitada a exclusão dos dados
    if($acao == 'excluir'):

        // Excluir o registro do banco de dados
        $sql = 'DELETE FROM categorias WHERE cat_codigo=:id';
        $stm = $conexao->prepare($sql);
        $stm->bindValue(':id', $id);
        $retorno = $stm->execute();

        if ($retorno):
            //echo "<div class='alert alert-success' role='alert'>Registro excluído com sucesso, aguarde você está sendo redirecionado ...<div>";
            echo"<meta http-equiv=refresh content='0;URL=indexcategoria.php'>";
        else:
            echo "<div class='alert alert-danger' role='alert'>Erro ao excluir registro!</div>";
            echo"<meta http-equiv=refresh content='2;URL=indexcategoria.php'>";
        endif;

    endif;
    ?>
</body>
</html>