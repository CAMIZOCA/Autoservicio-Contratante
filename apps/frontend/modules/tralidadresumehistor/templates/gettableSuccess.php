<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php
//error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

//echo "MIlAAAAAAAAAAAAAAAa";

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


foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):

    $cantidad_total_casos = $cantidad_total_casos + $row_tabla['cantidad'];
    $monto_total = $monto_total + str_replace(",", ".", $row_tabla['total']);


endforeach;

//echo $cantidad_total_casos ;
if ($cuantos_tabla_inicial != 0 and $cantidad_total_casos != 0) {
    $costo_promedio_caso = ($monto_total / $cantidad_total_casos);
} else {
    $costo_promedio_caso = 0;
}

if ($cuantos_tabla_inicial != 0 and $total_proveedores != 0) {
    $promedio_casos_prov = ($cantidad_total_casos / $total_proveedores);
} else {
    $promedio_casos_prov = 0;
}

if ($cantidad > 1) {
    if ($contratante != 'todos') {

        $q_aten = Doctrine_Query::create()
                ->select('ci_paciente')
                ->from('SINIESTRALIDAD_VW J')
                ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_inicial','DD/MM/YYYY')  
                                                                and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_final','DD/MM/YYYY')
                                                                and idepol='$cliente' 
                                                                and INITCAP(tipo_des)='$tipo_ser'
                                                                and codexterno='$contratante'
                                                                and INITCAP(enfermedad)='$enfermedad'")
                ->groupBy('(ci_paciente, id)');
        // echo $q_aten."<br />";

        $q_aten->fetchArray();

        $atendidos = $q_aten->count();
    } else {
        $q_aten = Doctrine_Query::create()
                ->select('ci_paciente')
                ->from('SINIESTRALIDAD_VW   J')
                ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_inicial','DD/MM/YYYY')  
                                                                    and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_final','DD/MM/YYYY')
                                                                    and idepol='$cliente' 
                                                                    and INITCAP(tipo_des)='$tipo_ser'                                                                  
                                                                    and INITCAP(enfermedad)='$enfermedad'
                                                                  ")
                ->groupBy('(ci_paciente, id)');
        // echo $q_aten."<br />";

        $q_aten->fetchArray();

        $atendidos = $q_aten->count();
    }
}
$mes2 = $mes;
?>   
<div class="cajas_totales">
    <div class="cajitas_peq_totales">   
        <div class="linea">
            <div class="titulo_cajita">Cantidad de Proveedores:</div>
            <div class="total_bs"><?php echo number_format($total_proveedores, 2, ",", "."); ?></div>  
        </div>
        <div class="linea_media">
            <div class="titulo_cajita">Cantidad Promedio de Casos/Proveedor:</div>
            <div class="total_bs"><?php echo number_format($promedio_casos_prov, 2, ",", "."); ?></div>
        </div>
    </div>

    <!-- otra cajita --><!-- otra cajita -->
    <div class="cajitas_peq_totales_med"style="margin-left:10px;"> 
        <div class="linea">
            <div class="titulo_cajita_med">Total Reclamos:</div>
            <div class="total_bs_med"><?php echo format_number($cantidad_total_casos, 2); ?></div>  
        </div>
        <div class="linea_media">
            <div class="titulo_cajita_med">Total Personas Atendidas:</div>
            <div class="total_bs_med"><?php echo format_number($total_per_atendidas, 2); ?></div>
        </div>
    </div>

    <!-- otra cajita --><!-- otra cajita -->

    <div class="cajitas_peq_totales" style=" margin-left:10px;">
        <div class="linea">
            <div class="titulo_cajita">Monto Total Bs:</div>
            <div class="total_bs"><?php echo number_format($monto_total, 2, ",", ".");  ?></div>  
        </div>
        <div class="linea_media">
            <div class="titulo_cajita">Costo Promedio/Caso:</div>
            <div class="total_bs"><?php echo number_format($costo_promedio_caso, 2, ",", "."); ?></div>
        </div>
    </div>

    <!-- otra cajita --><!-- otra cajita -->
</div>


<!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
ob_start();
?>
<!-- FIN-->

