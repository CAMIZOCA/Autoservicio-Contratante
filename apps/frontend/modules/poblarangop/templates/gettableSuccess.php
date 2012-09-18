<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php //print_r($_POST);  ?>
<!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
ob_start();
?>
<!-- FIN-->
<table class="tableSector">
    <thead>
        <tr>
            <th>Masculino</th>
        </tr>
    </thead>
</table>
<table class="tableSector">
    <thead>
        <tr>
            <th>Rango de edad</th>
            <th>0-10</th>
            <th>11-18</th>
            <th>19-39</th>
            <th>40-55</th>
            <th>56-65</th>
            <th>66-70</th>
            <th>71-80</th>
            <th>81-90</th>
            <th>91-100</th>
            <th>101-Más</th>
            <th>Total</th>
            <th>Participacion</th>
        </tr>
    </thead>
    <tbody><?php
            $t1 = 0;
            $t2 = 0;
            $t3 = 0;
            $t4 = 0;
            $t5 = 0;
            $t6 = 0;
            $t7 = 0;
            $t8 = 0;
            $t9 = 0;
            $t9a = 0;
            $t10 = 0;
            $t11 = 0;
            ?>
        <?php foreach ($POBLACION_RANGO_EDAD_SEXO_PARENT_MASC_VW as $row): ?>
            <tr>                                
                <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaresum/index?mod=PEP"."&idcliente=".$_POST['idcliente']."&idcontratante=".$_POST['idcontratante']."&idanno=".$_POST['idanno']."&idestatus=".$_POST['idestatus']."&idcodcross=".$row['CODPARENT_CROSS']."") ?>'" /> <?php echo $row['PARENTESCO']; ?></td>
                <td class="alignRight"><?php echo format_number($row['DIEZ']); ?></td>
                <td class="alignRight"><?php echo format_number($row['DIESYOCHO']); ?></td>
                <td class="alignRight"><?php echo format_number($row['TREINTAYNUEVE']); ?></td>
                <td class="alignRight"><?php echo format_number($row['CINCUENTAYCINCO']); ?></td>
                <td class="alignRight"><?php echo format_number($row['SESENTAYCINCO']); ?></td>
                <td class="alignRight"><?php echo format_number($row['SETENTA']); ?></td>
                <td class="alignRight"><?php echo format_number($row['OCHENTA']); ?></td>
                <td class="alignRight"><?php echo format_number($row['NOVENTA']); ?></td>
                <td class="alignRight"><?php echo format_number($row['MASNOVENTA']); ?></td>
                <td class="alignRight"><?php echo format_number($row['MASCIEN']); ?></td>
                <td class="alignRight"><strong><?php echo format_number($row['TOTAL']); ?></strong></td>
                <td class="alignRight"><?php echo sprintf("%01.2f", str_replace(",",".",$row['PORC'])); ?> %</td>
            </tr>
            <?php
            $t1 = $t1 + $row['DIEZ'];
            $t2 = $t2 + $row['DIESYOCHO'];
            $t3 = $t3 + $row['TREINTAYNUEVE'];
            $t4 = $t4 + $row['CINCUENTAYCINCO'];
            $t5 = $t5 + $row['SESENTAYCINCO'];
            $t6 = $t6 + $row['SETENTA'];
            $t7 = $t7 + $row['OCHENTA'];
            $t8 = $t8 + $row['NOVENTA'];
            $t9 = $t9 + $row['MASNOVENTA'];
            $t9a = $t9a + $row['MASCIEN'];
            $t10 = $t10 + $row['TOTAL'];            
            $t11 = $t11 + str_replace(",",".",$row['PORC']);
            ?>
        <?php endforeach; ?>

  

    </tbody>
    <tfoot>
        <tr>
            <td>Total</td>
            <td class="alignRight"><?php echo format_number($t1) ?></td>
            <td class="alignRight"><?php echo format_number($t2) ?></td>
            <td class="alignRight"><?php echo format_number($t3) ?></td>
            <td class="alignRight"><?php echo format_number($t4) ?></td>
            <td class="alignRight"><?php echo format_number($t5) ?></td>
            <td class="alignRight"><?php echo format_number($t6) ?></td>
            <td class="alignRight"><?php echo format_number($t7) ?></td>
            <td class="alignRight"><?php echo format_number($t8) ?></td>
            <td class="alignRight"><?php echo format_number($t9) ?></td>
            <td class="alignRight"><?php echo format_number($t9a) ?></td>            
            <td class="alignRight"><?php echo format_number($t10) ?></td>
            <td class="alignRight"><?php echo format_number($t11) ?></td>
        </tr>
    </tfoot>

