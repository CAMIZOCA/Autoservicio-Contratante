<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php //print_r($_POST); ?>
<!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
ob_start();
?>
<table class="tableSector">
    <thead>
        <tr>

            <th>Población</th>
            <th>Número de altas</th>
            <th>Número de bajas</th>
            <th>Total de movimientos</th>

        </tr>
    </thead>

    <tbody>
        <?php
//print_r($altbaevoluc);
        foreach ($altbaevoluc as $row):
            ?>
            <tr>
<!--            <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaresum/index?idcliente=" . $_POST['idcliente'] . "&idcontratante=" . $_POST['idcontratante'] . "&idanno=" . $_POST['idanno'] . "&idmes=" . $row['IDMES'] . "&idestatus=" . $_POST['idestatus'] . "&idcodcross=0&idrangoedad=0 ") ?>'" /> <?php echo $row['MES']; ?></td>-->
                <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("altbaevoluc/list")."?mod=EVO&idcliente=" . $_POST['idcliente'] . "&idcontratante=" . $_POST['idcontratante'] . "&idanno=" . $row['ANNO'] . "&idmes=". $row['IDMES']. "&idestatus=0"                      . "&idcodcross=0&idrangoedad=0" ?>'" /> <?php echo $row['MES'].' '.$row['ANNO']; ?></td>
<!--                <td><input class="botonadd" type="button" /><?php echo $row['MES']; ?></td>-->
                <td class="alignRight"><?php echo format_number($row['ALTAS']); ?></td>
                <td class="alignRight"><?php echo format_number($row['BAJAS']); ?></td>
                <td class="alignRight"><?php echo format_number($row['TOTAL']); ?></td>
            </tr>
            <?php
            //suma de totales
            $totalALTAS = $totalALTAS + $row['ALTAS'];
            $totalBAJAS = $totalBAJAS + $row['BAJAS'];
            $total = $total + $row['TOTAL'];
        endforeach;
        ?>
</table>

<!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
echo $var = ob_get_clean();
?>

<div class="clear" style="padding-bottom:30px;"></div>

<!-- FIN DEL BACKEND -->

<hr style="background-color:#E8E8E8; height:2px; border:0;" />

<table class="sectorBottomMenu" >
    <tr>
    <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
    <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td> 
    <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                

</tr>                        
</table>
<!-- Formulario para crear pdf-->
<form method="post" id="targetpdf" action="<?php echo url_for('pdfpoblacion/index') ?>" target="_blank" hidden="hidden">
    <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Altas y Bajas Evolución" />
    <textarea id="text_pdf" name="text" rows="2" cols="20"  >
        <?php echo $var; ?>
    </textarea>
</form>
<!-- fin-->
<!-- Formulario oculto para crear excel-->
<form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
<input id="titulo"  name="titulo" type="text" value="Altas y Bajas Evolución" />
    <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
</form>
<!-- fin-->

<script type="text/javascript">$("#cargando").css("display", "none");</script>

<script type="text/javascript">
    $("#url_imprime").click(function (){
        $("html").printArea();
    })
    
    $('#url_pdf').click(function() {
        $('#targetpdf').submit();
    });    
        //Funcion de submit excel
    $('#url_excel').click(function() {
        $('#targetexcel').submit();
    }); 
</script>