<!-- INICIO PANTALLAS BACKEND -->
<table class="tableSector" cellpadding="0" cellspacing="0">
    <thead >
        <tr align="center">
        <th>Mes</th>
        <th>Saldo Anterior Fondo Bs</th>
        <th>Aporte Fondos</th>
        <th>Nª de Casos Incurridos</th>
        <th>Monto Incurrido Total Bs</th>
        <th>Monto Incurrido Acumulado Bs</th>
        <th>Monto Incurrido Pendiente Mes Anterior Bs</th>
        <th>Monto Indemnizado Bs</th>
        <th>Ahorro Bs (Pronto Pago)</th>
        <th>Disponibilidad de Fondos</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($cuantos_tabla_inicial != 0) {

            foreach ($FONDOS_VW_tabla_inicial as $row_tabla):


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
                $aportes = str_replace(",", ".", $row_tabla['aportes']);
                $cant_incurridos = str_replace(",", ".", $row_tabla['cant_incurridos']);
                $costo_promedio = str_replace(",", ".", $row_tabla['costo_promedio']);

                $ahorro = str_replace(",", ".", $row_tabla['ahorro']);
                $disponible_fondo = str_replace(",", ".", $row_tabla['disponible_fondo']);
                $incurrido_acum = str_replace(",", ".", $row_tabla['incurrido_acum']);
                $incurrido_indemnizado = str_replace(",", ".", $row_tabla['incurrido_indemnizado']);
                $incurrido_pend_ant = str_replace(",", ".", $row_tabla['incurrido_pend_ant']);
                $incurrido_total = str_replace(",", ".", $row_tabla['incurrido_total']);
                $saldo_anterior = str_replace(",", ".", $row_tabla['saldo_anterior']);

                $total_disponible_saldo = $total_disponible_saldo + $disponible_fondo;
                $total_saldo_anterior = $total_saldo_anterior + $saldo_anterior;
                $total_aportes = $total_aportes + $aportes;
                $total_cant_incurridos = $total_cant_incurridos + $cant_incurridos;
                $total_incurrido_total = $total_incurrido_total + $incurrido_total;
                $total_incurrido_acum = $total_incurrido_acum + $incurrido_acum;
                $total_incurrido_pend_ant = $total_incurrido_pend_ant + $incurrido_pend_ant;
                $total_incurrido_indemnizado = $total_incurrido_indemnizado + $incurrido_indemnizado;
                ?>
                <tr>      
                <td><div align="left" style="margin-right:20px; width:120px; padding-left:5px;" ><?php echo $mes_tabla; ?></div></td>
                <td class="alignRight"><?php echo number_format($saldo_anterior, 2, ",", "."); ?></td>
                <td class="alignRight"><?php echo number_format($aportes, 2, ",", "."); ?></td>
                <td class="alignRight"><?php echo number_format($cant_incurridos, 2, ",", "."); ?></td>
                <td class="alignRight"><?php echo number_format($incurrido_total, 2, ",", "."); ?></td>
                <td class="alignRight"><?php echo number_format($incurrido_acum, 2, ",", "."); ?></td>
                <td class="alignRight"><?php echo number_format($incurrido_pend_ant, 2, ",", "."); ?></td>
                <td class="alignRight"><?php echo number_format($incurrido_indemnizado, 2, ",", "."); ?></td>
                <td class="alignRight"><?php echo number_format($ahorro, 2, ",", "."); ?></td>
                <td class="alignRight"><?php echo number_format($disponible_fondo, 2, ",", "."); ?></td>


                </tr>
                <?php
            endforeach;
        } else {
            ?>
            <tr>      
            <td><div align="center" style="margin-right:20px; width:120px;" >No existen casos registrados</div></td>
            <td class="alignRight">0</td>
            <td class="alignRight">0</td>
            <td class="alignRight">0</td>
            <td class="alignRight">0</td>
            <td class="alignRight">0</td>
            <td class="alignRight">0</td>
            <td class="alignRight">0</td>
            <td class="alignRight">0</td>
            <td class="alignRight">0</td>
            </tr>
        <?php } ?>
    </tbody>

    <tfoot>
        <tr style="font-weight:bold;">      
        <td><div align="left" style="margin-right:20px; width:120px; padding-left:5px;" >Total</div></td>
        <td class="alignRight"></td>
        <td class="alignRight"><?php echo number_format($total_aportes, 2, ",", ".");  ?></td>
        <td class="alignRight"><?php echo number_format($total_cant_incurridos, 2, ",", ".");  ?></td>
        <td class="alignRight"><?php echo number_format($total_incurrido_total, 2, ",", ".");  ?></td>
        <td class="alignRight"></td>
        <td class="alignRight"></td>
        <td class="alignRight"><?php echo number_format($total_incurrido_indemnizado, 2, ",", ".");  ?></td>
        <td class="alignRight"><?php echo "0"; ?></td>
        <td class="alignRight"></td>


        </tr>

    </tfoot>

</table> 

<!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
echo $var.=ob_get_clean();
$num = rand(5, 15);
$dir = 'pdf/index?2=' . $num;
?>
<!--FIN-->      

<!-- Formulario oculto para crear pdf-->
<form method="post" id="targetpdf" action="<?php echo url_for($dir) ?>" target="_blank" hidden="hidden">
    <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Resumen Histórico" />
    <textarea id="text_pdf" name="text" rows="2" cols="20"  >
        <?php echo $var; ?>
    </textarea>
</form>
<!-- fin-->  
<!-- Formulario oculto para crear excel-->
<form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
<input id="titulo"  name="titulo" type="text" value="Resumen Histórico" />
    <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
</form>
<!-- fin-->

<hr style="background-color:#E8E8E8; height:2px; border:0;" />


<table class="sectorBottomMenu">
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

    //Funcion de submit pdf
    $('#url_pdf').click(function() {
        $('#targetpdf').submit();
    }); 
    //Funcion de submit excel
    $('#url_excel').click(function() {
        $('#targetexcel').submit();
    }); 
</script>

