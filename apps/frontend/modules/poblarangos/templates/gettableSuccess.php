<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php //print_r($_POST);   ?>
<!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
ob_start();
?>
<!-- FIN-->
<table class="tableSector">
    <thead>
        <tr>            
            <th><a href="#" id="ordby_EDAD">Rango de edad</a></th>
            <th><a href="#" id="ordby_MASCULINO">Masculino</a></th>
            <th><a href="#" id="ordby_FEMENINO">Femenino</a></th>
            <th><a href="#" id="ordby_TOTAL">Total</a></th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($POBLACION_RAN_EDA_SEX_MVW as $row): ?>
            <tr>                                

                <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaresum/index?mod=PES"."&idcliente=" . $_POST['idcliente'] . "&idcontratante=" . $_POST['idcontratante'] . "&idanno=" . $_POST['idanno'] . "&idmes=0" . "&idestatus=" . $_POST['idestatus'] . "&idcodcross=0" . "&idrangoedad=" . str_replace(" ", "", $row['EDAD']) . "") ?>'" /><?php echo $row['EDAD']; ?></td>
                <td class="alignRight"><?php echo format_number($row['MASCULINO']); ?></td>
                <td class="alignRight"><?php echo format_number($row['FEMENINO']); ?></td>
                <td class="alignRight"><?php echo format_number($row['TOTAL']); ?></td>
            </tr>                            
            <?php $sum_t = $sum_t + $row['MASCULINO']; ?>
            <?php $sum_b = $sum_b + $row['FEMENINO']; ?>
            <?php $sum_a = $sum_a + $row['TOTAL']; ?>
        <?php endforeach; ?>

    </tbody>
    <tfoot>
        <tr>
            <td>Total</td>
            <td class="alignRight"><?php echo format_number($sum_t); ?></td>
            <td class="alignRight"><?php echo format_number($sum_b); ?></td>
            <td class="alignRight"><?php echo format_number($sum_a); ?></td>
        </tr>
    </tfoot>

</table>
<!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
echo $var = ob_get_clean();
?>
<?php 
$err = 0;
foreach ($POBLACION_error as $row): ?>                                  
    <?php $err = $err + $row['ERROR']; ?>
<?php endforeach; ?>

<?php if($err > 0){?>
<div class="messageBox successMessage">
    <p>La información visualizada no se encuentra completa debido a que el Cliente suministro la Data con inconsistencia</p>    
</div>
<?php } ?>


<div class="clear" style="padding-bottom:30px;"></div>

<table class="sectorBottomMenu" >
    <tr>
    <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
    <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td> 
    <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                

</tr>                        
</table>
<!-- Formulario para crear pdf-->
<form method="post" id="targetpdf" action="<?php echo url_for('pdfpoblacion/index') ?>" target="_blank" hidden="hidden">
    <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Por rango de edad y sexo" />
    <textarea id="text_pdf" name="text" rows="2" cols="20"  >
        <?php echo $var; ?>
    </textarea>
</form>
<!-- fin-->

<!-- Formulario oculto para crear excel-->
<form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
<input id="titulo"  name="titulo" type="text" value="Por rango de edad y sexo" />
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




<script type="text/javascript">
    $(function() {
        
        /*
         * CODIGO PARA CAPTURAR LOS VALORES SELECCIONADOS EN LA CONSULTA Y AGREGAR
         * LA COLUMNA PARA EL ORDERBY
         *
         **/            
            
            
        /*PARENTESCO*/
        $("#ordby_EDAD").click(function() {   
            $("#showTable").load("<?php echo url_for('poblarangos/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante:     $("#cmbcontratante option:selected").val() ,
                idanno:            $("#cmbanno option:selected").val() ,
                idestatus:         $("#cmbestatus option:selected").val() ,
                orderby:       'EDAD'
            });
          
            return false;
        });	
        
        
        /*MASCULINO*/
        $("#ordby_MASCULINO").click(function() {   
            $("#showTable").load("<?php echo url_for('poblarangos/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante:     $("#cmbcontratante option:selected").val() ,
                idanno:            $("#cmbanno option:selected").val() ,
                idestatus:         $("#cmbestatus option:selected").val() ,
                orderby:       'MASCULINO'
            });
          
            return false;
        });	
        
        
        /*FEMENINO*/
        $("#ordby_FEMENINO").click(function() {   
            $("#showTable").load("<?php echo url_for('poblarangos/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante:     $("#cmbcontratante option:selected").val() ,
                idanno:            $("#cmbanno option:selected").val() ,
                idestatus:         $("#cmbestatus option:selected").val() ,
                orderby:       'FEMENINO'
            });
          
            return false;
        });	
        
        
        /*TOTAL*/
        $("#ordby_TOTAL").click(function() {   
            $("#showTable").load("<?php echo url_for('poblarangos/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante:     $("#cmbcontratante option:selected").val() ,
                idanno:            $("#cmbanno option:selected").val() ,
                idestatus:         $("#cmbestatus option:selected").val() ,
                orderby:       'TOTAL'
            });
          
            return false;
        });	
        
            
            
            
        
        
    });
</script>

