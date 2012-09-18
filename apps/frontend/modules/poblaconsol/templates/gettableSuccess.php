<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php
//print_r($_POST);
$err = 0;

//echo $sqlpdf;
?>

<!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
ob_start();
?>
<!-- FIN-->

<table class="tableSector">
    <thead>
        <tr>
        <th><a href="#" id="ordby_PARENTESCO_CROSS">Parentesco</a></th>
        <th><a href="#" id="ordby_MASCULINO">Masculino</a></th>
        <th><a href="#" id="ordby_FEMENINO">Femenino</a></th>
        <th><a href="#" id="ordby_TOTAL_MF">Total</a></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($POBLACION_CONSOLIDADA_VW as $row):
            ?>
            <tr>      
            <td>
                <input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaresum/index?mod=POC"."&idcliente=" . $_POST['idcliente'] . "&idcontratante=" . $_POST['idcontratante'] . "&idanno=" . $_POST['idanno'] . "&idmes=" . $_POST['idmes'] . "&idestatus=" . $_POST['idestatus'] . "&idcodcross=" . $row['CODPARENT_CROSS'] . "&idrangoedad=0") ?>'" /><?php echo $row['PARENTESCO_CROSS']; ?></td>
            <td class="alignRight"><?php echo format_number($row['MASCULINO']); ?></td>
            <td class="alignRight"><?php echo format_number($row['FEMENINO']); ?></td>
            <td class="alignRight"><?php echo format_number($row['TOTAL_MF']); ?></td>
            </tr>
            <?php
            //suma de totales
            $err = $err + $row['ERROR'];
            $totalMasculino = $totalMasculino + $row['MASCULINO'];
            $totalFemenino = $totalFemenino + $row['FEMENINO'];
            $totalGrupo = $totalGrupo + $row['TOTAL_MF'];
        endforeach;
        ?>
    </tbody>
    <tfoot>
        <tr>
        <td>Total</td>
        <td class="alignRight"><?php echo format_number($totalMasculino); ?></td>
        <td class="alignRight"><?php echo format_number($totalFemenino); ?></td>
        <td class="alignRight"><?php echo format_number($totalGrupo); ?></td>
        </tr>
    </tfoot>

</table>


<!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
echo $var = ob_get_clean();
?>
<!--FIN-->


<hr style="background-color:#E8E8E8; height:2px; border:0;" />
<?php if ($err > 0) { ?>
    <div class="messageBox successMessage">
        <p>La información visualizada no se encuentra completa debido a que el Cliente suministro la Data con inconsistencia</p>    
    </div>
<?php } ?>


<table class="sectorBottomMenu" >
    <tr>
    <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
    <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td> 
    <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                

</tr>                        
</table>

<br /><br />

<!-- Formulario oculto para crear pdf-->
<form method="post" id="targetpdf" action="<?php echo url_for('pdfpoblacion/index') ?>" target="_blank" hidden="hidden">
<input id="titulo_pdf"  name="titulo_pdf" type="text" value="Población Consolidada" />
    <textarea id="text_pdf" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
</form>
<!-- fin-->
<!-- Formulario oculto para crear excel-->
<form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
<input id="titulo"  name="titulo" type="text" value="Población Consolidada" />
    <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
</form>
<!-- fin-->



<script type="text/javascript">$("#cargando").css("display", "none");</script>


<script type="text/javascript">
    $("#url_imprime").click(function (){
        $("html").printArea();
    })
    //Funcion de submit pdf
    $('#url_pdf').click(function() {
        $('#targetpdf').submit();
    });
    //Funcion de submit excel
    $('#url_excel').click(function() {
        $('#targetexcel').submit();
    });    
</script>


<script type="text/javascript">
    $(function() {
        
        /*
         * CODIGO PARA CAPTURAR LOS VALORES SELECCIONADOS EN LA CONSULTA Y AGREGAR
         * LA COLUMNA PARA EL ORDERBY
         *
         **/      
            
            
        /*PARENTESCO*/
        $("#ordby_PARENTESCO_CROSS").click(function() {   
            $("#showTable").load("<?php echo url_for('poblaconsol/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante :    $("#cmbcontratante option:selected").val() ,
                idanno :           $("#cmbanno option:selected").val() ,
                idmes :            $("#cmbmes option:selected").val() ,
                idestatus :        $("#cmbestatus option:selected").val()  ,
                orderby:       'CODPARENT_CROSS'
            });
          
            return false;
        });	
        
        
        /*MASCULINO*/
        $("#ordby_MASCULINO").click(function() {   
            $("#showTable").load("<?php echo url_for('poblaconsol/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante :    $("#cmbcontratante option:selected").val() ,
                idanno :           $("#cmbanno option:selected").val() ,
                idmes :            $("#cmbmes option:selected").val() ,
                idestatus :        $("#cmbestatus option:selected").val()  ,
                orderby:       'MASCULINO'
            });
          
            return false;
        });	
        
        
        /*FEMENINO*/
        $("#ordby_FEMENINO").click(function() {   
            $("#showTable").load("<?php echo url_for('poblaconsol/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante :    $("#cmbcontratante option:selected").val() ,
                idanno :           $("#cmbanno option:selected").val() ,
                idmes :            $("#cmbmes option:selected").val() ,
                idestatus :        $("#cmbestatus option:selected").val()  ,
                orderby:       'FEMENINO'
            });
          
            return false;
        });	
        
        
        /*TOTAL*/
        $("#ordby_TOTAL_MF").click(function() {   
            $("#showTable").load("<?php echo url_for('poblaconsol/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante :    $("#cmbcontratante option:selected").val() ,
                idanno :           $("#cmbanno option:selected").val() ,
                idmes :            $("#cmbmes option:selected").val() ,
                idestatus :        $("#cmbestatus option:selected").val()  ,
                orderby:       'TOTAL_MF'
            });
          
            return false;
        });	
        
            
            
            
        
        
    });
</script>