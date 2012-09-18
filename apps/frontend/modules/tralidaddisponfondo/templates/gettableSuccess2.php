<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php

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
?> 
<table class="tableSector">
    <thead>
        <tr align="center">
        <th width="140">Mes</th>
        <th >Disponibilidad del Fondo<br />
        <span style="font-size:11px;">DF(Bs)</span></th>
        <th >Aportes al fondo<br />
        <span >AF(Bs)</span></th>
        <th >Monto Incurrido Total<br />
        <span style="font-size:11px;">MIT(Bs)</span></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_disponible_saldo = 0;
        $total_aportes = 0;
        $total_incurrido_total = 0;
        foreach ($FONDOS_VW_tabla_inicial as $row_tabla):
            $aportes = $row_tabla['aportes'];
            $disponible_fondo = $row_tabla['disponible_fondo'];
            $incurrido_total = $row_tabla['incurrido_total'];

            $total_disponible_saldo = $total_disponible_saldo + $disponible_fondo;
            $total_aportes = $total_aportes + $aportes;
            $total_incurrido_total = $total_incurrido_total + $incurrido_total;

            $total_aportes_gra = $total_aportes;
            $total_incurrido_total_gra = $total_incurrido_total;
            $total_disponible_saldo_gra = $total_disponible_saldo;
        endforeach;

        $var_srcipt = '<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
       var data = new google.visualization.DataTable();';
        $var_srcipt = $var_srcipt . " data.addColumn('string', 'mes');
        data.addColumn('number', 'MIT');       
        data.addColumn('number', 'AF');
        data.addColumn('number', 'DF');
        
        data.addRows([ 
            ['Total'," . $total_incurrido_total_gra . "," . $total_aportes_gra . "," . $total_disponible_saldo_gra . "],";

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

                $disponible_fondo = $row_tabla['disponible_fondo'];
                $incurrido_acum = $row_tabla['incurrido_acum'];
                $incurrido_indemnizado = $row_tabla['incurrido_indemnizado'];
                $incurrido_pend_ant = $row_tabla['incurrido_pend_ant'];
                $incurrido_total = $row_tabla['incurrido_total'];
                $saldo_anterior = $row_tabla['saldo_anterior'];

                $incurrido_total_gra = $incurrido_total;
                $aportes_gra = $aportes;
                $disponible_fondo_gra = $disponible_fondo;

                $var_srcipt = $var_srcipt . "['" . $mes_grafica . "'," . $incurrido_total_gra . "," . $aportes_gra . "," . $disponible_fondo_gra . "]";
                if ($mml < $cuantos_tabla_inicial) {

                    $var_srcipt = $var_srcipt . ",";
                }
                ?>

                <tr>      
                <td><div align="left" style="margin-left:15px; margin-right:10px;" ><?php echo $mes_tabla; ?></div></td>
                <td class="alignRight"><?php echo number_format($disponible_fondo, 2, ",", "."); ?></td>                                                    
                <td class="alignRight"><?php echo number_format($aportes, 2, ",", "."); ?></td>                                             
                <td class="alignRight"><?php echo number_format($incurrido_total, 2, ",", ".");  ?></td> 
                </tr>
    <?php endforeach; ?>

<?php
} else {
    ?>
            <tr>      
            <td><div align="left" style="margin-left:10px; " >No existen casos registrados</div></td>
            <td class="alignRight">0</td>
            <td class="alignRight">0</td>
            <td class="alignRight">0</td>
            </tr>
        <?php
        }



        $var_srcipt = $var_srcipt . " ]); var options = {
          width: 600, height: 400,
          title: 'Disaponibilidad de fondos',
          //colors: ['#DC143C', '#0000CD', '#7FFF00', '#FE2EF7'],
          legendTextStyle: {color:'#666666'},
          vAxis: {title: '', titleTextStyle: {color: 'black'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      </script> ";
        ?>                                      </tbody>
    <tfoot>
        <tr style="font-weight:bold;" >
        <td><div align="left" style="margin-left:15px;" >Total</div></td>
        <td class="alignRight"><?php echo number_format($total_disponible_saldo, 2, ",", ".");  ?></td>
        <td class="alignRight"> <?php echo number_format($total_aportes, 2, ",", ".");  ?></td>
        <td class="alignRight"> <?php echo number_format($total_incurrido_total, 2, ",", ".");?></td>

        </tr>
    </tfoot>
</table>


<div style="height:420px; margin-left:20px;" align="left">

    <div id="chart_div"></div>
</div>

</div>            
<hr style="background-color:#E8E8E8; height:2px; border:0;" />


<table class="sectorBottomMenu">
    <tr>
        <!--<td><a href="#" id="url_excel">Excel</a></td>
        <td><a href="#" id="url_pdf">PDF</a></td>--> 
    <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                
</tr>                        
</table>

<script type="text/javascript">
    $("#url_imprime").click(function (){
        $("html").printArea();
    })
</script>
<?php if ($cuantos_tabla_inicial != 0) {
    echo $var_srcipt;
    ;
}
?>
