<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//echo $TuDominio = $_SERVER['SERVER_NAME'];
//echo $_SERVER['SCRIPT_NAME'];

?>
        
<?php   
//echo $_GET['mod'];
//IF ($_GET['mod'] == 'POC') {
//    $modulo = 'poblaconsol';
//}ELSE IF ($_GET['mod'] == 'PEM') {
//    $modulo = 'poblaevoluc';
//}ELSE IF ($_GET['mod'] == 'PES') {
//    $modulo = 'poblarangos';
//}ELSE IF ($_GET['mod'] == 'PEP') {
//    $modulo = 'poblarangop';
//}
//
//$url_atras="http://".$_SERVER['SERVER_NAME']."/".$modulo."?".$_SERVER['QUERY_STRING'];
            ?>
<?php //echo $sqlpdf; ?>
<?php //echo $url = $_SERVER['REQUEST_URI'] . '&orderby=';    ?>
<div id="cargando" style="display: none;"><img src="/images/green-loading.gif" style="text-align: center" />&nbsp;</div>
<div id="showTable" name="show" ></div>
<table class="tableSector">
    <thead>
        <tr>
<!--            <th>N.</th>-->
            <th>Afiliado </th>
            <th>C.I. </th>
            <th>Contrato </th>
            <th>Fecha Ingreso </th>
            <th>Plazo de espera</th>
            <th>Parentesco</a> </th>
            <th>Sexo</th>
            <th>Edad</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //print_r($registros );
        foreach ($registros as $row):
            ?>
            <?php //foreach ($pager->getResults() as $row): 
//            if($row['NOMBRE']==''):
//                echo 'hola';
//            endif;
                
            
            $var_idcliente = $_GET['idcliente'];
            $var_idcontratante = $_GET['idcontratante'];
            $var_CERTIFICADO = $row['CERTIFICADO'];
            ?>       
        
            <tr>
<!--                <td class="alignRight"><?php echo $row['CONTADOR']; ?></td>-->
                <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaficha/index?".$_SERVER['QUERY_STRING']."&idcliente=" . $var_idcliente . "&idcontratante=" . $var_idcontratante . "&idcertificado=" . $var_CERTIFICADO . "") ?>'" /><?php echo $row['NOMBRE'];?></td>
                <td class="alignRight"><?php echo $row['CEDULA']; ?></td>
                <td class="alignRight"><?php echo $row['IDEPOL']; ?></td>
                <td class="alignRight"><?php echo format_date($row['FECING'], 'dd-MM-y'); ?></td>
                <td class="alignRight"><?php echo $row['PLAZO_ESPERA']; ?></td>
                <td class="alignRight"><?php echo $row['PARENTESCO_CROSS']; ?></td>
                <td class="alignRight"><?php echo $row['SEXO_PARENTESCO']; ?></td>
                <td class="alignRight"><?php echo $row['EDAD']; ?></td>
            </tr>
            <?php
        endforeach;
        ?>
<table class="sectorBottomMenu" >
    <tr>
    <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
    <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td> 
    <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>    
    <td><a href="<?php echo $url_atras; ?>" id="url_atras">Atrás</a></td>

</tr>                        
</table>

<br /><br />


<!-- fin-->
    </tbody>
</table>


<div class="clear" style="padding-bottom:30px;"></div>
<?php
// Parametros a ser usados por el Paginador.
$cantidadRegistrosPorPagina = 10;
$cantidadEnlaces = 20; // Cantidad de enlaces que tendra el paginador.
$totalRegistros = $totalRegistros;
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0;

// Comenzamos incluyendo el Paginador.
require_once 'Paginador.php';

// Instanciamos la clase Paginador
$paginador = new Paginador();

// Configuramos cuanto registros por pagina que debe ser igual a el limit de la consulta mysql
$paginador->setCantidadRegistros($cantidadRegistrosPorPagina);
// Cantidad de enlaces del paginador sin contar los no numericos.
$paginador->setCantidadEnlaces($cantidadEnlaces);

// Agregamos estilos al Paginador
$paginador->setClass('primero', 'previous');
$paginador->setClass('bloqueAnterior', 'previous');
$paginador->setClass('anterior', 'previous');
$paginador->setClass('siguiente', 'next');
$paginador->setClass('bloqueSiguiente', 'next');
$paginador->setClass('ultimo', 'next');
$paginador->setClass('numero', '<>');
$paginador->setClass('actual', 'active');

// Y mandamos a paginar desde la pagina actual y le pasamos tambien el total
// de registros de la consulta mysql.
$datos = $paginador->paginar($pagina, $totalRegistros);

// Preguntamos si retorno algo, si retorno paginamos. Nos retorna un arreglo
// que se puede usar para paginar del modo clasico. Si queremos paginar con
// el enlace ya confeccionado realizamos lo siguiente.
if ($datos) {
    $enlaces = $paginador->getHtmlPaginacion('pagina', 'li');
    ?>
    <ul id="pagination-digg">
        <?php
        foreach ($enlaces as $enlace) {
            echo $enlace . "\n";
        }
        ?>
    </ul>
    <br /><br />
    <?php
}
?>  
    
    <script type="text/javascript">
    $("#url_imprime").click(function (){
        //$("targetprint").printArea();
        $('#targetprint').submit();
        
      
    })
//    funcion de submit pdf
    $('#url_pdf').click(function() {
        $('#targetpdf').submit();
    });    
    
        //Funcion de submit excel
    $('#url_excel').click(function() {
        $('#targetexcel').submit();
    }); 
</script>