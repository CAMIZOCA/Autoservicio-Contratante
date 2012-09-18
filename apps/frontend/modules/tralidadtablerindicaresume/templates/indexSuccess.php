<?php
use_helper('Number');
use_helper('Date');
?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php
//error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);
$tipo_reporte = $sf_params->get('tr');

function DiasHabiles($fecha_inicial, $fecha_final) {
    list($dia, $mes, $year) = explode("-", $fecha_inicial);
    $ini = mktime(0, 0, 0, $mes, $dia, $year);
    list($diaf, $mesf, $yearf) = explode("-", $fecha_final);
    $fin = mktime(0, 0, 0, $mesf, $diaf, $yearf);

    $r = 1;
    while ($ini != $fin) {
        $ini = mktime(0, 0, 0, $mes, $dia + $r, $year);
        $newArray[] .=$ini;
        $r++;
    }
    return $newArray;
}

function Evalua($arreglo) {
    $feriados = array(
        '1-1', //  Año Nuevo (irrenunciable)
        '6-4', //  Viernes Santo (feriado religioso)
        '7-4', //  Sábado Santo (feriado religioso)
        '1-5', //  Día Nacional del Trabajo (irrenunciable)
        '21-5', //  Día de las Glorias Navales
        '29-6', //  San Pedro y San Pablo (feriado religioso)
        '16-7', //  Virgen del Carmen (feriado religioso)
        '15-8', //  Asunción de la Virgen (feriado religioso)
        '18-9', //  Día de la Independencia (irrenunciable)
        '19-9', //  Día de las Glorias del Ejército
        '12-10', //  Aniversario del Descubrimiento de América
        '31-10', //  Día Nacional de las Iglesias Evangélicas y Protestantes (feriado religioso)
        '1-11', //  Día de Todos los Santos (feriado religioso)
        '8-12', //  Inmaculada Concepción de la Virgen (feriado religioso)
        '13-12', //  elecciones presidencial y parlamentarias (puede que se traslade al domingo 13)
        '25-12', //  Natividad del Señor (feriado religioso) (irrenunciable)
    );

    $j = count($arreglo);

    for ($i = 0; $i <= $j; $i++) {
        $dia = $arreglo[$i];

        $fecha = getdate($dia);
        $feriado = $fecha['mday'] . "-" . $fecha['mon'];
        if ($fecha["wday"] == 0 or $fecha["wday"] == 6) {
            $dia_++;
        } elseif (in_array($feriado, $feriados)) {
            $dia_++;
        }
    }
    $rlt = $j - $dia_;
    return $rlt;
}

function mostrarMonto($var_monto) {
    $var_monto = str_replace(",", ".", $var_monto);
    $var_monto = number_format($var_monto, 2, ",", ".");
    echo $var_monto;
}

function UltimoDia($anho, $mes) {
    if (((fmod($anho, 4) == 0) and (fmod($anho, 100) != 0)) or (fmod($anho, 400) == 0)) {
        $dias_febrero = 29;
    } else {
        $dias_febrero = 28;
    }
    switch ($mes) {
        case 01: return 31;
            break;
        case 02: return $dias_febrero;
            break;
        case 03: return 31;
            break;
        case 04: return 30;
            break;
        case 05: return 31;
            break;
        case 06: return 30;
            break;
        case 07: return 31;
            break;
        case 08: return 31;
            break;
        case 09: return 30;
            break;
        case 10: return 31;
            break;
        case 11: return 30;
            break;
        case 12: return 31;
            break;
    }
}

$CantidadDiasHabiles = Evalua(DiasHabiles($fecha_inicial, $fecha_final));


foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):

    $cantidad_total_casos = $cantidad_total_casos + $row_tabla['cantidad'];
    $monto_total = $monto_total + $row_tabla['total'];

endforeach;
$monto_total = $monto_total;

if ($cuantos_tabla_inicial != 0) {
    $costo_promedio_caso = $monto_total / $cantidad_total_casos;
} else {
    $costo_promedio_caso = 0;
}

