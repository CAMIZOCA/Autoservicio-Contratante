<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php
//error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

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

$total_aps_ene = 0;
$total_ca_ene = 0;
$total_em_ene = 0;
$total_ree_ene = 0;
$cantidad_aps_ene = 0;
$cantidad_ca_ene = 0;
$cantidad_em_ene = 0;
$cantidad_ree_ene = 0;

$total_aps_feb = 0;
$total_ca_feb = 0;
$total_em_feb = 0;
$total_ree_feb = 0;
$cantidad_aps_feb = 0;
$cantidad_ca_feb = 0;
$cantidad_em_feb = 0;
$cantidad_ree_feb = 0;

$total_aps_mar = 0;
$total_ca_mar = 0;
$total_em_mar = 0;
$total_ree_mar = 0;
$cantidad_aps_mar = 0;
$cantidad_ca_mar = 0;
$cantidad_em_mar = 0;
$cantidad_ree_mar = 0;

$total_aps_abr = 0;
$total_ca_abr = 0;
$total_em_abr = 0;
$total_ree_abr = 0;
$cantidad_aps_abr = 0;
$cantidad_ca_abr = 0;
$cantidad_em_abr = 0;
$cantidad_ree_abr = 0;

$total_aps_may = 0;
$total_ca_may = 0;
$total_em_may = 0;
$total_ree_may = 0;
$cantidad_aps_may = 0;
$cantidad_ca_may = 0;
$cantidad_em_may = 0;
$cantidad_ree_may = 0;

$total_aps_jun = 0;
$total_ca_jun = 0;
$total_em_jun = 0;
$total_ree_jun = 0;
$cantidad_aps_jun = 0;
$cantidad_ca_jun = 0;
$cantidad_em_jun = 0;
$cantidad_ree_jun = 0;

$total_aps_jul = 0;
$total_ca_jul = 0;
$total_em_jul = 0;
$total_ree_jul = 0;
$cantidad_aps_jul = 0;
$cantidad_ca_jul = 0;
$cantidad_em_jul = 0;
$cantidad_ree_jul = 0;

$total_aps_ago = 0;
$total_ca_ago = 0;
$total_em_ago = 0;
$total_ree_ago = 0;
$cantidad_aps_ago = 0;
$cantidad_ca_ago = 0;
$cantidad_em_ago = 0;
$cantidad_ree_ago = 0;

$total_aps_sep = 0;
$total_ca_sep = 0;
$total_em_sep = 0;
$total_ree_sep = 0;
$cantidad_aps_sep = 0;
$cantidad_ca_sep = 0;
$cantidad_em_sep = 0;
$cantidad_ree_sep = 0;


$total_aps_oct = 0;
$total_ca_oct = 0;
$total_em_oct = 0;
$total_ree_oct = 0;
$cantidad_aps_oct = 0;
$cantidad_ca_oct = 0;
$cantidad_em_oct = 0;
$cantidad_ree_oct = 0;

$total_aps_nov = 0;
$total_ca_nov = 0;
$total_em_nov = 0;
$total_ree_nov = 0;
$cantidad_aps_nov = 0;
$cantidad_ca_nov = 0;
$cantidad_em_nov = 0;
$cantidad_ree_nov = 0;

$total_aps_dic = 0;
$total_ca_dic = 0;
$total_em_dic = 0;
$total_ree_dic = 0;
$cantidad_aps_dic = 0;
$cantidad_ca_dic = 0;
$cantidad_em_dic = 0;
$cantidad_ree_dic = 0;

$total_general_conjugue = 0;
$total_general_ca = 0;
$total_general_em = 0;
$total_general_ree = 0;

