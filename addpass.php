<!DOCTYPE html>
<html lang="pt-br">
<?php
require_once 'bd/conexao.php';
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-5">
        <fieldset>
            <legend>
                <h1>Formulário - Cadastro de Passe</h1>
            </legend>
            <form action="actionpass.php" method="post" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Passe" required>
                </div>

                <div class="form-group mb-3">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição do passe" required>
                </div>

                <div class="form-group mb-3">
                    <label for="preco">Preço (créditos)</label>
                    <input type="number" step="0.01" class="form-control" id="preco" name="preco" placeholder="Preço do passe" required>
                </div>
                <div class="form-group mb-3">
                    <label for="imagem">Imagem do Passe</label>
                    <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" required>
                </div>


                <div class="form-group mt-4">
                    <input type="hidden" name="acao" value="incluir">
                    <button type="submit" class="btn btn-success">Gravar</button>
                    <a href="loja.php" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </fieldset>
    </div>
</body>
</html>
