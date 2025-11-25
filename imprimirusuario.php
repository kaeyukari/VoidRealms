<?php 

require 'bd/conexao.php';

// Conexão com o banco de dados
$conexao = conexao::getInstance();
$sql = 'SELECT * FROM usuario ORDER BY usu_nome';
$stm = $conexao->prepare($sql);
$stm->execute();
$usuarios = $stm->fetchAll(PDO::FETCH_OBJ);

// Iniciar o HTML do PDF
$html = '<h1> Listagem de Usuários </h1>';

if (!empty($usuarios)): 
    $html .= '
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Email</th>
                <th>CEP</th>
                <th>Logradouro</th>
                <th>Número</th>
                <th>Complemento</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <th>UF</th>
                <th>Categoria</th>
            </tr>
        </thead>
        <tbody>';
    
    foreach ($usuarios as $usua): 
        $html .= '<tr>
            <td>'. $usua->usu_codigo .'</td>
            <td>'. $usua->usu_nome .'</td>
            <td>'. $usua->usu_email .'</td>
            <td>'. $usua->usu_cep .'</td>
            <td>'. $usua->usu_logradouro .'</td>
            <td>'. $usua->usu_numero .'</td>
            <td>'. $usua->usu_complemento .'</td>
            <td>'. $usua->usu_bairro .'</td>
            <td>'. $usua->usu_cidade .'</td>
            <td>'. $usua->usu_uf .'</td>
            <td>'. $usua->cat_codigo .'</td>
        </tr>';
    endforeach;

    $html .= '</table>';
else:
    $html .= '<p>Nenhum usuário encontrado.</p>';
endif;

// Carregar o Composer
require './vendor/autoload.php';

// Referenciar o Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

// Instanciar o Dompdf com opções
$options = new Options(); 
$options->set('isRemoteEnabled', true); // Habilita links remotos, se necessário
$dompdf = new Dompdf($options);

// Carregar o HTML
$dompdf->loadHtml($html);

// Definir o tamanho do papel e a orientação
$dompdf->setPaper('A4', 'portrait');

// Renderizar o HTML como PDF
$dompdf->render();

// Enviar o arquivo PDF para o navegador
$dompdf->stream('usuarios.pdf', array('Attachment' => false));