</table>



<table class="tableSector">
    <thead>
        <tr>
            <th>Femenino</th>
        </tr>
    </thead>
</table>


<table class="tableSector">
    <thead>
        <tr>
            
            <th>Rango de edad</th>
            <th>0-10</th>
            <th>11-18</th>
            <th>19-39</th>
            <th>40-55</th>
            <th>56-65</th>
            <th>66-70</th>
            <th>71-80</th>
            <th>81-90</th>
            <th>91-100</th>
            <th>101-Más</th>
            <th>Total</th>
            <th>Participación</th>
        </tr>
    </thead>
    <tbody><?php
            $t1 = 0;
            $t2 = 0;
            $t3 = 0;
            $t4 = 0;
            $t5 = 0;
            $t6 = 0;
            $t7 = 0;
            $t8 = 0;
            $t9 = 0;     
            $t9a = 0;      
            $t10 = 0;
            $t11 = 0;
            ?>
        <?php foreach ($POBLACION_RANGO_EDAD_SEXO_PARENT_FEM_VW as $row): ?>
            <tr>                                
<!--                <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaresum/index?idcliente=".$_POST['idcliente']."&idcontratante=".$_POST['idcontratante']."&idanno=".$_POST['idanno']."&idmes=".$_POST['idmes']."&idestatus=".$_POST['idestatus']."&idcodcross=".$row['CODPARENT_CROSS']."&idrangoedad=0 ") ?>'" /> <?php echo $row['PARENTESCO']; ?></td>-->
                <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaresum/index?mod=PEP"."&idcliente=".$_POST['idcliente']."&idcontratante=".$_POST['idcontratante']."&idanno=".$_POST['idanno']."&idestatus=".$_POST['idestatus']."&idcodcross=".$row['CODPARENT_CROSS']."") ?>'" /> <?php echo $row['PARENTESCO']; ?></td>
                <td class="alignRight"><?php echo format_number($row['DIEZ']); ?></td>
                <td class="alignRight"><?php echo format_number($row['DIESYOCHO']); ?></td>
                <td class="alignRight"><?php echo format_number($row['TREINTAYNUEVE']); ?></td>
                <td class="alignRight"><?php echo format_number($row['CINCUENTAYCINCO']); ?></td>
                <td class="alignRight"><?php echo format_number($row['SESENTAYCINCO']); ?></td>
                <td class="alignRight"><?php echo format_number($row['SETENTA']); ?></td>
                <td class="alignRight"><?php echo format_number($row['OCHENTA']); ?></td>
                <td class="alignRight"><?php echo format_number($row['NOVENTA']); ?></td>
                <td class="alignRight"><?php echo format_number($row['MASNOVENTA']); ?></td>
                <td class="alignRight"><?php echo format_number($row['MASCIEN']); ?></td>
                <td class="alignRight"><strong><?php echo format_number($row['TOTAL']); ?></strong></td>
                <td class="alignRight"><?php echo sprintf("%01.2f", str_replace(",",".",$row['PORC'])); ?> %</td>
            </tr>
            <?php
            $t1 = $t1 + $row['DIEZ'];
            $t2 = $t2 + $row['DIESYOCHO'];
            $t3 = $t3 + $row['TREINTAYNUEVE'];
            $t4 = $t4 + $row['CINCUENTAYCINCO'];
            $t5 = $t5 + $row['SESENTAYCINCO'];
            $t6 = $t6 + $row['SETENTA'];
            $t7 = $t7 + $row['OCHENTA'];
            $t8 = $t8 + $row['NOVENTA'];
            $t9 = $t9 + $row['MASNOVENTA'];  
            $t9a = $t9a + $row['MASCIEN'];          
            $t10 = $t10 + $row['TOTAL'];
            $t11 = $t11 + str_replace(",",".",$row['PORC']);
        ?>
        <?php endforeach; ?>
        
    </tbody>
    <tfoot>
        <tr>
            <td>Total</td>
            <td class="alignRight"><?php echo format_number($t1) ?></td>
            <td class="alignRight"><?php echo format_number($t2) ?></td>
            <td class="alignRight"><?php echo format_number($t3) ?></td>
            <td class="alignRight"><?php echo format_number($t4) ?></td>
            <td class="alignRight"><?php echo format_number($t5) ?></td>
            <td class="alignRight"><?php echo format_number($t6) ?></td>
            <td class="alignRight"><?php echo format_number($t7) ?></td>
            <td class="alignRight"><?php echo format_number($t8) ?></td>
            <td class="alignRight"><?php echo format_number($t9) ?></td>
            <td class="alignRight"><?php echo format_number($t9a) ?></td> 
            <td class="alignRight"><?php echo format_number($t10) ?></td>
            <td class="alignRight"><?php echo format_number($t11) ?></td>
        </tr>
    </tfoot>

