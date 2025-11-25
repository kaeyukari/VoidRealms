<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Sistema de Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.min.css">    
    <link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
    <?php
    require 'bd/conexao.php';
    $conexao = conexao::getInstance();
    
    $acao = (isset ($_POST['acao'])) ? $_POST['acao'] : '';
    $id = (isset ($_POST['id'])) ? $_POST['id'] : '';
    $nome = (isset ($_POST['nome'])) ? $_POST['nome'] : '';
    $datainicio = (isset ($_POST['datainicio'])) ? $_POST['datainicio'] : '';
    $datafim = (isset ($_POST['datafim'])) ? $_POST['datafim'] : '';
    $descritivo = (isset ($_POST['descritivo'])) ? $_POST['descritivo'] : '';
    $periodo = (isset ($_POST['periodo'])) ? $_POST['periodo'] : '';
    $area = (isset ($_POST['area'])) ? $_POST['area'] : '';
    $local = (isset ($_POST['local'])) ? $_POST['local'] : '';

    $mensagem = '';

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

    if ($acao == 'incluir'):
        // Verifica se o arquivo de imagem foi enviado
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
            $imagem = $_FILES['imagem'];
            $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
            $novoNome = uniqid() . '.' . $extensao;

            // Move a imagem para a pasta 'uploads'
            move_uploaded_file($imagem['tmp_name'], 'uploads/' . $novoNome);

            // Insere os dados no banco de dados, incluindo a imagem
            $sql = 'INSERT INTO eventos (eve_nome, eve_datainicio, eve_datafim, eve_descritivo, eve_periodo, eve_area, eve_local, eve_imagem) VALUES (:nome, :datainicio, :datafim, :descritivo, :periodo, :area, :local, :imagem)';
            $stm = $conexao->prepare($sql);
            $stm->bindValue(':imagem', $novoNome);
        } else {
            // Caso a imagem não tenha sido enviada, insira os dados sem a imagem
            $sql = 'INSERT INTO eventos (eve_nome, eve_datainicio, eve_datafim, eve_descritivo, eve_periodo, eve_area, eve_local) VALUES (:nome, :datainicio, :datafim, :descritivo, :periodo, :area, :local)';
            $stm = $conexao->prepare($sql);
        }

        // Vincula outros parâmetros
        $stm->bindValue(':nome', $nome);
        $stm->bindValue(':datainicio', $datainicio);
        $stm->bindValue(':datafim', $datafim);
        $stm->bindValue(':descritivo', $descritivo);
        $stm->bindValue(':periodo', $periodo);
        $stm->bindValue(':area', $area);
        $stm->bindValue(':local', $local);

        $retorno = $stm->execute();

        if ($retorno):
            echo "<meta http-equiv=refresh content='0;URL=indexevento.php'>";
        else:
            echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div>";
            echo "<meta http-equiv=refresh content='2;URL=indexevento.php'>";
        endif;

    endif;

    if($acao == 'editar'):
        $sql = 'UPDATE eventos SET eve_nome=:nome, eve_datainicio=:datainicio, eve_datafim=:datafim, eve_descritivo=:descritivo, eve_periodo=:periodo, eve_area=:area, eve_local=:local ';
        
        // Verifica se uma nova imagem foi enviada
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
            $imagem = $_FILES['imagem'];
            $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
            $novoNome = uniqid() . '.' . $extensao;

            // Move a imagem para a pasta 'uploads'
            move_uploaded_file($imagem['tmp_name'], 'uploads/' . $novoNome);

            // Adiciona a imagem à atualização
            $sql .= ', eve_imagem = :imagem';
        }

        $sql .= ' WHERE eve_codigo=:id';

        $stm = $conexao->prepare($sql);
        $stm->bindValue(':nome', $nome);        
        $stm->bindValue(':datainicio', $datainicio);
        $stm->bindValue(':datafim', $datafim);
        $stm->bindValue(':descritivo', $descritivo);
        $stm->bindValue(':periodo', $periodo);
        $stm->bindValue(':area', $area);
        $stm->bindValue(':local', $local);
        $stm->bindValue(':id', $id);
        
        // Se uma nova imagem foi enviada, vincule o novo nome
        if (isset($novoNome)) {
            $stm->bindValue(':imagem', $novoNome);
        }

        $retorno = $stm->execute();

        if ($retorno):
            echo "<meta http-equiv=refresh content='0;URL=indexevento.php'>";
        else:
            echo "<div class='alert alert-danger' role='alert'>Erro ao editar registro!</div>";
            echo "<meta http-equiv=refresh content='2;URL=indexevento.php'>";
        endif;

    endif;

    if($acao == 'excluir'):
        $sql = 'DELETE FROM eventos WHERE eve_codigo=:id';
        $stm = $conexao->prepare($sql);
        $stm->bindValue(':id', $id);
        $retorno = $stm->execute();

        if ($retorno):
            echo "<meta http-equiv=refresh content='0;URL=indexevento.php'>";
        else:
            echo "<div class='alert alert-danger' role='alert'>Erro ao excluir registro!</div>";
            echo "<meta http-equiv=refresh content='2;URL=indexevento.php'>";
        endif;
    endif;
    ?>
</body>
</html>