//$CantidadDiasHabiles = Evalua(DiasHabiles($fecha_inicial,$fecha_final)); 
//echo "Cuantos tabla inicial: ".$cuantos_tabla_inicial;
if ($cuantos_tabla_inicial != 0) {
    foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):


        $tipo_servicio = $row_tabla['TIPO_DES'];
        $cantidad = $row_tabla['CANTIDAD'];
        $monto_incurrido = str_replace(",", ".", $row_tabla['TOTAL']);
        $mes = $row_tabla['MES'];




        if ($mes == '01') {
            if (trim($tipo_servicio) == 'A.P.S') {
                $total_aps_ene = $total_aps_ene + $monto_incurrido;
                $cantidad_aps_ene = $cantidad_aps_ene + $cantidad;
            }
            if (trim($tipo_servicio) == 'CARTA AVAL') {
                $total_ca_ene = $total_ca_ene + $monto_incurrido;
                $cantidad_ca_ene = $cantidad_ca_ene + $cantidad;
            }

            if (trim($tipo_servicio) == 'EMERGENCIA') {
                $total_em_ene = $total_em_ene + $monto_incurrido;
                $cantidad_em_ene = $cantidad_em_ene + $cantidad;
            }

            if (trim($tipo_servicio) == 'REEMBOLSO') {
                $total_ree_ene = $total_ree_ene + $monto_incurrido;
                $cantidad_ree_ene = $cantidad_ree_ene + $cantidad;
            }

            $total_ene = $total_aps_ene + $total_ca_ene + $total_em_ene + $total_ree_ene;

            $cantidad_ene = $cantidad_aps_ene + $cantidad_ca_ene + $cantidad_em_ene + $cantidad_ree_ene;
        }


        if ($mes == '02') {
            if (trim($tipo_servicio) == 'A.P.S') {
                $total_aps_feb = $total_aps_feb + $monto_incurrido;
                $cantidad_aps_feb = $cantidad_aps_feb + $cantidad;
            }
            if (trim($tipo_servicio) == 'CARTA AVAL') {
                $total_ca_feb = $total_ca_feb + $monto_incurrido;
                $cantidad_ca_feb = $cantidad_ca_feb + $cantidad;
            }

            if (trim($tipo_servicio) == 'EMERGENCIA') {
                $total_em_feb = $total_em_feb + $monto_incurrido;
                $cantidad_em_feb = $cantidad_em_feb + $cantidad;
            }

            if (trim($tipo_servicio) == 'REEMBOLSO') {
                $total_ree_feb = $total_ree_feb + $monto_incurrido;
                $cantidad_ree_feb = $cantidad_ree_feb + $cantidad;
            }

            $total_feb = $total_aps_feb + $total_ca_feb + $total_em_feb + $total_ree_feb;

            $cantidad_feb = $cantidad_aps_feb + $cantidad_ca_feb + $cantidad_em_feb + $cantidad_ree_feb;
        }

        if ($mes == '03') {
            if (trim($tipo_servicio) == 'A.P.S') {
                $total_aps_mar = $total_aps_mar + $monto_incurrido;
                $cantidad_aps_mar = $cantidad_aps_mar + $cantidad;
            }
            if (trim($tipo_servicio) == 'CARTA AVAL') {
                $total_ca_mar = $total_ca_mar + $monto_incurrido;
                $cantidad_ca_mar = $cantidad_ca_mar + $cantidad;
            }

            if (trim($tipo_servicio) == 'EMERGENCIA') {
                $total_em_mar = $total_em_mar + $monto_incurrido;
                $cantidad_em_mar = $cantidad_em_mar + $cantidad;
            }

            if (trim($tipo_servicio) == 'REEMBOLSO') {
                $total_ree_mar = $total_ree_mar + $monto_incurrido;
                $cantidad_ree_mar = $cantidad_ree_mar + $cantidad;
            }

            $total_mar = $total_aps_mar + $total_ca_mar + $total_em_mar + $total_ree_mar;
            $cantidad_mar = $cantidad_aps_mar + $cantidad_ca_mar + $cantidad_em_mar + $cantidad_ree_mar;
        }

        if ($mes == '04') {
            if (trim($tipo_servicio) == 'A.P.S') {
                $total_aps_abr = $total_aps_abr + $monto_incurrido;
                $cantidad_aps_abr = $cantidad_aps_abr + $cantidad;
            }
            if (trim($tipo_servicio) == 'CARTA AVAL') {
                $total_ca_abr = $total_ca_abr + $monto_incurrido;
                $cantidad_ca_abr = $cantidad_ca_abr + $cantidad;
            }

            if (trim($tipo_servicio) == 'EMERGENCIA') {
                $total_em_abr = $total_em_abr + $monto_incurrido;
                $cantidad_em_abr = $cantidad_em_abr + $cantidad;
            }

            if (trim($tipo_servicio) == 'REEMBOLSO') {
                $total_ree_abr = $total_ree_abr + $monto_incurrido;
                $cantidad_ree_abr = $cantidad_ree_abr + $cantidad;
            }

            $total_abr = $total_aps_abr + $total_ca_abr + $total_em_abr + $total_ree_abr;

            $cantidad_abr = $cantidad_aps_abr + $cantidad_ca_abr + $cantidad_em_abr + $cantidad_ree_abr;
        }

        if ($mes == '05') {
            if (trim($tipo_servicio) == 'A.P.S') {
                $total_aps_may = $total_aps_may + $monto_incurrido;
                $cantidad_aps_may = $cantidad_aps_may + $cantidad;
            }
            if (trim($tipo_servicio) == 'CARTA AVAL') {
                $total_ca_may = $total_ca_may + $monto_incurrido;
                $cantidad_ca_may = $cantidad_ca_may + $cantidad;
            }

            if (trim($tipo_servicio) == 'EMERGENCIA') {
                $total_em_may = $total_em_may + $monto_incurrido;
                $cantidad_em_may = $cantidad_em_may + $cantidad;
            }

            if (trim($tipo_servicio) == 'REEMBOLSO') {
                $total_ree_may = $total_ree_may + $monto_incurrido;
                $cantidad_ree_may = $cantidad_ree_may + $cantidad;
            }

            $total_may = $total_aps_may + $total_ca_may + $total_em_may + $total_ree_may;
            $cantidad_may = $cantidad_aps_may + $cantidad_ca_may + $cantidad_em_may + $cantidad_ree_may;
        }

        if ($mes == '06') {
            if (trim($tipo_servicio) == 'A.P.S') {
                $total_aps_jun = $total_aps_jun + $monto_incurrido;
                $cantidad_aps_jun = $cantidad_aps_jun + $cantidad;
            }
            if (trim($tipo_servicio) == 'CARTA AVAL') {
                $total_ca_jun = $total_ca_jun + $monto_incurrido;
                $cantidad_ca_jun = $cantidad_ca_jun + $cantidad;
            }

            if (trim($tipo_servicio) == 'EMERGENCIA') {
                $total_em_jun = $total_em_jun + $monto_incurrido;
                $cantidad_em_jun = $cantidad_em_jun + $cantidad;
            }

            if (trim($tipo_servicio) == 'REEMBOLSO') {
                $total_ree_jun = $total_ree_jun + $monto_incurrido;
                $cantidad_ree_jun = $cantidad_ree_jun + $cantidad;
            }

            $total_jun = $total_aps_jun + $total_ca_jun + $total_em_jun + $total_ree_jun;

            $cantidad_jun = $cantidad_aps_jun + $cantidad_ca_jun + $cantidad_em_jun + $cantidad_ree_jun;
        }

        if ($mes == '07') {
            if (trim($tipo_servicio) == 'A.P.S') {
                $total_aps_jul = $total_aps_jul + $monto_incurrido;
                $cantidad_aps_jul = $cantidad_aps_jul + $cantidad;
            }
            if (trim($tipo_servicio) == 'CARTA AVAL') {
                $total_ca_jul = $total_ca_jul + $monto_incurrido;
                $cantidad_ca_jul = $cantidad_ca_jul + $cantidad;
            }

            if (trim($tipo_servicio) == 'EMERGENCIA') {
                $total_em_jul = $total_em_jul + $monto_incurrido;
                $cantidad_em_jul = $cantidad_em_jul + $cantidad;
            }

            if (trim($tipo_servicio) == 'REEMBOLSO') {
                $total_ree_jul = $total_ree_jul + $monto_incurrido;
                $cantidad_ree_jul = $cantidad_ree_jul + $cantidad;
            }

            $total_jul = $total_aps_jul + $total_ca_jul + $total_em_jul + $total_ree_jul;

            $cantidad_jul = $cantidad_aps_jul + $cantidad_ca_jul + $cantidad_em_jul + $cantidad_ree_jul;
        }

        if ($mes == '08') {
            if (trim($tipo_servicio) == 'A.P.S') {
                $total_aps_ago = $total_aps_ago + $monto_incurrido;
                $cantidad_aps_ago = $cantidad_aps_ago + $cantidad;
            }
            if (trim($tipo_servicio) == 'CARTA AVAL') {
                $total_ca_ago = $total_ca_ago + $monto_incurrido;
                $cantidad_ca_ago = $cantidad_ca_ago + $cantidad;
            }

            if (trim($tipo_servicio) == 'EMERGENCIA') {
                $total_em_ago = $total_em_ago + $monto_incurrido;
                $cantidad_em_ago = $cantidad_em_ago + $cantidad;
            }

            if (trim($tipo_servicio) == 'REEMBOLSO') {
                $total_ree_ago = $total_ree_ago + $monto_incurrido;
                $cantidad_ree_ago = $cantidad_ree_ago + $cantidad;
            }

            $total_ago = $total_aps_ago + $total_ca_ago + $total_em_ago + $total_ree_ago;

            $cantidad_ago = $cantidad_aps_ago + $cantidad_ca_ago + $cantidad_em_ago + $cantidad_ree_ago;
        }

        if ($mes == '09') {
            if (trim($tipo_servicio) == 'A.P.S') {
                $total_aps_sep = $total_aps_sep + $monto_incurrido;
                $cantidad_aps_sep = $cantidad_aps_sep + $cantidad;
            }
            if (trim($tipo_servicio) == 'CARTA AVAL') {
                $total_ca_sep = $total_ca_sep + $monto_incurrido;
                $cantidad_ca_sep = $cantidad_ca_sep + $cantidad;
            }

            if (trim($tipo_servicio) == 'EMERGENCIA') {
                $total_em_sep = $total_em_sep + $monto_incurrido;
                $cantidad_em_sep = $cantidad_em_sep + $cantidad;
            }

            if (trim($tipo_servicio) == 'REEMBOLSO') {
                $total_ree_sep = $total_ree_sep + $monto_incurrido;
                $cantidad_ree_sep = $cantidad_ree_sep + $cantidad;
            }

            $total_sep = $total_aps_sep + $total_ca_sep + $total_em_sep + $total_ree_sep;

            $cantidad_sep = $cantidad_aps_sep + $cantidad_ca_sep + $cantidad_em_sep + $cantidad_ree_sep;
        }

        if ($mes == '10') {
            if (trim($tipo_servicio) == 'A.P.S') {
                $total_aps_oct = $total_aps_oct + $monto_incurrido;
                $cantidad_aps_oct = $cantidad_aps_oct + $cantidad;
            }
            if (trim($tipo_servicio) == 'CARTA AVAL') {
                $total_ca_oct = $total_ca_oct + $monto_incurrido;
                $cantidad_ca_oct = $cantidad_ca_oct + $cantidad;
            }

            if (trim($tipo_servicio) == 'EMERGENCIA') {
                $total_em_oct = $total_em_oct + $monto_incurrido;
                $cantidad_em_oct = $cantidad_em_oct + $cantidad;
            }

            if (trim($tipo_servicio) == 'REEMBOLSO') {
                $total_ree_oct = $total_ree_oct + $monto_incurrido;
                $cantidad_ree_oct = $cantidad_ree_oct + $cantidad;
            }

            $total_oct = $total_aps_oct + $total_ca_oct + $total_em_oct + $total_ree_oct;

            $cantidad_oct = $cantidad_aps_oct + $cantidad_ca_oct + $cantidad_em_oct + $cantidad_ree_oct;
        }

        if ($mes == '11') {
            if (trim($tipo_servicio) == 'A.P.S') {
                $total_aps_nov = $total_aps_nov + $monto_incurrido;
                $cantidad_aps_nov = $cantidad_aps_nov + $cantidad;
            }
            if (trim($tipo_servicio) == 'CARTA AVAL') {
                $total_ca_nov = $total_ca_nov + $monto_incurrido;
                $cantidad_ca_nov = $cantidad_ca_nov + $cantidad;
            }

            if (trim($tipo_servicio) == 'EMERGENCIA') {
                $total_em_nov = $total_em_nov + $monto_incurrido;
                $cantidad_em_nov = $cantidad_em_nov + $cantidad;
            }

            if (trim($tipo_servicio) == 'REEMBOLSO') {
                $total_ree_nov = $total_ree_nov + $monto_incurrido;
                $cantidad_ree_nov = $cantidad_ree_nov + $cantidad;
            }

            $total_nov = $total_aps_nov + $total_ca_nov + $total_em_nov + $total_ree_nov;

            $cantidad_nov = $cantidad_aps_nov + $cantidad_ca_nov + $cantidad_em_nov + $cantidad_ree_nov;
        }


        if ($mes == '12') {
            if (trim($tipo_servicio) == 'A.P.S') {
                $total_aps_dic = $total_aps_dic + $monto_incurrido;
                $cantidad_aps_dic = $cantidad_aps_dic + $cantidad;
            }
            if (trim($tipo_servicio) == 'CARTA AVAL') {
                $total_ca_dic = $total_ca_dic + $monto_incurrido;
                $cantidad_ca_dic = $cantidad_ca_dic + $cantidad;
            }

            if (trim($tipo_servicio) == 'EMERGENCIA') {
                $total_em_dic = $total_em_dic + $monto_incurrido;
                $cantidad_em_dic = $cantidad_em_dic + $cantidad;
            }

            if (trim($tipo_servicio) == 'REEMBOLSO') {
                $total_ree_dic = $total_ree_dic + $monto_incurrido;
                $cantidad_ree_dic = $cantidad_ree_dic + $cantidad;
            }

            $total_dic = $total_aps_dic + $total_ca_dic + $total_em_dic + $total_ree_dic;

            $cantidad_dic = $cantidad_aps_dic + $cantidad_ca_dic + $cantidad_em_dic + $cantidad_ree_dic;
        }

    endforeach;
}

