<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php //print_r($_POST);    ?>
<?php //echo $url = $_SERVER['REQUEST_URI'] . "&orderby=edad"; ?>
<!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
ob_start();
?>
<!-- FIN-->
<table class="tableSector">
    <thead>
        <tr>

            <th>Población</th>
            <th>Titulares</th>
            <th>Beneficiarios</th>
            <th>Total</th>
            <th>Promedio/mes</th>

        </tr>
    </thead>
    <tbody>

        <?php foreach ($POBLACION_EVOLUCION_VW as $row): ?>
            <tr>       
                <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaresum/index?mod=PEM"."&idcliente=" . $_POST['idcliente'] . "&idcontratante=" . $_POST['idcontratante'] . "&idanno=" . $_POST['idanno'] . "&idmes=" . $row['IDMES'] . "&idestatus=" . $_POST['idestatus'] . "&idcodcross=0&idrangoedad=0") ?>'" /> <?php echo $row['MES']; ?>-<?php echo $row['ANNO']; ?></td>
                <td class="alignRight"><?php echo format_number($row['TOTAL_T']); ?></td>
                <td class="alignRight"><?php echo format_number($row['TOTAL_B']); ?></td>
                <td class="alignRight"><?php echo format_number($row['TOTAL_A']); ?></td>
                <td class="alignRight"><?php printf("%.2f", ($row['TOTAL_A'] * 100) / $row['TOTAL_GENERAL']); ?>%</td>
            </tr>   

            <?php $sum_t = $sum_t + $row['TOTAL_T'] ?>
            <?php $sum_b = $sum_b + $row['TOTAL_B'] ?>
            <?php $sum_a = $sum_a + $row['TOTAL_A'] ?>
            <?php $sum_prom = $sum_prom + ($row['TOTAL_A'] * 100) / $row['TOTAL_GENERAL'] . ' %'; ?>
        <?php endforeach; ?>


    </tbody>
    <tfoot>
        <tr>
            <td>Total</td>
            <td class="alignRight"><?php echo format_number($sum_t); ?></td>
            <td class="alignRight"><?php echo format_number($sum_b); ?></td>
            <td class="alignRight"><?php echo format_number($sum_a); ?></td>
            <td class="alignRight"><?php echo format_number($sum_prom); ?> %</td>
        </tr>
    </tfoot>
</table>                    
<!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
echo $var = ob_get_clean();
?>
<div class="clear" style="padding-bottom:30px;"></div>

<!-- FIN DEL BACKEND -->

<hr style="background-color:#E8E8E8; height:2px; border:0;" />


<table class="sectorBottomMenu">
    <tr>
        <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
        <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td> 
        <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                
    </tr>                        
</table>
<!-- Formulario para crear pdf-->
<form method="post" id="targetpdf" action="<?php echo url_for('pdfpoblacion/index') ?>" target="_blank" hidden="hidden">
    <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Población Evolución" />
    <textarea id="text_pdf" name="text" rows="2" cols="20"  >
        <?php echo $var; ?>
    </textarea>
</form>
<!-- fin-->
<!-- Formulario oculto para crear excel-->
<form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
<input id="titulo"  name="titulo" type="text" value="Población Evolución" />
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
        
        /*POBLACION*/
        $("#ordby_poblacion").click(function() {   
            $("#showTable").load("<?php echo url_for('poblaevoluc/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante:     $("#cmbcontratante option:selected").val() ,
                idanno:            $("#cmbanno option:selected").val() ,
                idestatus:         $("#cmbestatus option:selected").val() ,
                idpoblacion:       $("#cmbpoblacion option:selected").val() ,
                orderby:       'poblacion'
            });
          
            return false;
        });	
        
        
        /*TITULARES*/
        $("#ordby_total_t").click(function() {   
            $("#showTable").load("<?php echo url_for('poblaevoluc/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante:     $("#cmbcontratante option:selected").val() ,
                idanno:            $("#cmbanno option:selected").val() ,
                idestatus:         $("#cmbestatus option:selected").val() ,
                idpoblacion:       $("#cmbpoblacion option:selected").val() ,
                orderby:       'total_t'
            });
          
            return false;
        });	
        
        
        /*BENEFICIARIO*/
        $("#ordby_total_b").click(function() {   
            $("#showTable").load("<?php echo url_for('poblaevoluc/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante:     $("#cmbcontratante option:selected").val() ,
                idanno:            $("#cmbanno option:selected").val() ,
                idestatus:         $("#cmbestatus option:selected").val() ,
                idpoblacion:       $("#cmbpoblacion option:selected").val() ,
                orderby:       'total_b'
            });
          
            return false;
        });	
        
        
        /*TOTAL ACUMULADO*/
        $("#ordby_total_a").click(function() {   
            $("#showTable").load("<?php echo url_for('poblaevoluc/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante:     $("#cmbcontratante option:selected").val() ,
                idanno:            $("#cmbanno option:selected").val() ,
                idestatus:         $("#cmbestatus option:selected").val() ,
                idpoblacion:       $("#cmbpoblacion option:selected").val() ,
                orderby:       'total_a'
            });
          
            return false;
        });	
        
            
            
            
        
        
    });
</script>