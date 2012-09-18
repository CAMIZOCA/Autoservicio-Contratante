<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php use_helper('Date'); ?>
<?php //print_r($_POST);    ?>

<!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
ob_start();
?>
<!-- FIN-->
<div class="cajas_totales">
    <div class="cajitas_peq_totales">
        <div class="linea">
            <div class="titulo_cajita">NUMERO DE ALTAS:</div>
            <div class="total_bs"><?php echo ($TOTAL_ALTA[0]['TOTAL']); ?></div>
        </div>
        <div class="linea_media">
            <div class="titulo_cajita">NUMERO DE BAJAS:</div>
            <div class="total_bs"><?php echo ($TOTAL_BAJA[0]['TOTAL']); ?></div>
        </div>
    </div>

</div>



<table class="tableSector">
    <thead>
        <tr>

        <th>N.</th>
        <th>N° de contrato</th>
        <th>C.I. del titular</th>
        <th>C.I del afiliado</th>
        <th>Nombre del afiliado</th>
        <th>Parentesco</th>
        <th>Sexo</th>
        <th>Status</th>
        <th>Fecha de movimiento</th>

        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($ALTA_BAJA_MENSUAL_VW as $row):
            ?>
            <tr>      
    <td class="alignRight"><?php echo $row['CONTADOR']; ?></td>
            <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaficha/index?idcliente=" . $_POST['idcliente'] . "&idcontratante=" . $_POST['idcontratante'] . "&idcertificado=" . $row['CERTIFICADO'] . "") ?>'" /><?php echo $row['CONTRATO']; ?></td>
            <td class="alignRight"><?php echo $row['CEDULATIT']; ?></td>
            <td class="alignRight"><?php echo $row['CEDULABEN']; ?></td>
            <td ><?php echo $row['NOMBRE']; ?></td>
            <td class="alignRight"><?php echo $row['PARENTESCO_CROSS']; ?></td>
            <td class="alignRight"><?php echo $row['SEXO_PARENTESCO']; ?></td>
            <td ><?php echo $row['ESTATUS']; ?></td>
            <td class="alignRight"><?php //echo $row['FECHA_MOVIMIENTO'];    ?><?php echo format_date($row['FECMOV'], 'dd/MM/y '); ?></td>
            </tr>
            <?php
            //suma de totales

        endforeach;
        ?>
    </tbody>
</table>
<!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
echo $var = ob_get_clean();
?>
<!-- Formulario para crear pdf-->
<form method="post" id="targetpdf" action="<?php echo url_for('pdfpoblacion/index') ?>" target="_blank" hidden="hidden">
    <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Altas y Bajas Mensualizadas" />
    <textarea id="text_pdf" name="text" rows="2" cols="20"  >
        <?php echo $var; ?>
    </textarea>
</form>
<!-- fin-->

<?php
// Parametros a ser usados por el Paginador.
$cantidadRegistrosPorPagina = 10;
$cantidadEnlaces = 10; // Cantidad de enlaces que tendra el paginador.
echo $totalRegistros = $totalRegistros;
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
/*if ($datos) {
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
}*/
?>   
<div class="clear" style="padding-bottom:30px;"></div>

<!-- FIN DEL BACKEND -->

<hr style="background-color:#E8E8E8; height:2px; border:0;" />

<table class="sectorBottomMenu" >
    <tr>
<!--        <td><a href="#" id="url_excel">Excel</a></td>-->
    <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td> 
    <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                

</tr>                        
</table>


<script type="text/javascript">$("#cargando").css("display", "none");</script>

<script type="text/javascript">
    $("#url_imprime").click(function (){
        $("html").printArea();
    })
    
    $('#url_pdf').click(function() {
        $('#targetpdf').submit();
    });    
</script>