$total_general = $total_ene + $total_feb + $total_mar + $total_abr + $total_may + $total_jun + $total_jul + $total_ago + $total_sep + $total_oct + $total_nov + $total_dic;
$total_general_aps = $total_aps_ene + $total_aps_feb + $total_aps_mar + $total_aps_abr + $total_aps_may + $total_aps_jun + $total_aps_jul + $total_aps_ago + $total_aps_sep + $total_aps_oct + $total_aps_nov + $total_aps_dic;
$total_general_ca = $total_ca_ene + $total_ca_feb + $total_ca_mar + $total_ca_abr + $total_ca_may + $total_ca_jun + $total_ca_jul + $total_ca_ago + $total_ca_sep + $total_ca_oct + $total_ca_nov + $total_ca_dic;
$total_general_em = $total_em_ene + $total_em_feb + $total_em_mar + $total_em_abr + $total_em_may + $total_em_jun + $total_em_jul + $total_em_ago + $total_em_sep + $total_em_oct + $total_em_nov + $total_em_dic;
$total_general_ree = $total_ree_ene + $total_ree_feb + $total_ree_mar + $total_ree_abr + $total_ree_may + $total_ree_jun + $total_ree_jul + $total_ree_ago + $total_ree_sep + $total_ree_oct + $total_ree_nov + $total_ree_dic;
$cantidad_general_aps = $cantidad_aps_ene + $cantidad_aps_feb + $cantidad_aps_mar + $cantidad_aps_abr + $cantidad_aps_may + $cantidad_aps_jun + $cantidad_aps_jul + $cantidad_aps_ago + $cantidad_aps_sep + $cantidad_aps_oct + $cantidad_aps_nov + $cantidad_aps_dic;
$cantidad_general_ca = $cantidad_ca_ene + $cantidad_ca_feb + $cantidad_ca_mar + $cantidad_ca_abr + $cantidad_ca_may + $cantidad_ca_jun + $cantidad_ca_jul + $cantidad_ca_ago + $cantidad_ca_sep + $cantidad_ca_oct + $cantidad_ca_nov + $cantidad_ca_dic;
$cantidad_general_em = $cantidad_em_ene + $cantidad_em_feb + $cantidad_em_mar + $cantidad_em_abr + $cantidad_em_may + $cantidad_em_jun + $cantidad_em_jul + $cantidad_em_ago + $cantidad_em_sep + $cantidad_em_oct + $cantidad_em_nov + $cantidad_em_dic;
$cantidad_general_ree = $cantidad_ree_ene + $cantidad_ree_feb + $cantidad_ree_mar + $cantidad_ree_abr + $cantidad_ree_may + $cantidad_ree_jun + $cantidad_ree_jul + $cantidad_ree_ago + $cantidad_ree_sep + $cantidad_ree_oct + $cantidad_ree_nov + $cantidad_ree_dic;
$cantidad_general = $cantidad_ene + $cantidad_feb + $cantidad_mar + $cantidad_abr + $cantidad_may + $cantidad_jun + $cantidad_jul + $cantidad_ago + $cantidad_sep + $cantidad_oct + $cantidad_nov + $cantidad_dic;
?> 
<?php if ($cuantos_tabla_inicial != 0) { ?>
    <hr style="background-color:#E8E8E8; height:2px; border:0;" />
    <!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
    <?php
    ob_start();
    ?>
    <!-- FIN-->
    <table class="tableSector">
        <thead>
            <tr>
            <th>
                &nbsp;</th>
            <th align="center" colspan="2">
                A.P.S</th>
            <th align="center" colspan="2">
                CARTA AVAL</th>
            <th align="center" colspan="2">
                EMERGENCIA</th>
            <th align="center" colspan="2">
                REEMBOLSO</th>
            <th align="center" colspan="2">
                Total</th>
            </tr>
            <tr>
            <th class="nombre_proveedor">
                Mes</th>
            <th class="nombre_proveedor">
                AM I Bs</th>
            <th class="nombre_proveedor">
                AM N&deg; DE C</th>
            <th class="nombre_proveedor">
                CA I Bs</th>
            <th class="nombre_proveedor">
                CA N&deg; DE C</th>
            <th class="nombre_proveedor">
                E I Bs</th>
            <th class="nombre_proveedor">
                E N&deg; DE C</th>
            <th class="nombre_proveedor">
                RE I Bs</th>
            <th class="nombre_proveedor">
                RE N&deg; DE C</th>
            <th class="nombre_proveedor">
                T I Bs</th>
            <th class="nombre_proveedor">
                T N&deg; DE C</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
            <td class="nombre_proveedor">
                TOTAL</td>
            <td class="alignRight">
                <?php echo number_format(str_replace(",", ".", $total_general_aps), 2, ",", "."); ?></td>
            <td class="alignRight">
                <?php echo number_format(str_replace(",", ".", $cantidad_general_aps), 2, ",", "."); ?></td>
            <td class="alignRight">
                <?php echo number_format(str_replace(",", ".", $total_general_ca), 2, ",", "."); ?></td>
            <td class="alignRight">
                <?php echo number_format(str_replace(",", ".", $cantidad_general_ca), 2, ",", "."); ?></td>
            <td class="alignRight">
                <?php echo number_format(str_replace(",", ".", $total_general_em), 2, ",", "."); ?></td>
            <td class="alignRight">
                <?php echo number_format(str_replace(",", ".", $cantidad_general_em), 2, ",", "."); ?></td>
            <td class="alignRight">
                <?php echo number_format(str_replace(",", ".", $total_general_ree), 2, ",", "."); ?></td>
            <td class="alignRight">
                <?php echo number_format(str_replace(",", ".", $cantidad_general_ree), 2, ",", "."); ?></td>
            <td class="alignRight">
                <?php echo number_format(str_replace(",", ".", $total_general), 2, ",", "."); ?></td>
            <td class="alignRight">
                <?php echo number_format(str_replace(",", ".", $cantidad_general), 2, ",", "."); ?></td>
            </tr>
        </tfoot>
        <tbody>
            <?php if ($total_ene > 0) { ?>   
                <tr>
                <td class="nombre_proveedor">
                    Enero</td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_aps_ene), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_aps_ene), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ca_ene), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ca_ene), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_em_ene), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_em_ene), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ree_ene), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ree_ene), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ene), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ene), 2, ",", "."); ?></td>
                </tr>
            <?php } if ($total_feb > 0) { ?>   
                <tr>
                <td class="nombre_proveedor">
                    Febrero</td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_aps_feb), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_aps_feb), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ca_feb), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ca_feb), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_em_feb), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_em_feb), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ree_feb), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ree_feb), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_feb), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_feb), 2, ",", "."); ?></td>
                </tr>
            <?php } if ($total_mar > 0) { ?>   
                <tr>
                <td class="nombre_proveedor">
                    Marzo</td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_aps_mar), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_aps_mar), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ca_mar), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ca_mar), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_em_mar), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_em_mar), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ree_mar), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ree_mar), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_mar), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_mar), 2, ",", "."); ?></td>
                </tr>
            <?php } if ($total_abr > 0) { ?>   
                <tr>
                <td class="nombre_proveedor">
                    Abril</td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_aps_abr), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_aps_abr), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ca_abr), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ca_abr), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_em_abr), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_em_abr), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ree_abr), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ree_abr), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_abr), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_abr), 2, ",", "."); ?></td>
                </tr>
            <?php } if ($total_may > 0) { ?>   
                <tr>
                <td class="nombre_proveedor">
                    Mayo</td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_aps_may), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_aps_may), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ca_may), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ca_may), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_em_may), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_em_may), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ree_may), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ree_may), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_may), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_may), 2, ",", "."); ?></td>
                </tr>
            <?php } if ($total_jun > 0) { ?>   
                <tr>
                <td class="nombre_proveedor">
                    Junio</td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_aps_jun), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_aps_jun), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ca_jun), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ca_jun), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_em_jun), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_em_jun), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ree_jun), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ree_jun), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_jun), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_jun), 2, ",", "."); ?></td>
                </tr>
            <?php } if ($total_jul > 0) { ?>   
                <tr>
                <td class="nombre_proveedor">
                    Julio</td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_aps_jul), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_aps_jul), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ca_jul), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ca_jul), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_em_jul), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_em_jul), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ree_jul), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ree_jul), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_jul), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_jul), 2, ",", "."); ?></td>
                </tr>
            <?php } if ($total_ago > 0) { ?>   
                <tr>
                <td class="nombre_proveedor">
                    Agosto</td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_aps_ago), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_aps_ago), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ca_ago), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ca_ago), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_em_ago), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_em_ago), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ree_ago), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ree_ago), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ago), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ago), 2, ",", "."); ?></td>
                </tr>
            <?php } if ($total_sep > 0) { ?>   
                <tr>
                <td class="nombre_proveedor">
                    Septiembre</td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_aps_sep), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_aps_sep), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ca_sep), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ca_sep), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_em_sep), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_em_sep), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ree_sep), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ree_sep), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_sep), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_sep), 2, ",", "."); ?></td>
                </tr>
            <?php } if ($total_oct > 0) { ?>   
                <tr>
                <td class="nombre_proveedor">
                    Octubre</td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_aps_oct), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_aps_oct), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ca_oct), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ca_oct), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_em_oct), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_em_oct), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ree_oct), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ree_oct), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_oct), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_oct), 2, ",", "."); ?></td>
                </tr>
            <?php } if ($total_nov > 0) { ?>   
                <tr>
                <td class="nombre_proveedor">
                    Noviembre</td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_aps_nov), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_aps_nov), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ca_nov), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ca_nov), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_em_nov), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_em_nov), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ree_nov), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ree_nov), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_nov), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_nov), 2, ",", "."); ?></td>
                </tr>
            <?php } if ($total_dic > 0) { ?>   
                <tr>
                <td class="nombre_proveedor">
                    Diciembre</td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_aps_dic), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_aps_dic), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ca_dic), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ca_dic), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_em_dic), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_em_dic), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_ree_dic), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_ree_dic), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $total_dic), 2, ",", "."); ?></td>
                <td class="alignRight">
                    <?php echo number_format(str_replace(",", ".", $cantidad_dic), 2, ",", "."); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
    <?php
    echo $var.=ob_get_clean();
    ?>
    <!--FIN-->      

    <!-- Formulario oculto para crear pdf-->
    <form method="post" id="targetpdf" action="<?php echo url_for('pdf/index') ?>" target="_blank" hidden="hidden">
        <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Por Tipo servicio - Mes" />
        <textarea id="text_pdf" name="text" rows="2" cols="20"  >
            <?php echo $var; ?>
        </textarea>
    </form>
    <!-- fin-->      
    <!-- Formulario oculto para crear excel-->
    <form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
        <input id="titulo"  name="titulo" type="text" value="Por Tipo servicio - Mes" />
        <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
    </form>
    <!-- fin-->

<?php } ?>

</div>              


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

