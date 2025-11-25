<?php 

require 'bd/conexao.php';

$conexao = conexao::getInstance();
$sql = 'SELECT * FROM eventos order by eve_nome';
$stm = $conexao->prepare($sql);
$stm->execute();
$eventos = $stm->fetchAll(PDO::FETCH_OBJ);

// iniciar o HTML
$html = '<h1> Listagem de Evento </h1>';

if (!empty($eventos)): 

    $html.='
    <table class="table table-striped">
        <tr class="active">
            <th>Código</th>
            <th>Nome</th>
            <th>Data Início</th>
            <th>Data Fim</th>
            <th>Descrição</th>
            <th>Período</th>
            <th>Área</th>
            <th>Local</th>
        </tr>';
        foreach ($eventos as $evento): 
            $html.='<tr>
                <td>'. $evento->eve_codigo .'
                </td>
                <td>'.$evento->eve_nome.'
                </td>
                <td>'.$evento->eve_datainicio.'
                </td>      
                <td>'.$evento->eve_datafim.'
                </td>
                <td>'.$evento->eve_descritivo.'
                </td>
                <td>'.$evento->eve_periodo.'
                </td>   
                <td>'.$evento->eve_area.'
                </td>
                <td>'.$evento->eve_local.'
                </td> 
            </tr>';
         endforeach;
    $html.='</table>';

endif;
// carregar o Composer
require './vendor/autoload.php';


// referenciar o Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

// instantiate and use the dompdf class


$options = new Options(); 
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
// portrait or landscape
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('eventos.pdf', array('Attachment' => false));