</table>


<table class="tableSector">
    <thead>
        <tr>
            <th>Total (Masculino + Femenino)</th>
        </tr>
    </thead>
</table>
<table class="tableSector">
    <thead>
        <tr>
            <th>Rango de edad</th>
            <th>0-10</th>
            <th>11-18</th>
            <th>19-39</th>
            <th>40-55</th>
            <th>56-65</th>
            <th>66-70</th>
            <th>71-80</th>
            <th>81-90</th>
            <th>91-100</th>
            <th>101-Más</th>
            <th>Total</th>
            <th>Participación</th>
        </tr>
    </thead>
    <tbody><?php
            $t1 = 0;
            $t2 = 0;
            $t3 = 0;
            $t4 = 0;
            $t5 = 0;
            $t6 = 0;
            $t7 = 0;
            $t8 = 0;
            $t9 = 0;
            $t9a = 0;
            $t10 = 0;
            $t11 = 0;
            ?>
        <?php foreach ($POBLACION_RANGO_EDAD_SEXO_PARENT_TOT_VW as $row): ?>
            <tr>                                
<!--                <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaresum/index?idcliente=".$_POST['idcliente']."&idcontratante=".$_POST['idcontratante']."&idanno=".$_POST['idanno']."&idmes=".$_POST['idmes']."&idestatus=".$_POST['idestatus']."&idcodcross=".$row['CODPARENT_CROSS']."&idrangoedad=0 ") ?>'" /> <?php echo $row['PARENTESCO']; ?></td>-->
                <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaresum/index?mod=PEP"."&idcliente=".$_POST['idcliente']."&idcontratante=".$_POST['idcontratante']."&idanno=".$_POST['idanno']."&idestatus=".$_POST['idestatus']."&idcodcross=".$row['CODPARENT_CROSS']."") ?>'" /> <?php echo $row['PARENTESCO']; ?></td>
                <td class="alignRight"><?php echo format_number($row['DIEZ']); ?></td>
                <td class="alignRight"><?php echo format_number($row['DIESYOCHO']); ?></td>
                <td class="alignRight"><?php echo format_number($row['TREINTAYNUEVE']); ?></td>
                <td class="alignRight"><?php echo format_number($row['CINCUENTAYCINCO']); ?></td>
                <td class="alignRight"><?php echo format_number($row['SESENTAYCINCO']); ?></td>
                <td class="alignRight"><?php echo format_number($row['SETENTA']); ?></td>
                <td class="alignRight"><?php echo format_number($row['OCHENTA']); ?></td>
                <td class="alignRight"><?php echo format_number($row['NOVENTA']); ?></td>
                <td class="alignRight"><?php echo format_number($row['MASNOVENTA']); ?></td>
                <td class="alignRight"><?php echo format_number($row['MASCIEN']); ?></td>
                <td class="alignRight"><strong><?php echo format_number($row['TOTAL']); ?></strong></td>
                <td class="alignRight"><?php echo sprintf("%01.2f", str_replace(",",".",$row['PORC'])); ?> %</td>
            </tr>
            <?php
            $t1 = $t1 + $row['DIEZ'];
            $t2 = $t2 + $row['DIESYOCHO'];
            $t3 = $t3 + $row['TREINTAYNUEVE'];
            $t4 = $t4 + $row['CINCUENTAYCINCO'];
            $t5 = $t5 + $row['SESENTAYCINCO'];
            $t6 = $t6 + $row['SETENTA'];
            $t7 = $t7 + $row['OCHENTA'];
            $t8 = $t8 + $row['NOVENTA'];
            $t9 = $t9 + $row['MASNOVENTA'];
            $t9a = $t9a + $row['MASCIEN'];
            $t10 = $t10 + $row['TOTAL'];                        
            $t11 = $t11 + str_replace(",",".",$row['PORC']);
        ?>
        <?php endforeach; ?>



    </tbody>
    <tfoot>
        <tr><td>Total</td>            
            <td class="alignRight"><?php echo format_number($t1) ?></td>
            <td class="alignRight"><?php echo format_number($t2) ?></td>
            <td class="alignRight"><?php echo format_number($t3) ?></td>
            <td class="alignRight"><?php echo format_number($t4) ?></td>
            <td class="alignRight"><?php echo format_number($t5) ?></td>
            <td class="alignRight"><?php echo format_number($t6) ?></td>
            <td class="alignRight"><?php echo format_number($t7) ?></td>
            <td class="alignRight"><?php echo format_number($t8) ?></td>
            <td class="alignRight"><?php echo format_number($t9) ?></td>
            <td class="alignRight"><?php echo format_number($t9a) ?></td> 
            <td class="alignRight"><?php echo format_number($t10) ?></td>
            <td class="alignRight"><?php echo $t11 ?></td>
        </tr>
    </tfoot>

