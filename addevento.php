<!DOCTYPE html>
<html lang="pt-br">
<?php
require_once 'bd/conexao.php'; // Altere aqui
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <fieldset>
            <legend>
                <h1>Formulário - Cadastro de evento</h1>
            </legend>
            <form action="actionevento.php" method="post" id="form-contato" enctype='multipart/form-data'>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Informe o Nome" maxlength="30">
                    <span class="msg-erro msg-nome"></span>
                </div>
                <div class="form-group">
                    <label for="datainicio">Data início</label>
                    <input type="date" class="form-control" id="datainicio" name="datainicio" placeholder="Informe a Data de Início" maxlength="30">
                    <span class="msg-erro msg-datainicio"></span>
                </div>

                <div class="form-group">
                    <label for="datafim">Data fim</label>
                    <input type="date" class="form-control" id="datafim" name="datafim" placeholder="Informe a Data de Fim" maxlength="30">
                    <span class="msg-erro msg-datafim"></span>
                </div>

                <div class="form-group">
                    <label for="descritivo">Descritivo</label>
                    <input type="text" class="form-control" id="descritivo" name="descritivo" placeholder="Informe o Descritivo" maxlength="30">
                    <span class="msg-erro msg-descritivo"></span>
                </div>

                <div class="form-group">
                    <label for="periodo">Período</label>
                    <input type="text" class="form-control" id="periodo" name="periodo" placeholder="Informe o Período" maxlength="30">
                    <span class="msg-erro msg-periodo"></span>
                </div>

                <div class="form-group">
                    <label for="area">Área</label>
                    <input type="text" class="form-control" id="area" name="area" placeholder="Informe a Área" maxlength="30">
                    <span class="msg-erro msg-area"></span>
                </div>

                <div class="form-group">
                    <label for="local">Local</label>
                    <input type="text" class="form-control" id="local" name="local" placeholder="Informe o Local" maxlength="30">
                    <span class="msg-erro msg-local"></span>
                </div>
                <div class="form-group">
                   <label for="imagem">Imagem</label>
                   <input type="file" class="form-control" id="imagem" name="imagem">
                </div>


                <div class="form-group bordasup">
                    <input type="hidden" name="acao" value="incluir">
                    <button type="submit" class="btn btn-primary" id="botao">Gravar</button>
                    <a href="indexevento.php" class="btn btn-danger pull-right">Voltar</a>
                </div>
            </form>
        </fieldset>
    </div>
</body>
</html>
