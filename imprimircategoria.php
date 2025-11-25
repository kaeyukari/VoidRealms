<?php 

require 'bd/conexao.php';

$conexao = conexao::getInstance();
$sql = 'SELECT * FROM categorias order by cat_nome';
$stm = $conexao->prepare($sql);
$stm->execute();
$categorias = $stm->fetchAll(PDO::FETCH_OBJ);

// iniciar o HTML
$html = '<h1> Listagem de Usuario </h1>';

if (!empty($categorias)): 

    $html.='
    <table class="table table-striped">
        <tr class="active">
            <th>Código</th>
            <th>Nome</th>
        </tr>';
        foreach ($categorias as $categoria): 
            $html.='<tr>
                <td>'. $categoria->cat_codigo .'
                </td>
                <td>'.$categoria->cat_nome.'
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
$dompdf->stream('categorias.pdf', array('Attachment' => false));