</table>

<table class="tableSector">
    <tbody>
        <tr>
            <td class="alignRight">Participación %</td>
            <td class="alignRight"><?php echo format_number($t1) ?></td>
            <td class="alignRight"><?php echo format_number($t2) ?></td>
            <td class="alignRight"><?php echo format_number($t3) ?></td>
            <td class="alignRight"><?php echo format_number($t4) ?></td>
            <td class="alignRight"><?php echo format_number($t5) ?></td>
            <td class="alignRight"><?php echo format_number($t6) ?></td>
            <td class="alignRight"><?php echo format_number($t7) ?></td>
            <td class="alignRight"><?php echo format_number($t8) ?></td>
            <td class="alignRight"><?php echo format_number($t9) ?></td>
            <td class="alignRight"><?php echo format_number($t9a) ?></td> 
            <td class="alignRight"><?php echo format_number($t10) ?></td>
        </tr>
        <tr>
            <td class="alignRight">Acumulada %</td>
            <td class="alignRight"><?php printf("%.2f", ($t1 * 100) / $t10) ?> %</td>
            <td class="alignRight"><?php printf("%.2f", ($t2 * 100) / $t10) ?> %</td>
            <td class="alignRight"><?php printf("%.2f", ($t3 * 100) / $t10) ?> %</td>
            <td class="alignRight"><?php printf("%.2f", ($t4 * 100) / $t10) ?> %</td>
            <td class="alignRight"><?php printf("%.2f", ($t5 * 100) / $t10) ?> %</td>
            <td class="alignRight"><?php printf("%.2f", ($t6 * 100) / $t10) ?> %</td>
            <td class="alignRight"><?php printf("%.2f", ($t7 * 100) / $t10) ?> %</td>
            <td class="alignRight"><?php printf("%.2f", ($t8 * 100) / $t10) ?> %</td>
            <td class="alignRight"><?php printf("%.2f", ($t9 * 100) / $t10) ?> %</td>
            <td class="alignRight"><?php printf("%.2f", ($t9a * 100) / $t10) ?> %</td>
            <td class="alignRight">100 %</td>

        </tr>
    </tbody>
</table>





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

<!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
echo $var = ob_get_clean();
?>

<!-- Formulario para crear pdf-->
<form method="post" id="targetpdf" action="<?php echo url_for('pdfpoblacion/index') ?>" target="_blank" hidden="hidden">
    <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Por rango de edad, parentesco y sexo" />
    <textarea id="text_pdf" name="text" rows="2" cols="20"  >
        <?php echo $var; ?>
    </textarea>
</form>
<!-- fin-->
<!-- Formulario oculto para crear excel-->
<form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
<input id="titulo"  name="titulo" type="text" value="Por rango de edad, parentesco y sexo" />
    <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
</form>
<!-- fin-->

<div class="clear" style="padding-bottom:30px;"></div>

<!-- FIN DEL BACKEND -->
<table class="sectorBottomMenu" >
    <tr>
    <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
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
        //Funcion de submit excel
    $('#url_excel').click(function() {
        $('#targetexcel').submit();
    }); 
</script>