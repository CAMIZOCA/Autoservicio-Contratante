<?php
use_helper('Number');
use_helper('Date');
?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php
error_reporting(E_ALL & ~E_NOTICE);

$mes2 = $mes;
?> 
<script type="text/javascript" src="./js/rgbcolor.js"></script> 
<script type="text/javascript" src="./js/canvg.js"></script>
<script type="text/javascript" src="./js/googlecapturechart.js"></script>
<div id="mainContentSector"><!--end innerwrap--> 
    <div id="innerwrap"> 
        <div id="sideBar">
            <!-- MODULO ACTIVO -->
            <?php include('_modActivo.php'); ?>
            <!-- DEADLINE -->            
            <?php include_partial('poblaconsol/quickDeadlineBox') ?>
            <!-- QUICK RECORD -->
            <?php
            include_partial('poblaconsol/quickUserBox', array(
                'UserName' => $UserName,
                'FirstName' => $FirstName,
                'LastName' => $LastName,
                'CreatedAt' => $CreatedAt
            ))
            ?>      
        </div>
        <div id="contentBar">
            <div class="articleContentSector">
                <!-- BREADCRUMB -->
                <div class="breadcrumbBox">
                    <ul>
                        <li><a href="<?php echo url_for('maindashboard/index') ?>">AutoServicio</a></li>
                        <li><a href="#">Siniestralidad</a></li>
                        <li class="last">Incurrido Vs Pagado y Rendido</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Incurrido Vs Pagado y Rendido</h1>
                <div class="articleBox">
                    <form  id="form1"  name="form1" action="<?php echo url_for('tralidadincurrpagadovsrendid/index') ?>" method="post">
                        <table>                     
                            <tr><td>Cliente: <input type="hidden" id="indicador" name="indicador" value="1"  /></td><td colspan="3"><select id="cliente" name="cliente" onChange="llenar_ano(this.value);">
                                    <option  value="-1"  selected="seleted" > -  Seleccione una opción - </option>
                                    <?php foreach ($CMB_CLIENTE_MVW as $row): ?>
                                        <option value="<?php echo $row['idepol']; ?>" <?php if ($cliente == $row['idepol']) { ?> selected="selected" <?php } ?>> <?php echo $row['descripcion']; ?></option>
                                    <?php endforeach; ?>

                                </select> </td></tr>

                            <tr><td>Año: </td><td colspan="3"><select id="ano" name="ano" onchange="llenar_mes(document.forms.form1.cliente.value,this.value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?>>
                                    <option  value="-1"  selected="seleted" > -  Seleccione una opción - </option>
                                    <?php foreach ($CMB_ANO_GENERAL as $row): ?>
                                        <option value="<?php echo $row['ANOPARAM']; ?>" <?php if ($ano == $row['ANOPARAM'] and trim($indicador) == 1) { ?> selected="selected" <?php } ?> ><?php echo $row['ANOPARAM']; ?></option>
                                    <?php endforeach; ?>                                    
                                </select> </td></tr>
                            <tr><td >Mes: </td><td colspan="3">                          
                                <select id="mes"  name="mes" onchange="fechas_mes(this.value,document.forms.form1.ano.value,'<?php echo $es_bisiesto; ?>');eliminarPais(document.forms.form1.inicio.value,document.forms.form1.fin.value), num_dias(this.value,document.forms.form1.ano.value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?>>
                                    <option  value="-1"  selected="seleted" > -  Seleccione una opción - </option>
                                    <option  value="0"  <?php if ($mes2 == 0) { ?> selected="selected" <?php } ?> > Todos </option>
                                    <?php foreach ($CMB_MES_GENERAL as $row): ?>
                                        <option value="<?php echo $row['MESPARAM']; ?>" <?php if ($mes2 == $row['MESPARAM'] and trim($indicador) == 1) { ?> selected="selected" <?php } ?> ><?php echo $row['MES']; ?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </td>

                            </tr>
                        </table>
                        <div id="habil_fecha" style=" margin-top:10px; margin-bottom:10px; display:none; <?php //if(trim($indicador)!=1){      ?> <?php // }       ?>">
                            <table>    
                                <tr>
                                <td height="21" >Días del Mes:</td>
                                <td height="21" > <input name="dias_mes" id="dias_mes" value="<?php echo $dias_mes; ?>" readonly="true" size="5" /></td>
                                <td  width="90">Días Hábiles:</td>
                                <td ><input name="dias_habiles" id="dias_habiles" value="<?php echo $CantidadDiasHabiles; ?>" readonly="true" size="5" /></td>
                                </tr>


                                <tr>
                                <td height="21" >Fecha Inicio:</td>
                                <td height="21" > <input name="inicio" id="inicio" value="<?php echo $fecha_inicial; ?>" readonly="true" size="10" /></td>
                                <td  width="90">Fecha Fin:</td>
                                <td ><input name="fin" id="fin" value="<?php echo $fecha_final; ?>" readonly="true" size="10" /></td>
                                </tr>    
                            </table>
                        </div>
                        <table style="margin-top:5px;">
                            <tr>
                            <td><input type="submit" class="btn_buscar"  value="Buscar"  /></td>
                            </tr>
                            </tr>
                        </table>
                    </form>
                    <!-- INICIO -->
                    <div class="clear" style="padding-bottom:30px;"></div>
                    <!-- INICIO PANTALLAS BACKEND -->
                    <div id="cargando" style="display: none;"><img src="/images/green-loading.gif" style="text-align: center" />&nbsp;</div> 

                    <div id="showTable" name="show" <?php if (trim($indicador) == '') { ?> style="display:none;"<?php } ?> > 
                        <!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
                        <?php
                        ob_start();
                        ?>
                        <!-- FIN-->     
                        <table class="tableSector" >
                            <thead>
                                <tr align="center">
                                <th align="center">Mes</th>
                                <th width="105">Monto Incurrido Total<br />
                                <span style="font-size:11px;">MIT(Bs)</span></th>
                                <th width="98">Monto Incurrido Acumulado<br />
                                <span style="font-size:11px;">MITA(Bs)</span></th>
                                <th width="102">Monto Incurrido Indemnizado<br />
                                <span style="font-size:11px;">MII(Bs)</span></th>
                                <!--<th width="102">Monto Rendido<br />
                                <span style="font-size:11px;">MIR(Bs)</span></th>
                                <th >%R/I<br />
                                <span style="font-size:11px;"></span></th>
                                <th >%R/MITA<br />
                                <span style="font-size:11px;"></span></th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $var_srcipt = '<script type="text/javascript">
                                  google.load("visualization", "1", {packages:["corechart"]});
                                  google.setOnLoadCallback(drawChart);
                                  function drawChart() {
                                   var data = new google.visualization.DataTable();';
                                $var_srcipt = $var_srcipt . " data.addColumn('string', 'mes');
                                    data.addColumn('number', '');       
                                    data.addColumn('number', 'MII');
                                    data.addColumn('number', 'MITA');
                                    data.addColumn('number', 'MIT');
                                    data.addRows([ ";

                                $total_disponible_saldo = 0;
                                $total_aportes = 0;
                                $total_incurrido_total = 0;
                                foreach ($FONDOS_VW_tabla_inicial as $row_tabla):
                                    $incurrido_indemnizado = str_replace(",", ".", $row_tabla['incurrido_indemnizado']);
                                    $incurrido_acum = str_replace(",", ".", $row_tabla['incurrido_acum']);
                                    $incurrido_total = str_replace(",", ".", $row_tabla['incurrido_total']);

                                    $total_incurrido_acum = $total_incurrido_acum + $incurrido_acum;
                                    $total_incurrido_indemnizado = $total_incurrido_indemnizado + $incurrido_indemnizado;
                                    $total_incurrido_total = $total_incurrido_total + $incurrido_total;
                                    $total_rendido = $total_rendido + 0;
                                endforeach;




                                $mml = 0;

                                if ($cuantos_tabla_inicial != 0) {

                                    foreach ($FONDOS_VW_tabla_inicial as $row_tabla):

                                        $mml++;
                                        $mes_salida = $row_tabla['mesparam'];
                                        switch ($mes_salida) {

                                            case '01':
                                                $mes_tabla = 'Enero ' . $ano;
                                                $mes_grafica = 'Enero ' . $ano;

                                                break;
                                            case '02':
                                                $mes_tabla = 'Febrero ' . $ano;
                                                $mes_grafica = 'Feb ' . $ano;
                                                break;
                                            case '03':
                                                $mes_tabla = 'Marzo ' . $ano;
                                                $mes_grafica = 'Mar ' . $ano;
                                                break;
                                            case '04':
                                                $mes_tabla = 'Abril ' . $ano;
                                                $mes_grafica = 'Abr ' . $ano;
                                                break;
                                            case '05':
                                                $mes_tabla = 'Mayo ' . $ano;
                                                $mes_grafica = 'May ' . $ano;
                                                break;
                                            case '06':
                                                $mes_tabla = 'Junio ' . $ano;
                                                $mes_grafica = 'Jun ' . $ano;
                                                break;
                                            case '07':
                                                $mes_tabla = 'Julio ' . $ano;
                                                $mes_grafica = 'Jul ' . $ano;
                                                break;
                                            case '08':
                                                $mes_tabla = 'Agosto ' . $ano;
                                                $mes_grafica = 'Agos ' . $ano;
                                                break;
                                            case '09':
                                                $mes_tabla = 'Septiembre ' . $ano;
                                                $mes_grafica = 'Sept ' . $ano;
                                                break;
                                            case '10':
                                                $mes_tabla = 'Octubre ' . $ano;
                                                $mes_grafica = 'Oct ' . $ano;
                                                break;
                                            case '11':
                                                $mes_tabla = 'Noviembre ' . $ano;
                                                $mes_grafica = 'Nov ' . $ano;
                                                break;
                                            case '12':
                                                $mes_tabla = 'Diciembre ' . $ano;
                                                $mes_grafica = 'Dic ' . $ano;
                                                break;
                                        }

                                        $aportes = $row_tabla['aportes'];
                                        $cant_incurridos = $row_tabla['cant_incurridos'];
                                        $costo_promedio = $row_tabla['costo_promedio'];

                                        $disponible_fondo = str_replace(",", ".", $row_tabla['disponible_fondo']);
                                        $incurrido_acum = str_replace(",", ".", $row_tabla['incurrido_acum']);
                                        $incurrido_indemnizado = str_replace(",", ".", $row_tabla['incurrido_indemnizado']);
                                        $incurrido_pend_ant = str_replace(",", ".", $row_tabla['incurrido_pend_ant']);
                                        $incurrido_total = str_replace(",", ".", $row_tabla['incurrido_total']);
                                        $saldo_anterior = str_replace(",", ".", $row_tabla['saldo_anterior']);

                                        $incurrido_indemnizado2 = ($incurrido_indemnizado);
                                        $incurrido_acum2 = ($incurrido_acum);
                                        $incurrido_total2 = ($incurrido_total);

                                        $var_srcipt = $var_srcipt . "['" . $mes_grafica . "'," . "0" . "," . $incurrido_indemnizado2 . "," . $incurrido_acum2 . "," . $incurrido_total2 . "]";
                                        if ($mml < $cuantos_tabla_inicial) {

                                            $var_srcipt = $var_srcipt . ",";
                                        }
                                        ?>
                                        <tr>      
                                        <td><div align="left" style=" width:120px; margin-left:10px;" ><?php echo $mes_tabla; ?></div></td>
                                        <td class="alignRight"><?php echo number_format($incurrido_total, 2, ",", "."); ?></td>  
                                        <td class="alignRight"><?php echo number_format($incurrido_acum, 2, ",", "."); ?></td>  
                                        <td class="alignRight"><?php echo number_format($incurrido_indemnizado, 2, ",", "."); ?></td>  
                                        <!--<td class="alignRight"><?php echo number_format(0, 2, ",", "."); ?></td>  
                                        <td class="alignRight"><?php echo number_format(0, 2, ",", "."); ?></td>  
                                        <td class="alignRight"><?php echo number_format(0, 2, ",", "."); ?></td> --> 
                                        </tr>
                                    <?php endforeach; ?>

                                    <?php
                                } else {
                                    ?>
                                    <tr>      
                                    <td><div align="left" style="width:120px; margin-left:10px;" >No existen casos registrados</div></td>                                    
                                    <td class="alignRight"><?php echo number_format(0, 2, ",", "."); ?></td>  
                                    <td class="alignRight"><?php echo number_format(0, 2, ",", "."); ?></td>  
                                    <td class="alignRight"><?php echo number_format(0, 2, ",", "."); ?></td>  
                                    <!--<td class="alignRight"><?php echo number_format(0, 2, ",", "."); ?></td>  
                                    <td class="alignRight"><?php echo number_format(0, 2, ",", "."); ?></td>  
                                    <td class="alignRight"><?php echo number_format(0, 2, ",", "."); ?></td>  -->
                                    </tr>
                                    <?php
                                }



                                $var_srcipt = $var_srcipt . " ]); var options = {
          width: 600, height:400,
          title: 'Incurrido Pagado vs Rendido',
          colors: ['#FFF', '#0B3B17', '#DF0101', '#FFFF00'],
          legendTextStyle: {color:'#666666'},
          vAxis: {title: 'Meses', titleTextStyle: {color: 'black'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      </script> ";
                                ?>         

                            </tbody>
                            <tfoot>
                                <tr style="font-weight:bold;">
                                <td><div align="left" style="margin-left:10px; width:120px;" >Total</div></td>
                                <td class="alignRight"><?php echo number_format($total_incurrido_total, 2, ",", "."); ?></td>                                                   
                                <td class="alignRight"></td>                                                  
                                <td class="alignRight"><?php echo number_format($total_incurrido_indemnizado, 2, ",", "."); ?></td>
                                <!--<td class="alignRight"><?php echo number_format(0, 2, ",", "."); ?></td>                                                   
                                <td class="alignRight"><?php echo number_format(0, 2, ",", "."); ?></td>  
                                <td class="alignRight"><?php echo number_format(0, 2, ",", "."); ?></td> --> 

                                </tr>
                            </tfoot>

                        </table> 
                        <!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
                        <?php
                        echo $var = ob_get_clean();
                        ?>



                        <div style="height:420px; margin-left:20px;" align="left">

                            <div id="chart_div"></div>
                        </div>

                        <!--FIN-->      
                        <!-- Formulario oculto para crear pdf-->
                        <form method="post" id="targetpdf" action="<?php echo url_for('pdf/index') ?>" target="_blank" hidden="hidden">
                            <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Incurrido Vs Pagado y Rendido" />
                            <textarea id="text_pdf" name="text" rows="2" cols="20"  >
                                <?php echo $var; ?>
                            </textarea>
                            <input id="img_grafico"  name="img_grafico" type="text" value="" />
                        </form>
                        <!-- fin-->  

                        <!-- Formulario oculto para crear excel-->
                        <form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
                            <input id="titulo"  name="titulo" type="text" value="Incurrido Vs Pagado y Rendido" />
                            <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
                        </form>
                        <!-- fin-->



                        <hr style="background-color:#E8E8E8; height:2px; border:0;" />


                        <table class="sectorBottomMenu">
                            <tr>
                            <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
                            <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td> 
                            <td><a href="javascript:void(0)" onclick="window.print();" id="url_imprime">Imprimir</a></td>                                
                            </tr>                        
                        </table>
                    </div>                   
                    <div class="clear" style="padding-bottom:30px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
<?php if (trim($indicador) == 1) { ?>
        $(function() {
            $("#cargando").css("display", "inline");
                                 
            setTimeout('document.getElementById(\'cargando\').style.display=\'none\'', 2000);
            return false;
                             
        });
<?php } ?>
</script>
<script type="text/javascript">
    /*$("#url_imprime").click(function (){
$("html").printArea();
})*/
    //    funcion de submit pdf
    $('#url_pdf').click(function() {
        toImg(document.getElementById('chart_div'), document.getElementById('text_ima'));
        $('#targetpdf').submit();
    }); 
    
    //Funcion de submit excel
    $('#url_excel').click(function() {
        $('#targetexcel').submit();
    }); 
</script>
<script>
  
    function llenar_ano(a)
    {
        //alert("MIlaaaaaaaaaaaaaaaaaaaaaaaa"); 
        var n = document.forms.form1.ano.length;

        //alert(a);
        for (var i=0; i<n;++i){      
            document.forms.form1.ano.remove(document.forms.form1.ano.options[i]);//eliminar lineas del 2do combo...
        }
   
        document.forms.form1.ano[0]= new Option(" -  Seleccione una opción  - ",'-1');
        //document.forms.form1.ano[1]= new Option(" Todos ",'todos'); //creamos primera linea del segundo combo

 
<?php
foreach ($CMB_CLIENTE_MVW as $row_c):
    $id_pol = $row_c['idepol'];
    ?> 
                                                   
                        	   	
                if (a== '<?php echo $id_pol; ?>'){

                    // alert("Milaaaaaaaaaaa holaaaaaaaa");
    <?php
    $query = "SELECT ANOPARAM FROM DISPONIBILIDAD_FONDO_VW  J where IDEPOL='$id_pol'
            GROUP BY ANOPARAM ORDER BY ANOPARAM ASC";
    $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
    $stmt2 = $pdo2->prepare($query);
    $stmt2->execute();
    $CMB_ANO_GENERAL = $stmt2->fetchAll();
    foreach ($CMB_ANO_GENERAL as $row_pf):
        $ANOPARAM = $row_pf['ANOPARAM'];
        ?>
                            document.forms.form1.ano[document.forms.form1.ano.length]= new Option("<?php echo $ANOPARAM; ?>",'<?php echo $ANOPARAM; ?>'); 
    <?php endforeach;
    ?>
                                    
                }
<?php endforeach; ?>
 
        document.getElementById('ano').disabled=false;
    }
 
    function llenar_mes(a,b)
    {
        //alert("MIlaaaaaaaaaaaaaaaaaaaaaaaa"); 
        var n = document.forms.form1.mes.length;

        //alert(a);
        for (var i=0; i<n;++i){      
            document.forms.form1.mes.remove(document.forms.form1.mes.options[i]);//eliminar lineas del 2do combo...
        }
   
        document.forms.form1.mes[0]= new Option(" -  Seleccione una opción  - ",'-1');
        document.forms.form1.mes[1]= new Option(" Todos ",'0'); //creamos primera linea del segundo combo

 
<?php
foreach ($CMB_CLIENTE_MVW as $row_c):
    $id_pol = $row_c['idepol'];
    ?> 	
                if (a== '<?php echo $id_pol; ?>'){

    <?php
    $query = "SELECT ANOPARAM FROM DISPONIBILIDAD_FONDO_VW  J where (IDEPOL='$id_pol')
              and (incurrido_pend_ant<>0 or incurrido_total<>0 or incurrido_indemnizado<>0) GROUP BY ANOPARAM ORDER BY ANOPARAM ASC";
    $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
    $stmt2 = $pdo2->prepare($query);
    $stmt2->execute();
    $CMB_ANO = $stmt2->fetchAll();
    foreach ($CMB_ANO as $row_pf):
        $ANOPARAM = $row_pf['ANOPARAM'];
        ?>
                            //alert(b);
                            if (b== '<?php echo $ANOPARAM; ?>'){
                                                        
        <?php
        $query_mes = "SELECT MES, MESPARAM FROM DISPONIBILIDAD_FONDO_VW J where (IDEPOL='$id_pol' AND 
             ANOPARAM='$ANOPARAM')  and (incurrido_pend_ant<>0 or incurrido_total<>0 or incurrido_indemnizado<>0) ORDER BY MESPARAM ASC";
        $pdo_mes = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt_mes = $pdo_mes->prepare($query_mes);
        $stmt_mes->execute();
        $CMB_MES = $stmt_mes->fetchAll();
        foreach ($CMB_MES as $row_mes):
            $MES = $row_mes['MES'];
            $MESPARAM = $row_mes['MESPARAM'];
            ?>
                                        document.forms.form1.mes[document.forms.form1.mes.length]= new Option("<?php echo $MES; ?>",'<?php echo $MESPARAM; ?>'); 
        <?php endforeach;
        ?>
                                                                        
                            }             
    <?php endforeach; ?>  
                }
<?php endforeach; ?>
 
        document.getElementById('mes').disabled=false;
        document.getElementById('habil_fecha').style.display="none";
    }
 

    function fechas_mes(a,y)
    {   //document.getElementById('habil_fecha').style.display="block";
<?php
if (((fmod($ano2, 4) == 0) and (fmod($ano2, 100) != 0)) or (fmod($ano2, 400) == 0)) {
    $bi = 1;
} else {
    $bi = 0;
}
?>
        if (a=='0'){
            document.forms.form1.inicio.value="01-1-"+y;
            document.forms.form1.fin.value="31-12-"+y;
        }

        if (a=='01'){
            document.forms.form1.inicio.value="1-1-"+y;
            document.forms.form1.fin.value="31-1-"+y;
        }
        if (a=='02'){
            document.forms.form1.inicio.value="1-2-"+y;
            if(<?php echo $bi ?>==1){ document.forms.form1.fin.value="29-2-"+y;}
            else{ document.forms.form1.fin.value="28-2-"+y;}
       
        }
        if (a=='03'){
            document.forms.form1.inicio.value="1-3-"+y;
            document.forms.form1.fin.value="31-3-"+y;
        }
      
        if (a=='04'){
            document.forms.form1.inicio.value="1-4-"+y;
            document.forms.form1.fin.value="30-4-"+y;
        }
        if (a=='05'){
            document.forms.form1.inicio.value="1-5-"+y;
            document.forms.form1.fin.value="31-5-"+y;
        }
        if (a=='06'){
            document.forms.form1.inicio.value="1-06-"+y;
            document.forms.form1.fin.value="30-6-"+y;
        }
        if (a=='07'){
            document.forms.form1.inicio.value="1-7-"+y;
            document.forms.form1.fin.value="31-7-"+y;
        }
        if (a=='08'){
            document.forms.form1.inicio.value="1-8-"+y;
            document.forms.form1.fin.value="31-8-"+y;
        }
        if (a=='09'){
            document.forms.form1.inicio.value="1-9-"+y;
            document.forms.form1.fin.value="30-9-"+y;
        }
        if (a=='10'){
            document.forms.form1.inicio.value="1-10-"+y;
            document.forms.form1.fin.value="31-10-"+y;
        }
        if (a=='11'){
            document.forms.form1.inicio.value="1-11-"+y;
            document.forms.form1.fin.value="30-11-"+y;
        }
        if (a=='12'){
            document.forms.form1.inicio.value="1-12-"+y;
            document.forms.form1.fin.value="31-12-"+y;
        }
    
    }
</script>
<?php
if ($cuantos_tabla_inicial != 0) {
    echo $var_srcipt;
    ;
}
?>