if ($cuantos_tabla_inicial != 0) {
    $promedio_casos_prov = $cantidad_total_casos / $total_proveedores;
} else {
    $promedio_casos_prov = 0;
}
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
                        <li class="last"><?php
            if (trim($tipo_reporte) == '') {
                echo "Tablero de Indicadores Resumen";
            } elseif (trim($tipo_reporte) == '1') {
                echo "Tendencia de número de casos/ persona (mensual)";
            } elseif (trim($tipo_reporte) == '2') {
                echo "Tendencia Costo Promedio por Mes";
            } elseif (trim($tipo_reporte) == '4') {
                echo "Tendencia de Ahorro mensual";
            } elseif (trim($tipo_reporte) == '5') {
                echo "Tendencia Honorarios versus Incurrido total mensual";
            }
            ?></li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle"><?php
                            if (trim($tipo_reporte) == '') {
                                echo "Tablero de Indicadores Resumen por Mes y/o con Evoluciones Mensuales";
                            } elseif (trim($tipo_reporte) == '1') {
                                echo "Tendencia de número de casos/ persona (mensual)";
                            } elseif (trim($tipo_reporte) == '2') {
                                echo "Tendencia Costo Promedio por Mes";
                            } elseif (trim($tipo_reporte) == '4') {
                                echo "Tendencia de Ahorro mensual";
                            } elseif (trim($tipo_reporte) == '5') {
                                echo "Tendencia Honorarios versus Incurrido total mensual";
                            }
            ?>													
                </h1>
                <div class="articleBox">
                    <form  id="form1"  name="form1" action="<?php echo url_for('tralidadtablerindicaresume/index') ?>" method="post">
                        <table>                     
                            <tr><td>Cliente: <input type="hidden" id="indicador" name="indicador" value="1"  /><input type="hidden" id="tr" name="tr" value="<?php echo $tipo_reporte; ?>"  /></td><td colspan="3"><select id="cliente" name="cliente" onChange="llenar_ano(this.value);">
                                    <option  value="-1"  selected="seleted" > -  Seleccione una opción - </option>
                                    <?php foreach ($CMB_CLIENTE_MVW as $row): ?>
                                        <option value="<?php echo $row['idepol']; ?>" <?php if ($cliente == $row['idepol']) { ?> selected="selected" <?php } ?>> <?php echo $row['descripcion']; ?></option>
                                    <?php endforeach; ?>

                                </select> </td></tr>

                            <tr><td>Año: </td><td colspan="3"><select id="ano" name="ano" onchange="fechas_mes('0',document.forms.form1.ano.value,'<?php echo $es_bisiesto; ?>');eliminarPais(document.forms.form1.inicio.value,document.forms.form1.fin.value), num_dias(this.value,document.forms.form1.ano.value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?>>
                                    <option  value="-1"  selected="seleted" > -  Seleccione una opción - </option>
                                    <?php foreach ($CMB_ANO_GENERAL as $row): ?>
                                        <option value="<?php echo $row['ANOPARAM']; ?>" <?php if ($ano == $row['ANOPARAM'] and trim($indicador) == 1) { ?> selected="selected" <?php } ?> ><?php echo $row['ANOPARAM']; ?></option>
                                    <?php endforeach; ?>                                    
                                </select> </td></tr>

                        </table>
                        <div id="habil_fecha" style=" margin-top:10px; margin-bottom:10px; display:none; <?php //if(trim($indicador)!=1){    ?> <?php //}     ?>">
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
                    <div id="showTable" name="show" <?php if (trim($indicador) == '') { ?> style="display:none;"<?php } ?> > 
                        <!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
                        <?php
                        ob_start();
                        ?>
                        <!-- FIN-->    

                        <table  class="tableSectorSmall">
                            <thead>
                                <tr >
                                <th  >&nbsp;</th>
                                <th >&nbsp;</th>
                                <th  >Enero</th>
                                <th  >Febrero</th>
                                <th >Marzo</th>
                                <th >Abril</th>
                                <th >Mayo</th>
                                <th >Junio</th>
                                <th >Julio</th>
                                <th >Agosto</th>
                                <th >Septiembre</th>
                                <th >Octubre</th>
                                <th >Noviembre</th>
                                <th >Diciembre</th>
                                <th >Total Acumulado</th>
                                <th >Total Promedio/Mes</th>                                                                                       
                                </tr>
                                <tr >
                                <th >Resumen</th>
                                <th >Leyenda</th>
                                <th >Mes 1</th>
                                <th >Mes 2</th>
                                <th >Mes 3 </th>
                                <th >Mes 4</th>
                                <th >Mes 5</th>
                                <th >Mes 6</th>
                                <th >Mes 7</th>
                                <th >Mes 8</th>
                                <th >Mes 9</th>
                                <th >Mes 10</th>
                                <th >Mes 11</th>
                                <th >Mes 12</th>
                                <th >&nbsp;</th>
                                <th >&nbsp;</th>
                                </tr>
                            </thead>

                            <?php
                            if (trim($tipo_reporte) == '1') {
                                $var_srcipt = '<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
       var data = new google.visualization.DataTable();';
                                $var_srcipt = $var_srcipt . " data.addColumn('string', 'mes');
        data.addColumn('number', 'N°C/P');       
        data.addColumn('number', 'N°Cprom/P');        
        data.addRows([";
                            }

                            if (trim($tipo_reporte) == '2') {
                                $var_srcipt = '<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
       var data = new google.visualization.DataTable();';
                                $var_srcipt = $var_srcipt . " data.addColumn('string', 'mes');
        data.addColumn('number', 'CP/C Bs');       
        data.addColumn('number', 'CPA/C Bs');        
        data.addRows([";
                            }

                            $mil = 0;
                            $mil2 = 0;
                            if ($cuantos_tabla_inicial != 0) {

                                //if(trim($tipo_reporte)=='1'){  
                                /* $total_incurridos_gra=0;
                                  $total_personas_afectadas_gra=0; */
                                foreach ($FONDOS_VW_tabla_inicial as $row_tabla):
                                    $mil2++;

                                    $cant_incurridos[$mil2] = $row_tabla['cant_incurridos'];
                                    // echo "cantidad_incurrido ".$cant_incurridos[$mil2];

                                    $total_incurridos_gra = $total_incurridos_gra + $cant_incurridos[$mil2];
                                    //echo "cantidad_incurrido ".$cant_incurridos[$mil2];
                                    $mesparam[$mil2] = $row_tabla['mesparam'];
                                    $anoparam[$mil2] = $row_tabla['anoparam'];


                                    $fecha_ini = '1-1-' . $anoparam[$mil2];
                                    $fecha_fin = '31-12-' . $anoparam[$mil2];



                                    if ($contratante != 'todos') {

                                        $q_aten = Doctrine_Query::create()
                                                ->select('ci_paciente')
                                                ->from('SINIESTRALIDAD_VW   J')
                                                ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                                                and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                                                and idepol='$cliente'                                                                
                                                                and codexterno='$contratante'")
                                                ->groupBy('(ci_paciente, id)');
                                        //echo $q_aten."<br />";
                                        $q_aten->fetchArray();
                                        $personas_afectadas[$mil2] = $q_aten->count();
                                    } else {

                                        $q_aten = Doctrine_Query::create()
                                                ->select('ci_paciente')
                                                ->from('SINIESTRALIDAD_VW   J')
                                                ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                                                    and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                                                    and idepol='$cliente' ")
                                                ->groupBy('(ci_paciente, id)');
                                        // echo $q_aten."<br />";


                                        $q_aten->fetchArray();
                                        $personas_afectadas[$mil2] = $q_aten->count();
                                    }


                                    $incurrido_total[$mil2] = $row_tabla['incurrido_total'];
                                    $ahorro[$mil2] = $row_tabla['ahorro'];


                                    if ($cant_incurridos[$mil2] != 0) {
                                        $siniestros_promedios[$mil2] = $incurrido_total[$mil2] / $cant_incurridos[$mil2];
                                    } else {
                                        $siniestros_promedios[$mil2] = 0;
                                    }
                                    //  echo "Persoans afectadas".$personas_afectadas[$mil2];
                                    //$total_personas_afectadas_gra=$total_personas_afectadas_gra +$personas_afectadas[$mil2];
                                    $total_siniestros_prom_gra = $total_siniestros_prom_gra + $siniestros_promedios[$mil2];

                                endforeach;

                                $total_casos_prom_perso_graf = $total_incurridos_gra / $personas_afectadas[$mil2];
                                //  echo "cantidad_incurrido ".$total_incurridos_gra;
                                //echo "Totaaaaaaaaaaal".$total_graf;
                                //}

                                foreach ($FONDOS_VW_tabla_inicial as $row_tabla):
                                    $mil++;

                                    $mes_salida[$mil] = $row_tabla['mesparam'];
                                    switch ($mes_salida[$mil]) {

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
                                    $aportes[$mil] = $row_tabla['aportes'];
                                    $cant_incurridos[$mil] = $row_tabla['cant_incurridos'];
                                    // echo $mil ." - ".$cuantos_tabla_inicial." - ".$cant_incurridos[$mil]."<br />";
                                    $costo_promedio[$mil] = $row_tabla['costo_promedio'];

                                    $disponible_fondo[$mil] = $row_tabla['disponible_fondo'];
                                    $incurrido_acum[$mil] = $row_tabla['incurrido_acum'];
                                    $incurrido_indemnizado[$mil] = $row_tabla['incurrido_indemnizado'];
                                    $incurrido_pend_ant[$mil] = $row_tabla['incurrido_pend_ant'];
                                    $incurrido_total[$mil] = $row_tabla['incurrido_total'];
                                    $saldo_anterior[$mil] = $row_tabla['saldo_anterior'];
                                    $mesparam[$mil] = $row_tabla['mesparam'];
                                    $anoparam[$mil] = $row_tabla['anoparam'];
                                    $ahorro[$mil] = $row_tabla['ahorro'];
                                    $monto_rendido[$mil] = $row_tabla['monto_rendido'];
                                    $honorarios_hmo[$mil] = $row_tabla['honorarios_hmo'];
                                    $estimados_teoricos[$mil] = $row_tabla['estimado_teorico'];



                                    if ($cant_incurridos[$mil] != 0) {
                                        $siniestros_promedios[$mil] = $incurrido_total[$mil] / $cant_incurridos[$mil];
                                    } else {
                                        $siniestros_promedios[$mil] = 0;
                                    }



                                    $total_disponible_saldo = $total_disponible_saldo + $disponible_fondo[$mil];
                                    $total_saldo_anterior = $total_saldo_anterior + $saldo_anterior[$mil];
                                    $total_aportes = $total_aportes + $aportes[$mil];
                                    $total_cant_incurridos = $total_cant_incurridos + $cant_incurridos[$mil];
                                    $total_incurrido_total = $total_incurrido_total + $incurrido_total[$mil];
                                    $total_incurrido_acum = $total_incurrido_acum + $incurrido_acum[$mil];
                                    $total_incurrido_pend_ant = $total_incurrido_pend_ant + str_replace(",", ".", $incurrido_pend_ant[$mil]);
                                    $total_incurrido_indemnizado = $total_incurrido_indemnizado + $incurrido_indemnizado[$mil];
                                    $incurrido_est_teorico[$mil] = $total_incurrido_total / $estimados_teoricos[$mil];
                                    $ahorro_vs_indenizado[$mil] = $ahorro[$mil] / $total_incurrido_indemnizado;


                                    switch ($mesparam[$mil]) {
                                        case '0':
                                            $fecha_ini = '01-01-' . $anoparam[$mil];
                                            $fecha_fin = '31-12-' . $anoparam[$mil];
                                            $num_dia_mes = '365';
                                            /* if($es_bisiesto==0){
                                              $mes_num
                                              } */
                                            $mes_num = '';
                                            break;
                                        case '01':
                                            $fecha_ini = '01-01-' . $anoparam[$mil];
                                            $fecha_fin = '31-01-' . $anoparam[$mil];
                                            $num_dia_mes = '31';
                                            $mes_num = '01';
                                            break;
                                        case '02':
                                            //echo $ano;
                                            if (((fmod($anoparam[$mil], 4) == 0) and (fmod($anoparam[$mil], 100) != 0)) or (fmod($anoparam[$mil], 400) == 0)) {
                                                $fecha_ini = '10-2-' . $anoparam[$mil];
                                                $fecha_fin = '29-02-' . $anoparam[$mil];
                                                $num_dia_mes = '29';
                                                $mes_num = '02';
                                            } else {
                                                $fecha_ini = '01-02-' . $anoparam[$mil];
                                                $fecha_fin = '28-02-' . $anoparam[$mil];
                                                $num_dia_mes = '28';
                                                $mes_num = '02';
                                            }
                                            break;
                                        case '03':
                                            $fecha_ini = '01-03-' . $anoparam[$mil];
                                            $fecha_fin = '31-03-' . $anoparam[$mil];
                                            $num_dia_mes = '31';
                                            $mes_num = '03';
                                            break;
                                        case '04':
                                            $fecha_ini = '01-04-' . $anoparam[$mil];
                                            $fecha_fin = '30-04-' . $anoparam[$mil];
                                            $num_dia_mes = '30';
                                            $mes_num = '04';
                                            break;
                                        case '05':
                                            $fecha_ini = '01-05-' . $anoparam[$mil];
                                            $fecha_fin = '31-05-' . $anoparam[$mil];
                                            $num_dia_mes = '31';
                                            $mes_num = '05';
                                            break;
                                        case '06':
                                            $fecha_ini = '01-06-' . $anoparam[$mil];
                                            $fecha_fin = '30-06-' . $anoparam[$mil];
                                            $num_dia_mes = '30';
                                            $mes_num = '06';
                                            break;
                                        case '07':
                                            $fecha_ini = '01-07-' . $anoparam[$mil];
                                            $fecha_fin = '31-07-' . $anoparam[$mil];
                                            $num_dia_mes = '31';
                                            $mes_num = '07';
                                            break;
                                        case '08':
                                            $fecha_ini = '01-08-' . $anoparam[$mil];
                                            $fecha_fin = '31-08-' . $anoparam[$mil];
                                            $num_dia_mes = '31';
                                            $mes_num = '08';
                                            break;
                                        case '09':
                                            //echo "mila paso  ";
                                            $mes_num = '09';
                                            //echo $mes_num; 
                                            $fecha_ini = '01-09-' . $anoparam[$mil];
                                            $fecha_fin = '30-09-' . $anoparam[$mil];
                                            $num_dia_mes = '30';
                                            break;
                                        case '10':
                                            $fecha_ini = '01-10-' . $anoparam[$mil];
                                            $fecha_fin = '31-10-' . $anoparam[$mil];
                                            $num_dia_mes = '31';
                                            $mes_num = '10';
                                            break;
                                        case '11':
                                            $fecha_ini = '01-11-' . $anoparam[$mil];
                                            $fecha_fin = '30-11-' . $anoparam[$mil];
                                            $num_dia_mes = '30';
                                            $mes_num = '11';
                                            break;
                                        case '12':
                                            $fecha_ini = '01-12-' . $anoparam[$mil];
                                            $fecha_fin = '31-12-' . $anoparam[$mil];
                                            $mes_num = '12';
                                            $num_dia_mes = '31';
                                            break;
                                    }


                                    if ($cuantos_tabla_inicial > 1) {

                                        if ($contratante != 'todos') {

                                            $q_aten = Doctrine_Query::create()
                                                    ->select('ci_paciente')
                                                    ->from('SINIESTRALIDAD_VW   J')
                                                    ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                                                and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                                                and idepol='$cliente'                                                                
                                                                and codexterno='$contratante'")
                                                    ->groupBy('(ci_paciente, id)');
                                            //echo $q_aten."<br />";
                                            $q_aten->fetchArray();
                                            $personas_afectadas[$mil] = $q_aten->count();

                                            $q_titulares = Doctrine_Query::create()
                                                    ->select('COUNT(ci_paciente) AS cantidad_titular ')
                                                    ->from('SINIESTRALIDAD_VW   J')
                                                    ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                                                and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                                                and idepol='$cliente'                                                                
                                                                and codexterno='$contratante'
                                                                and (parentesco='TITULAR FEMENINO' or parentesco='TITULAR MASCULINO')
                                                               ");


                                            $row_titulares = $q_titulares->fetchArray();
                                            foreach ($row_titulares as $row):
                                                $cantidad_titular[$mil] = $row['cantidad_titular'];
                                            endforeach;

                                            $q_titulares = Doctrine_Query::create()
                                                    ->select('COUNT(ci_paciente) AS cantidad_titular ')
                                                    ->from('SINIESTRALIDAD_VW   J')
                                                    ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                                                and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                                                and idepol='$cliente'                                                                
                                                                and codexterno='$contratante'
                                                                and parentesco<>'TITULAR FEMENINO' 
                                                                and  parentesco<>'TITULAR MASCULINO'
                                                               ");

                                            $row_notitulares = $q_titulares->fetchArray();

                                            foreach ($row_notitulares as $row):
                                                $cantidad_notitular[$mil] = $row['cantidad_titular'];
                                            endforeach;
                                        }
                                        else {

                                            $q_aten = Doctrine_Query::create()
                                                    ->select('ci_paciente')
                                                    ->from('SINIESTRALIDAD_VW   J')
                                                    ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                                                    and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                                                    and idepol='$cliente' ")
                                                    ->groupBy('(ci_paciente, id)');
                                            //echo $q_aten."<br />";


                                            $q_aten->fetchArray();

                                            $personas_afectadas[$mil] = $q_aten->count();

                                            $q_titulares = Doctrine_Query::create()
                                                    ->select('COUNT(ci_paciente) AS cantidad_titular ')
                                                    ->from('SINIESTRALIDAD_VW   J')
                                                    ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                                                and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                                                and idepol='$cliente' 
                                                                and (parentesco='TITULAR FEMENINO' or parentesco='TITULAR MASCULINO')
                                                               ");
                                            //echo $q_titulares;
                                            $row_titulares = $q_titulares->fetchArray();
                                            $row_titulares = $q_titulares->fetchArray();
                                            foreach ($row_titulares as $row):
                                                $cantidad_titular[$mil] = $row['cantidad_titular'];
                                            endforeach;

                                            $q_titulares = Doctrine_Query::create()
                                                    ->select('COUNT(ci_paciente) AS cantidad_titular ')
                                                    ->from('SINIESTRALIDAD_VW   J')
                                                    ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                                                and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                                                and idepol='$cliente'
                                                                and parentesco<>'TITULAR FEMENINO' 
                                                                and  parentesco<>'TITULAR MASCULINO'
                                                               ");
                                            //echo $q_titulares;
                                            $row_notitulares = $q_titulares->fetchArray();

                                            foreach ($row_notitulares as $row):
                                                $cantidad_notitular[$mil] = $row['cantidad_titular'];
                                            endforeach;
                                        }
                                    }
                                    else {
                                        $personas_afectadas[$mil] = 1;
                                    }

                                    if (trim($tipo_reporte) == '1') {

                                        if ($personas_afectadas[$mil] != 0) {
                                            $num_casos_persona[$mil] = $cant_incurridos[$mil] / $personas_afectadas[$mil];
                                        } else {
                                            $num_casos_persona[$mil] = 0;
                                        }
                                        $num_casos_persona_graf = $num_casos_persona[$mil];

                                        if ($cant_incurridos[$mil] != 0) {


                                            $var_srcipt = $var_srcipt . "['" . $mes_grafica . "'," . $num_casos_persona_graf . "," . $total_casos_prom_perso_graf . "]";
                                            if ($mil < $cuantos_tabla_inicial) {

                                                $var_srcipt = $var_srcipt . ",";
                                            }
                                        }
                                    }

                                    if (trim($tipo_reporte) == '2') {
                                        if ($siniestros_promedios[$mil] != 0) {
                                            $mila = "aquiiiii paso";


                                            $var_srcipt = $var_srcipt . "['" . $mes_grafica . "'," . $siniestros_promedios[$mil] . "," . $total_siniestros_prom_gra . "]";
                                            if ($mil < $cuantos_tabla_inicial) {

                                                $var_srcipt = $var_srcipt . ",";
                                            }
                                        }
                                    }
                                endforeach;
                            }
                            ?>

                            <tbody>
<?php if (trim($tipo_reporte) == '') { ?>

                                    <?php
                                }
                                if (trim($tipo_reporte) == '') {
                                    ?>
                                    <tr>      

                                    <td align="left" style="padding:5px; margin-left:15px;  font-weight:bold;"> Estimados Teóricos Bs</td>
                                    <td align="center" style="padding:5px; font-weight:bold;"> ET Bs</td>
                                    <td class="alignRight">
    <?php
    $si_es = '0';
    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
        if ($mes_salida[$i] == '01') {
            $monto = str_replace(",", ".", $estimados_teoricos[$i]);
            echo number_format($monto, 2, ",", ".");
            $si_es = '1';
        }
    } if ($si_es == '0') {
        echo "0,00";
    }
    ?>
                                    </td>
                                    <td class="alignRight">
                                        <?php
                                        $si_es = '0';
                                        for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                            if ($mes_salida[$i] == '02') {
                                                $monto = str_replace(",", ".", $estimados_teoricos[$i]);
                                                echo number_format($monto, 2, ",", ".");
                                                //echo $estimados_teoricos[$i];
                                                $si_es = '1';
                                            }
                                        } if ($si_es == '0') {
                                            echo "0,00";
                                        }
                                        ?>
                                    </td>
                                    <td class="alignRight">
                                        <?php
                                        $si_es = '0';
                                        for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                            if ($mes_salida[$i] == '03') {
                                                $monto = str_replace(",", ".", $estimados_teoricos[$i]);
                                                echo number_format($monto, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        } if ($si_es == '0') {
                                            echo "0,00";
                                        }
                                        ?>
                                    </td>
                                    <td class="alignRight"> <?php
                                        $si_es = '0';
                                        for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                            if ($mes_salida[$i] == '04') {
                                                $monto = str_replace(",", ".", $estimados_teoricos[$i]);
                                                echo number_format($monto, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        } if ($si_es == '0') {
                                            echo "0,00";
                                        }
                                        ?> </td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {

                                            $monto = str_replace(",", ".", $estimados_teoricos[$i]);
                                            echo number_format($monto, 2, ",", ".");

                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"> <?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            $monto = str_replace(",", ".", $estimados_teoricos[$i]);
                                            echo number_format($monto, 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"> <?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            $monto = str_replace(",", ".", $estimados_teoricos[$i]);
                                            echo number_format($monto, 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"> <?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            $monto = str_replace(",", ".", $estimados_teoricos[$i]);
                                            echo number_format($monto, 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            $monto = str_replace(",", ".", $estimados_teoricos[$i]);
                                            echo number_format($monto, 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"> <?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            $monto = str_replace(",", ".", $estimados_teoricos[$i]);
                                            echo number_format($monto, 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"> <?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            $monto = str_replace(",", ".", $estimados_teoricos[$i]);
                                            echo number_format($monto, 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"> <?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            $monto = str_replace(",", ".", $estimados_teoricos[$i]);
                                            echo number_format($monto, 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                    ?> </td>
                                    <td class="alignRight"> <?php
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        $total_estimados_teoricos = $total_estimados_teoricos + str_replace(",", ".", $estimados_teoricos[$i]);
                                    }
                                    //echo $total_estimados_teoricos;
                                    echo number_format($total_estimados_teoricos, 2, ",", ".");
                                    ?> 
                                    </td>
                                    <td class="alignRight"><?php echo number_format($total_estimados_teoricos / 12) ?></td>
                                    </tr>
                                        <?php
                                    }
                                    if (trim($tipo_reporte) == '') {
                                        ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;" >Total Incurrido Bs </td>
                                    <td align="center" style="padding:5px; font-weight:bold;">TI Bs</td>
                                    <td class="alignRight"> <?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01') {

                                            mostrarMonto($incurrido_total[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?>
                                    </td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            mostrarMonto($incurrido_total[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            mostrarMonto($incurrido_total[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"> <?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            mostrarMonto($incurrido_total[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            mostrarMonto($incurrido_total[$i]);                                            
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"> <?php
                                    
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            mostrarMonto($incurrido_total[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"> <?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            mostrarMonto($incurrido_total[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"> <?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            mostrarMonto($incurrido_total[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"> <?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            mostrarMonto($incurrido_total[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?> </td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            mostrarMonto($incurrido_total[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            mostrarMonto($incurrido_total[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            mostrarMonto($incurrido_total[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        $t_incurrido_total = $t_incurrido_total + str_replace(",", ".", $incurrido_total[$i]);
                                        
                                    }

                                    echo number_format($t_incurrido_total, 2, ",", ".");
                                        ?></td>
                                    <td class="alignRight"><?php
                                echo number_format($t_incurrido_total / $cuantos_tabla_inicial, 2, ",", ".");
                                ?></td>
                                    </tr>
                                        <?php
                                    }
                                    if (trim($tipo_reporte) == '') {
                                        ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">N° de casos</td>
                                    <td align="center" style="padding:5px; font-weight:bold;">N° C </td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01') {
                                            echo number_format($cant_incurridos[$i], 2, ",", ".");

                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            echo number_format($cant_incurridos[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            echo number_format($cant_incurridos[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            echo number_format($cant_incurridos[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            echo number_format($cant_incurridos[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            echo number_format($cant_incurridos[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            echo number_format($cant_incurridos[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            echo number_format($cant_incurridos[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            echo number_format($cant_incurridos[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            echo number_format($cant_incurridos[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            echo number_format($cant_incurridos[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            echo number_format($cant_incurridos[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                    ?></td>
                                    <td class="alignRight"><?php
                                    echo number_format($total_cant_incurridos, 2, ",", ".");
                                        ?></td>
                                    <td class="alignRight"><?php
                                echo number_format($total_cant_incurridos / $cuantos_tabla_inicial, 2, ",", ".");
                                ?></td>
                                    </tr>
                                        <?php
                                    }
                                    if (trim($tipo_reporte) == '' or trim($tipo_reporte) == '2') {
                                        ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;"><?php
                                    if (trim($tipo_reporte) != '2') {
                                        echo "Siniestros Promedio Bs/C";
                                    } else {
                                        echo "Costo Promedio/Caso Bs";
                                    }
                                        ?> </td>
                                    <td align="center" style="padding:5px; font-weight:bold;"><?php
                                    if (trim($tipo_reporte) != '2') {
                                        echo "SP";
                                    } else {
                                        echo "CP/C Bs";
                                    }
                                        ?> </td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");

                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                    ?></td>
                                    <td class="alignRight"><?php
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        $t_siniestros_promedios = $t_siniestros_promedios + $siniestros_promedios[$i];
                                    }
                                    echo number_format($t_siniestros_promedios, 2, ",", ".");
                                    ?></td>
                                    <td class="alignRight"><?php
                                    echo number_format($t_siniestros_promedios / 12, 2, ",", ".");
                                    ?></td>
                                    </tr>
<?php } ?>





                                    <?php if (trim($tipo_reporte) == '2') { ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">Costo Promedio Acumulado/Caso Bs</td>
                                    <td align="center" style="padding:5px; font-weight:bold;">CPA/C Bs</td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01' and $siniestros_promedios[$i] != '0') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02' and $siniestros_promedios[$i] != '0') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03' and $siniestros_promedios[$i] != '0') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04' and $siniestros_promedios[$i] != '0') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05' and $siniestros_promedios[$i] != '0') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06' and $siniestros_promedios[$i] != '0') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07' and $siniestros_promedios[$i] != '0') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08' and $siniestros_promedios[$i] != '0') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09' and $siniestros_promedios[$i] != '0') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10' and $siniestros_promedios[$i] != '0') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11' and $siniestros_promedios[$i] != '0') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12' and $siniestros_promedios[$i] != '0') {
                                            echo number_format($siniestros_promedios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                echo number_format($t_siniestros_promedios, 2, ",", ".");
                                ?></td>
                                    <td class="alignRight"><?php echo number_format($t_siniestros_promedios / 12, 2, ",", "."); ?></td>
                                    </tr>
                                        <?php
                                    }
                                    if (trim($tipo_reporte) == '') {
                                        ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">N° de personas afectadas </td>
                                    <td align="center" style="padding:5px; font-weight:bold;"> N° PA <?php echo $mila; ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01') {
                                            echo number_format($personas_afectadas[$i], 2, ",", ".");

                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            echo number_format($personas_afectadas[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            echo number_format($personas_afectadas[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            echo number_format($personas_afectadas[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            echo number_format($personas_afectadas[$i], 2, ",", ".");

                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            echo number_format($personas_afectadas[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            echo number_format($personas_afectadas[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            echo number_format($personas_afectadas[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            echo number_format($personas_afectadas[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            echo number_format($personas_afectadas[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            echo number_format($personas_afectadas[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            echo number_format($personas_afectadas[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        $total_personas_afectadas = $total_personas_afectadas + $personas_afectadas[$i];
                                    }

                                    echo number_format($total_personas_afectadas, 2, ",", ".");
                                    ?></td>
                                    <td class="alignRight"><?php echo number_format($total_personas_afectadas / $cuantos_tabla_inicial, 2, ",", "."); ?></td>
                                    </tr>
    <?php
}
if (trim($tipo_reporte) == '' or trim($tipo_reporte) == '1') {
    ?>
                                    <tr>

                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">N° de casos/personas </td>
                                    <td align="center" style="padding:5px; font-weight:bold;">N°C/P</td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01') {
                                            if ($personas_afectadas[$i] > 0) {

                                                echo number_format($cant_incurridos[$i] / $personas_afectadas[$i], 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($cant_incurridos[$i] / $personas_afectadas[$i], 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($cant_incurridos[$i] / $personas_afectadas[$i], 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($cant_incurridos[$i] / $personas_afectadas[$i], 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($cant_incurridos[$i] / $personas_afectadas[$i], 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($cant_incurridos[$i] / $personas_afectadas[$i], 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($cant_incurridos[$i] / $personas_afectadas[$i], 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($cant_incurridos[$i] / $personas_afectadas[$i], 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($cant_incurridos[$i] / $personas_afectadas[$i], 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($cant_incurridos[$i] / $personas_afectadas[$i], 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($cant_incurridos[$i] / $personas_afectadas[$i], 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($cant_incurridos[$i] / $personas_afectadas[$i], 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {

                                        if ($personas_afectadas[$i] > 0) {
                                            $sum = $sum + ($cant_incurridos[$i] / $personas_afectadas[$i]);
                                            $si_es = '1';
                                        }
                                    }

                                    echo number_format($sum, 2, ",", ".");
    ?></td>
                                    <td class="alignRight"><?php echo number_format($sum / 12, 2, ",", "."); ?></td>
                                    </tr>
    <?php
}
if (trim($tipo_reporte) == '1') {
    //$total_casos_perso=$total_cant_incurridos/$total_personas_afectadas;
    ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">N° de casos promedio/personas </td>
                                    <td align="center" style="padding:5px; font-weight:bold;">N°Cprom/P</td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01') {
                                            if ($personas_afectadas[$i] > 0) {

                                                echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            if ($personas_afectadas[$i] > 0) {
                                                echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                                $si_es = '1';
                                            }
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
    ?></td>
                                    <td class="alignRight"><?php
                                    /* for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {$total_personas_afectadas=$total_personas_afectadas+$personas_afectadas[$i];}if($total_personas_afectadas>0){$total_casos_perso=$total_cant_incurridos/$total_personas_afectadas;} */
                                    $sum = 0;
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {

                                        if ($personas_afectadas[$i] > 0) {
                                            $sum = $sum + $total_casos_prom_perso_graf;
                                            //echo number_format($total_casos_prom_perso_graf, 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    }


                                    echo number_format($sum, 2, ",", ".");
                                    ?></td>
                                    <td class="alignRight"><?php echo number_format($sum / 12, 2, ",", "."); ?></td>
                                    </tr>
                                        <?php
                                    }
                                    if (trim($tipo_reporte) == '') {
                                        ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">% Incurrido/Estimado teórico Bs</td>
                                    <td align="center" style="padding:5px; font-weight:bold;">%INC/ET</td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01') {

                                            echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            echo number_format($incurrido_est_teorico[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            echo number_format($incurrido_est_teorico[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            echo number_format($incurrido_est_teorico[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            echo number_format($incurrido_est_teorico[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            echo number_format($incurrido_est_teorico[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            echo number_format($incurrido_est_teorico[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            echo number_format($incurrido_est_teorico[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            echo number_format($incurrido_est_teorico[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            echo number_format($incurrido_est_teorico[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            echo number_format($incurrido_est_teorico[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            echo number_format($incurrido_est_teorico[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $total_hmo = 0;
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        $total_hmo = $total_hmo + $incurrido_est_teorico[$i];
                                    }

                                    echo number_format($total_hmo, 2, ",", ".");
                                    ?></td>
                                    <td class="alignRight"><?php echo number_format($total_hmo / 12, 2, ",", "."); ?></td>
                                    </tr>
                                        <?php
                                    }
                                    if (trim($tipo_reporte) == '') {
                                        ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;"> Total Ahorro Bs</td>
                                    <td align="center" style="padding:5px; font-weight:bold;">TAH Bs</td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01') {
                                            echo number_format($ahorro[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            echo number_format($ahorro[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            echo number_format($ahorro[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            echo number_format($ahorro[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            echo number_format($ahorro[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            echo number_format($ahorro[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            echo number_format($ahorro[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            echo number_format($ahorro[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            echo number_format($ahorro[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            echo number_format($ahorro[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            echo number_format($ahorro[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            echo number_format($ahorro[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $total_hmo = 0;
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        $total_hmo = $total_hmo + $ahorro[$i];
                                    }
                                    echo number_format($total_hmo, 2, ",", ".");
                                    ?></td>
                                    <td class="alignRight"><?php echo number_format($total_hmo / 12, 2, ",", "."); ?></td>
                                    </tr>
                                        <?php
                                    }
                                    if (trim($tipo_reporte) == '') {
                                        ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">% Ahorro vs Indemnizado</td>
                                    <td align="center" style="padding:5px; font-weight:bold;"> %AH/I</td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01') {
                                            echo number_format($ahorro_vs_indenizado[$i], 2, ",", ".");

                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            echo number_format($ahorro_vs_indenizado[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            echo number_format($ahorro_vs_indenizado[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            echo number_format($ahorro_vs_indenizado[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            echo number_format($ahorro_vs_indenizado[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            echo number_format($ahorro_vs_indenizado[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            echo number_format($ahorro_vs_indenizado[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            echo number_format($ahorro_vs_indenizado[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            echo number_format($ahorro_vs_indenizado[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            echo number_format($ahorro_vs_indenizado[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            echo number_format($ahorro_vs_indenizado[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            echo number_format($ahorro_vs_indenizado[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $total_hmo = 0;
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        $total_hmo = $total_hmo + $ahorro_vs_indenizado[$i];
                                    }
                                    echo number_format($total_hmo, 2, ",", ".");
                                    ?></td>
                                    <td class="alignRight"><?php echo number_format($total_hmo / 12, 2, ",", "."); ?></td>
                                    </tr>
                                        <?php
                                    }
                                    if (trim($tipo_reporte) == '') {
                                        ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;"> Total Titulares</td>
                                    <td align="center" style="padding:5px; font-weight:bold;">T</td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01') {

                                            echo number_format($cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            echo number_format($cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            echo number_format($cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            echo number_format($cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            echo number_format($cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            echo number_format($cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            echo number_format($cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            echo number_format($cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            echo number_format($cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            echo number_format($cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            echo number_format($cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            echo number_format($cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                    ?></td>
                                    <td class="alignRight"><?php
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        $total_titular = $total_titular + $cantidad_titular[$i];
                                    }
                                    echo number_format($total_titular, 2, ",", ".");
                                        ?></td>
                                    <td class="alignRight"><?php
                                echo number_format($total_titular / $cuantos_tabla_inicial, 2, ",", ".");
                                ?></td>
                                    </tr>
                                        <?php
                                    }
                                    if (trim($tipo_reporte) == '') {
                                        ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">Total Beneficiarios</td>
                                    <td align="center" style="padding:5px; font-weight:bold;"> B </td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01') {

                                            echo number_format($cantidad_notitular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            echo number_format($cantidad_notitular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            echo number_format($cantidad_notitular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            echo number_format($cantidad_notitular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            echo number_format($cantidad_notitular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            echo number_format($cantidad_notitular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            echo number_format($cantidad_notitular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            echo number_format($cantidad_notitular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            echo number_format($cantidad_notitular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            echo number_format($cantidad_notitular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            echo number_format($cantidad_notitular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            echo number_format($cantidad_notitular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        $total_notitular = $total_notitular + $cantidad_notitular[$i];
                                    }

                                    echo number_format($total_notitular, 2, ",", ".");
                                        ?></td>
                                    <td class="alignRight"><?php
                                echo number_format($total_notitular / $cuantos_tabla_inicial, 2, ",", ".");
                                ?></td>
                                    </tr>
                                        <?php
                                    }
                                    if (trim($tipo_reporte) == '') {
                                        ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">Total Población</td>
                                    <td align="center" style="padding:5px; font-weight:bold;">(T+B) P</td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '01') {

                                            echo number_format($cantidad_notitular[$i] + $cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            echo number_format($cantidad_notitular[$i] + $cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            echo number_format($cantidad_notitular[$i] + $cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            echo number_format($cantidad_notitular[$i] + $cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            echo number_format($cantidad_notitular[$i] + $cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            echo number_format($cantidad_notitular[$i] + $cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            echo number_format($cantidad_notitular[$i] + $cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            echo number_format($cantidad_notitular[$i] + $cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            echo number_format($cantidad_notitular[$i] + $cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            echo number_format($cantidad_notitular[$i] + $cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            echo number_format($cantidad_notitular[$i] + $cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            echo number_format($cantidad_notitular[$i] + $cantidad_titular[$i], 2, ",", ".");
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $total_poblacion = $total_titular + $total_notitular;

                                    echo number_format($total_poblacion, 2, ",", ".");
                                        ?></td>
                                    <td class="alignRight"><?php
                                echo number_format($total_poblacion / $cuantos_tabla_inicial, 2, ",", ".");
                                ?></td>
                                    </tr>
                                        <?php
                                    }
                                    if (trim($tipo_reporte) == '') {
                                        ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">Monto Incurrido Pendiente</td>
                                    <td align="center" style="padding:5px; font-weight:bold;">MIP Bs </td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ($mes_salida[$i] == '01') {
                                            mostrarMonto($incurrido_pend_ant[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ($mes_salida[$i] == '02') {
                                            mostrarMonto($incurrido_pend_ant[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ($mes_salida[$i] == '03') {
                                            mostrarMonto($incurrido_pend_ant[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ($mes_salida[$i] == '04') {
                                            mostrarMonto($incurrido_pend_ant[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ($mes_salida[$i] == '05') {
                                            mostrarMonto($incurrido_pend_ant[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ($mes_salida[$i] == '06') {
                                            mostrarMonto($incurrido_pend_ant[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ($mes_salida[$i] == '07') {
                                            mostrarMonto($incurrido_pend_ant[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ($mes_salida[$i] == '08') {
                                            mostrarMonto($incurrido_pend_ant[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ($mes_salida[$i] == '09') {
                                            mostrarMonto($incurrido_pend_ant[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ($mes_salida[$i] == '10') {
                                            mostrarMonto($incurrido_pend_ant[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ($mes_salida[$i] == '11') {
                                            mostrarMonto($incurrido_pend_ant[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                        ?></td>
                                    <td class="alignRight"><?php
                                    $si_es = '0';
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ($mes_salida[$i] == '12') {
                                            mostrarMonto($incurrido_pend_ant[$i]);
                                            $si_es = '1';
                                        }
                                    } if ($si_es == '0') {
                                        echo "0,00";
                                    }
                                    ?></td>
                                    <td class="alignRight"><?php
                                    mostrarMonto($total_incurrido_pend_ant);
                                        ?></td>
                                    <td class="alignRight"><?php
                                echo number_format($total_incurrido_pend_ant / $cuantos_tabla_inicial, 2, ",", ".");
                                ?></td>
                                    </tr> 
                                    <?php
                                }
                                if (trim($tipo_reporte) == '') {
                                    ?>
                                   <!-- <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;"> Monto Rendido Bs</td>
                                    <td align="center" style="padding:5px; font-weight:bold;">MR Bs</td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    if ($mes_salida[$i] == '01') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");

                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    if ($mes_salida[$i] == '02') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    if ($mes_salida[$i] == '03') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    if ($mes_salida[$i] == '04') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    if ($mes_salida[$i] == '05') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    if ($mes_salida[$i] == '06') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    if ($mes_salida[$i] == '07') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    if ($mes_salida[$i] == '08') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    if ($mes_salida[$i] == '09') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    if ($mes_salida[$i] == '10') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    if ($mes_salida[$i] == '11') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    if ($mes_salida[$i] == '12') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $total_hmo = 0;
                                for ($i = 1; $i <= $cuantos_tabla_inicial; $i++) {
                                    $total_hmo = $total_hmo + $hmo_homorarios[$i];
                                }
                                echo number_format($total_hmo, 2, ",", ".");
                                ?></td>
                                    <td class="alignRight">0,00</td>
                                    </tr>-->
                                    <?php
                                }
                                if (trim($tipo_reporte) == '') {
                                    ?>
                                    <!--<tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">% De Rendición/ Incurrido</td>
                                    <td align="center" style="padding:5px; font-weight:bold;">%R/TI</td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($mes_salida[$i] == '01') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($mes_salida[$i] == '02') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($mes_salida[$i] == '03') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($mes_salida[$i] == '04') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($mes_salida[$i] == '05') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($mes_salida[$i] == '06') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($mes_salida[$i] == '07') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($mes_salida[$i] == '08') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($mes_salida[$i] == '09') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($mes_salida[$i] == '10') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($mes_salida[$i] == '11') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $si_es = '0';
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($mes_salida[$i] == '12') {
                                        echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                        $si_es = '1';
                                    }
                                } if ($si_es == '0') {
                                    echo "0,00";
                                }
                                    ?></td>
                                    <td class="alignRight"><?php
                                $total_hmo = 0;
                                for ($i = 1; $i <= 10; $i++) {

                                    $total_hmo = $total_hmo + $hmo_homorarios[$i];
                                }
                                echo number_format($total_hmo, 2, ",", ".");
                                ?></td>
                                    <td class="alignRight">0,00</td>
                                    </tr> 
                                    -->















                                    <?php
                                }
                                if (trim($tipo_reporte) == '4') {
                                    ?>


                                    <?php
                                    $query = "SELECT MOV,SUM(ENERO) ENERO,SUM(FEBRERO) FEBRERO,SUM(MARZO) MARZO,SUM(ABRIL) ABRIL,SUM(MAYO) MAYO,
           SUM(JUNIO) JUNIO,SUM(JULIO) JULIO,SUM(AGOSTO) AGOSTO,SUM(SEPTIEMBRE) SEPTIEMBRE,
           SUM(OCTUBRE ) OCTUBRE,SUM(NOVIEMBRE) NOVIEMBRE,SUM(DICIEMBRE) DICIEMBRE
FROM (
select 'AHORRO' MOV, mesparam,
   SUM (DECODE(mesparam,'01',ahorro,0)) Enero,
   SUM (DECODE(mesparam,'02',ahorro,0)) Febrero,
   SUM (DECODE(mesparam,'03',ahorro,0)) Marzo,
   SUM (DECODE(mesparam,'04',ahorro,0)) Abril,
   SUM (DECODE(mesparam,'05',ahorro,0)) Mayo,
   SUM (DECODE(mesparam,'06',ahorro,0)) Junio,
   SUM (DECODE(mesparam,'07',ahorro,0)) Julio,
   SUM (DECODE(mesparam,'08',ahorro,0)) Agosto,
   SUM (DECODE(mesparam,'09',ahorro,0)) Septiembre,
   SUM (DECODE(mesparam,'10',ahorro,0)) Octubre,
   SUM (DECODE(mesparam,'11',ahorro,0)) Noviembre,
   SUM (DECODE(mesparam,'12',ahorro,0)) Diciembre
FROM DISPONIBILIDAD_FONDO_VW
WHERE IDEPOL  = $cliente AND  anoparam=$ano
  GROUP BY (mesparam,anoparam)
UNION
select 'INDEMNIZADO' MOV,mesparam,
   SUM (DECODE(mesparam,'01',incurrido_indemnizado,0)) Enero,
   SUM (DECODE(mesparam,'02',incurrido_indemnizado,0)) Febrero,
   SUM (DECODE(mesparam,'03',incurrido_indemnizado,0)) Marzo,
   SUM (DECODE(mesparam,'04',incurrido_indemnizado,0)) Abril,
   SUM (DECODE(mesparam,'05',incurrido_indemnizado,0)) Mayo,
   SUM (DECODE(mesparam,'06',incurrido_indemnizado,0)) Junio,
   SUM (DECODE(mesparam,'07',incurrido_indemnizado,0)) Julio,
   SUM (DECODE(mesparam,'08',incurrido_indemnizado,0)) Agosto,
   SUM (DECODE(mesparam,'09',incurrido_indemnizado,0)) Septiembre,
   SUM (DECODE(mesparam,'10',incurrido_indemnizado,0)) Octubre,
   SUM (DECODE(mesparam,'11',incurrido_indemnizado,0)) Noviembre,
   SUM (DECODE(mesparam,'12',incurrido_indemnizado,0)) Diciembre
FROM DISPONIBILIDAD_FONDO_VW
WHERE IDEPOL  = $cliente AND  anoparam=$ano
  GROUP BY (mesparam,anoparam)
UNION
select 'INCURRIDO' MOV,mesparam,
   SUM (DECODE(mesparam,'01',incurrido_total,0)) Enero,
   SUM (DECODE(mesparam,'02',incurrido_total,0)) Febrero,
   SUM (DECODE(mesparam,'03',incurrido_total,0)) Marzo,
   SUM (DECODE(mesparam,'04',incurrido_total,0)) Abril,
   SUM (DECODE(mesparam,'05',incurrido_total,0)) Mayo,
   SUM (DECODE(mesparam,'06',incurrido_total,0)) Junio,
   SUM (DECODE(mesparam,'07',incurrido_total,0)) Julio,
   SUM (DECODE(mesparam,'08',incurrido_total,0)) Agosto,
   SUM (DECODE(mesparam,'09',incurrido_total,0)) Septiembre,
   SUM (DECODE(mesparam,'10',incurrido_total,0)) Octubre,
   SUM (DECODE(mesparam,'11',incurrido_total,0)) Noviembre,
   SUM (DECODE(mesparam,'12',incurrido_total,0)) Diciembre
FROM DISPONIBILIDAD_FONDO_VW
WHERE IDEPOL  = $cliente AND  anoparam=$ano
  GROUP BY (mesparam,anoparam)
)
GROUP BY MOV";
                                    $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
                                    $stmt2 = $pdo2->prepare($query);
                                    $stmt2->execute();
                                    $CMB_ANO_GENERAL = $stmt2->fetchAll();
                                    foreach ($CMB_ANO_GENERAL as $row_pf):


                                        $total_hmo = 0;
                                        $total_hmo = $total_hmo + str_replace(",", ".", $row_pf['ENERO']);
                                        $total_hmo = $total_hmo + str_replace(",", ".", $row_pf['FEBRERO']);
                                        $total_hmo = $total_hmo + str_replace(",", ".", $row_pf['MARZO']);
                                        $total_hmo = $total_hmo + str_replace(",", ".", $row_pf['ABRIL']);
                                        $total_hmo = $total_hmo + str_replace(",", ".", $row_pf['MAYO']);
                                        $total_hmo = $total_hmo + str_replace(",", ".", $row_pf['JUNIO']);
                                        $total_hmo = $total_hmo + str_replace(",", ".", $row_pf['JULIO']);
                                        $total_hmo = $total_hmo + str_replace(",", ".", $row_pf['AGOSTO']);
                                        $total_hmo = $total_hmo + str_replace(",", ".", $row_pf['SEPTIEMBRE']);
                                        $total_hmo = $total_hmo + str_replace(",", ".", $row_pf['OCTUBRE']);
                                        $total_hmo = $total_hmo + str_replace(",", ".", $row_pf['NOVIEMBRE']);
                                        $total_hmo = $total_hmo + str_replace(",", ".", $row_pf['DICIEMBRE']);
                                        ?>




                                        <tr>
                                        <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;"><?php echo $row_pf['MOV']; ?></td>
                                        <td align="center" style="padding:5px; font-weight:bold;"></td>


                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $row_pf['ENERO']), 2, ",", "."); ?></td>
                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $row_pf['FEBRERO']), 2, ",", "."); ?></td>
                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $row_pf['MARZO']), 2, ",", "."); ?></td>
                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $row_pf['ABRIL']), 2, ",", "."); ?></td>
                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $row_pf['MAYO']), 2, ",", "."); ?></td>
                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $row_pf['JUNIO']), 2, ",", "."); ?></td>
                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $row_pf['JULIO']), 2, ",", "."); ?></td>
                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $row_pf['AGOSTO']), 2, ",", "."); ?></td>
                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $row_pf['SEPTIEMBRE']), 2, ",", "."); ?></td>
                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $row_pf['OCTUBRE']), 2, ",", "."); ?></td>
                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $row_pf['NOVIEMBRE']), 2, ",", "."); ?></td>
                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $row_pf['DICIEMBRE']), 2, ",", "."); ?></td>




                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $total_hmo), 2, ",", "."); ?></td>
                                        <td class="alignRight"><?php echo number_format(str_replace(",", ".", $total_hmo / 12), 2, ",", "."); ?></td>

                                        </tr> 


                                    <?php endforeach;
                                    ?>                                                 

                                    <?php
                                    $var_srcipt = '<script type="text/javascript">
                                          google.load("visualization", "1", {packages:["corechart"]});
                                          google.setOnLoadCallback(drawChart);
                                          function drawChart() {
                                           var data = new google.visualization.DataTable();';
                                    $var_srcipt = $var_srcipt . " data.addColumn('string', 'mes');
                                            data.addColumn('number', 'TAH Bs U');
                                            data.addRows([";

                                    $var_srcipt = $var_srcipt . "['ENE'," . "0" . "],";
                                    $var_srcipt = $var_srcipt . "['FEB'," . "0" . "],";
                                    $var_srcipt = $var_srcipt . "['MAR'," . "0" . "],";
                                    $var_srcipt = $var_srcipt . "['ABR'," . "0" . "],";
                                    $var_srcipt = $var_srcipt . "['MAY'," . "0" . "],";
                                    $var_srcipt = $var_srcipt . "['JUN'," . "0" . "],";
                                    $var_srcipt = $var_srcipt . "['JUL'," . "0" . "],";
                                    $var_srcipt = $var_srcipt . "['AGO'," . "0" . "],";
                                    $var_srcipt = $var_srcipt . "['T. ACUM'," . "0" . "]";
                                    $var_srcipt = $var_srcipt . " ]); var options = {
          width: 900, height: 400,
          title: 'Evolución Ahorro Mensual Bs. U. Mil. en los períodos dia/mes/ año al dia/mes/ año',
          colors: ['#DC143C', '#0000CD', '#7FFF00'],
          legendTextStyle: {color:'#666666'},
          vAxis: {title: '', titleTextStyle: {color: 'black'}}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      </script> ";
                                    ?>
<?php }
?>












<?php if (trim($tipo_reporte) == '5') { ?>
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">Honorarios a HMO</td>
                                    <td align="center" style="padding:5px; font-weight:bold;">H HMO</td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight">0,00</td>
                                    </tr> 
                                    <tr>
                                    <td align="left" style="padding:5px; margin-left:15px; font-weight:bold;">Total Incurrido Bs</td>
                                    <td align="center" style="padding:5px; font-weight:bold;">TI Bs</td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight"><?php echo "0,00"; ?></td>
                                    <td class="alignRight">0,00</td>
                                    </tr> 

                                    <?php
                                    $var_srcipt = '<script type="text/javascript">
                                          google.load("visualization", "1", {packages:["corechart"]});
                                          google.setOnLoadCallback(drawChart);
                                          function drawChart() {
                                           var data = new google.visualization.DataTable();';
                                    $var_srcipt = $var_srcipt . " data.addColumn('string', 'mes');
                                            data.addColumn('number', 'TI Bs');
                                            data.addColumn('number', 'H HMO');
                                            data.addRows([";
                                    $var_srcipt = $var_srcipt . "['ACUM'," . "0" . ", 0 ],";
                                    $var_srcipt = $var_srcipt . "['ENE'," . "0" . ", 0 ],";
                                    $var_srcipt = $var_srcipt . "['FEB'," . "0" . ", 0 ],";
                                    $var_srcipt = $var_srcipt . "['MAR'," . "0" . ", 0 ],";
                                    $var_srcipt = $var_srcipt . "['ABR'," . "0" . ", 0 ],";
                                    $var_srcipt = $var_srcipt . "['MAY'," . "0" . ", 0 ],";
                                    $var_srcipt = $var_srcipt . "['JUN'," . "0" . ", 0 ],";
                                    $var_srcipt = $var_srcipt . "['JUL'," . "0" . ", 0 ],";
                                    $var_srcipt = $var_srcipt . "['AGO'," . "0" . ", 0 ]";
                                    $var_srcipt = $var_srcipt . " ]); var options = {
          width: 800, height: 500,
          title: 'Evolución de Incurrido y Honorarios mes a mes con acumulado en el período dia/mes/año al dia/mes/ año.',
          colors: ['#DC143C', '#0000CD', '#7FFF00'],
          legendTextStyle: {color:'#666666'},
          vAxis: {title: '', titleTextStyle: {color: 'black'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      </script> ";
                                }
                                ?>
                            </tbody>
                            <?php if (trim($tipo_reporte) == '') { ?>
        <!--                                <tfoot>
                                            <tr>
                                            <td align="left" >TOTAL</td>
                                            <td align="center" style="padding:5px; font-weight:bold;" >TOT</td>
                                            <td class="alignRight"><?php
                            $si_es = '0';
                            for ($i = 1; $i <= 10; $i++) {
                                if ($mes_salida[$i] == '01') {
                                    echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                    $si_es = '1';
                                }
                            } if ($si_es == '0') {
                                echo "0,00";
                            }
                                ?></td>
                                            <td class="alignRight"><?php
                            $si_es = '0';
                            for ($i = 1; $i <= 10; $i++) {
                                if ($mes_salida[$i] == '02') {
                                    echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                    $si_es = '1';
                                }
                            } if ($si_es == '0') {
                                echo "0,00";
                            }
                                ?></td>
                                            <td class="alignRight"><?php
                            $si_es = '0';
                            for ($i = 1; $i <= 10; $i++) {
                                if ($mes_salida[$i] == '03') {
                                    echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                    $si_es = '1';
                                }
                            } if ($si_es == '0') {
                                echo "0,00";
                            }
                                ?></td>
                                            <td class="alignRight"><?php
                            $si_es = '0';
                            for ($i = 1; $i <= 10; $i++) {
                                if ($mes_salida[$i] == '04') {
                                    echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                    $si_es = '1';
                                }
                            } if ($si_es == '0') {
                                echo "0,00";
                            }
                                ?></td>
                                            <td class="alignRight"><?php
                            $si_es = '0';
                            for ($i = 1; $i <= 10; $i++) {
                                if ($mes_salida[$i] == '05') {
                                    echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                    $si_es = '1';
                                }
                            } if ($si_es == '0') {
                                echo "0,00";
                            }
                                ?></td>
                                            <td class="alignRight"><?php
                            $si_es = '0';
                            for ($i = 1; $i <= 10; $i++) {
                                if ($mes_salida[$i] == '06') {
                                    echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                    $si_es = '1';
                                }
                            } if ($si_es == '0') {
                                echo "0,00";
                            }
                                ?></td>
                                            <td class="alignRight"><?php
                            $si_es = '0';
                            for ($i = 1; $i <= 10; $i++) {
                                if ($mes_salida[$i] == '07') {
                                    echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                    $si_es = '1';
                                }
                            } if ($si_es == '0') {
                                echo "0,00";
                            }
                                ?></td>
                                            <td class="alignRight"><?php
                            $si_es = '0';
                            for ($i = 1; $i <= 10; $i++) {
                                if ($mes_salida[$i] == '08') {
                                    echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                    $si_es = '1';
                                }
                            } if ($si_es == '0') {
                                echo "0,00";
                            }
                                ?></td>
                                            <td class="alignRight"><?php
                            $si_es = '0';
                            for ($i = 1; $i <= 10; $i++) {
                                if ($mes_salida[$i] == '09') {
                                    echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                    $si_es = '1';
                                }
                            } if ($si_es == '0') {
                                echo "0,00";
                            }
                                ?></td>
                                            <td class="alignRight"><?php
                            $si_es = '0';
                            for ($i = 1; $i <= 10; $i++) {
                                if ($mes_salida[$i] == '10') {
                                    echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                    $si_es = '1';
                                }
                            } if ($si_es == '0') {
                                echo "0,00";
                            }
                                ?></td>
                                            <td class="alignRight"><?php
                            $si_es = '0';
                            for ($i = 1; $i <= 10; $i++) {
                                if ($mes_salida[$i] == '11') {
                                    echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                    $si_es = '1';
                                }
                            } if ($si_es == '0') {
                                echo "0,00";
                            }
                                ?></td>
                                            <td class="alignRight"><?php
                            $si_es = '0';
                            for ($i = 1; $i <= 10; $i++) {
                                if ($mes_salida[$i] == '12') {
                                    echo number_format($hmo_homorarios[$i], 2, ",", ".");
                                    $si_es = '1';
                                }
                            } if ($si_es == '0') {
                                echo "0,00";
                            }
                                ?></td>
           <td class="alignRight"><?php
                            $total_hmo = 0;
                            for ($i = 1; $i <= 10; $i++) {
                                $total_hmo = $total_hmo + $hmo_homorarios[$i];
                            }
                            //echo number_format($total_hmo, 2, ",", ".");
                            echo number_format($total_hmo, 2, ",", ".");
                            ?></td>
                                            <td class="alignRight">0,00</td>
                                            </tr>

                                        </tfoot>-->
                        <?php } ?>

                        </table>

                        <!-- fin-->   


                        <?php echo $var = ob_get_clean(); ?>

<?php if (trim($tipo_reporte) != '') { ?>
                            <div style="height:520px; margin-left:20px;" align="left">

                                <div id="chart_div"></div>
                            </div>
                        <?php } ?>      



                        <?php
                        if (trim($tipo_reporte) == '1') {
                            $var_srcipt = $var_srcipt . " ]); var options = {
          width: 500, height: 400,
          title: 'Tendencia de número de casos/ persona (mensual)',
          colors: ['#DC143C', '#0000CD', '#7FFF00'],
          legendTextStyle: {color:'#666666'},
          vAxis: {title: 'Meses', titleTextStyle: {color: 'black'}}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      </script> ";
                        }

                        if (trim($tipo_reporte) == '2') {
                            $var_srcipt = $var_srcipt . " ]); var options = {
          width: 500, height: 400,
          title: 'Tendencia costo Promedio/mes',
          colors: ['#DC143C', '#0000CD', '#7FFF00'],
          legendTextStyle: {color:'#666666'},
          vAxis: {title: 'Meses', titleTextStyle: {color: 'black'}}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      </script> ";
                        }
                        ?>   

                        <!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
//echo $var=ob_get_clean();
$num = rand(1, 20);
$dir = 'pdf/index?2=' . $num;
?>
                        <!--FIN-->      

                        <!-- Formulario oculto para crear pdf-->
                        <form method="post" id="targetpdf" action="<?php echo url_for($dir) ?>" target="_blank" hidden="hidden">
                            <input id="titulo_pdf"  name="titulo_pdf" type="text" value="<?php
                            if (trim($tipo_reporte) == '') {
                                echo "Tablero de Indicadores Resumen";
                            } elseif (trim($tipo_reporte) == '1') {
                                echo "Tendencia de número de casos/ persona (mensual)";
                            } elseif (trim($tipo_reporte) == '2') {
                                echo "Tendencia Costo Promedio por Mes";
                            } elseif (trim($tipo_reporte) == '4') {
                                echo "Tendencia de Ahorro mensual";
                            } elseif (trim($tipo_reporte) == '5') {
                                echo "Tendencia Honorarios versus Incurrido total mensual";
                            }
?>
                                   " />
                            <textarea id="text_pdf" name="text" rows="2" cols="20"  >
<?php echo '<br />' . $var; ?>
                            </textarea>
                            <input id="img_grafico"  name="img_grafico" type="text" value="" />
                        </form>
                        <!-- fin-->               

                        <!-- Formulario oculto para crear excel-->
                        <form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
                            <input id="titulo"  name="titulo" type="text" value="<?php
                            if (trim($tipo_reporte) == '') {
                                echo "Tablero de Indicadores Resumen";
                            } elseif (trim($tipo_reporte) == '1') {
                                echo "Tendencia de número de casos/ persona (mensual)";
                            } elseif (trim($tipo_reporte) == '2') {
                                echo "Tendencia Costo Promedio por Mes";
                            } elseif (trim($tipo_reporte) == '4') {
                                echo "Tendencia de Ahorro mensual";
                            } elseif (trim($tipo_reporte) == '5') {
                                echo "Tendencia Honorarios versus Incurrido total mensual";
                            }
?>" />
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
    $query = "SELECT ANOPARAM FROM DISPONIBILIDAD_FONDO_VW  J where IDEPOL='$id_pol' 
            GROUP BY ANOPARAM ORDER BY ANOPARAM ASC";
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
        $query_mes = "SELECT MES, MESPARAM FROM DISPONIBILIDAD_FONDO_VW J where IDEPOL='$id_pol' AND 
             ANOPARAM='$ANOPARAM' ORDER BY MESPARAM ASC";
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
if ($cuantos_tabla_inicial != 0) {//echo $var_srcipt;
    if (trim($tipo_reporte) == '1' or trim($tipo_reporte) == '2') {
        echo $var_srcipt;
    }
}
?>