<?php use_helper('Number');
use_helper('Date');
?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php
error_reporting(E_ALL & ~E_NOTICE);

function paginacion($total, $pp, $st, $url) {

    if ($total > $pp) {
        $resto = $total % $pp;
        if ($resto == 0) {
            $pages = $total / $pp;
        } else {
            $pages = (($total - $resto) / $pp) + 1;
        }

        if ($pages > 10) {
            $current_page = ($st / $pp) + 1;
            if ($st == 0) {
                $first_page = 0;
                $last_page = 10;
            } else if (($current_page >= 5) && ($current_page <= ($pages - 5))) {
                $first_page = $current_page - 5;
                $last_page = $current_page + 5;
            } else if ($current_page < 5) {
                $first_page = 0;
                $last_page = $current_page + 5 + (5 - $current_page);
            } else {
                $first_page = $current_page - 5 - (($current_page + 5) - $pages);
                $last_page = $pages;
            }
        } else {
            $first_page = 0;
            $last_page = $pages;
        }

        for ($i = $first_page; $i < $last_page; $i++) {
            $pge = $i + 1;
            $nextst = $i * $pp;
            if ($st == $nextst) {

                if ($i != ($last_page - 1)) {
                    $page_nav .= '<div style=" background-color:#11936F; color:#fff; width:15px; float:left; margin-left:4px; " align="center"><b>' . $pge . '</b></div>  ';
                } else {
                    $page_nav .= '<div style="padding:2px; background-color:#58FAAC; color:#0B6138;"><b>' . $pge . '</b></div> ';
                }
            } else {
                if ($i != ($last_page - 1)) {
                    $page_nav .= '<div style=" background-color:#BDBDBD; color:#fff; width:15px; float:left; margin-left:4px; " align="center"><a href="' . $url . $nextst . '" style="color:#fff; text-decoration:none;"   ><b>' . $pge . '</b></a></div>  ';
                } else {
                    $page_nav .= '<div style=" background-color:#BDBDBD; color:#fff; width:15px; float:left; margin-left:4px; " align="center"><a href="' . $url . $nextst . '" style="color:#fff; text-decoration:none;"  ><b>' . $pge . '</b></a></div>';
                }
            }
        }

        if ($st == 0) {
            $current_page = 1;
        } else {
            $current_page = ($st / $pp) + 1;
        }

        if ($current_page < $pages) {
            $page_last = '<b>[<a href="' . $url . ($pages - 1) * $pp . '"  >>>></a>]';
            $page_next = '[<a href="' . $url . $current_page * $pp . '" >></a>]';
        }

        if ($st > 0) {
            $page_first = '<a href="' . $url . '0"  >< <<</a>]</a></b>';
            $page_previous = '[<a href="' . $url . '' . ($current_page - 2) * $pp . '" >< </a>]';
        }
    }

    //return "$page_first $page_previous $page_nav $page_next $page_last";
    return "$page_nav";
}

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

/*   echo "fecha_inicial:".$fecha_inicial."<br />"; 
  echo "fecha_ifinal:".$fecha_final."<br />";
  echo "num mes:".$num_dia_mes."<br />";
  echo "días hábiles:".$CantidadDiasHabiles."<br />"; */

foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):

    $cantidad_total_casos = $cantidad_total_casos + str_replace(",", ".", $row_tabla['CANTIDAD']);
    $monto_total = $monto_total + str_replace(",", ".", $row_tabla['TOTAL']);

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


<div class="cajas_totales" >
    <div class="cajitas_peq_totales">
        <div class="linea">
            <div class="titulo_cajita">Cantidad de Proveedores:</div>
            <div  class="total_bs" ><?php echo number_format($total_proveedores, 2, ",", "."); ?></div>  
        </div>
        <div class="linea_media">
            <div class="titulo_cajita">Cantidad Promedio de Casos/Proveedor:</div>
            <div class="total_bs"><?php echo number_format($promedio_casos_prov, 2, ",", "."); ?></div>
        </div>
    </div>

    <!-- otra cajita -->
    <!-- otra cajita -->
    <div class="cajitas_peq_totales_med">
        <div class="linea">
            <div class="titulo_cajita_med">Total Reclamos:</div>
            <div class="total_bs_med" ><?php echo number_format($cantidad_total_casos, 2, ",", "."); ?></div>  
        </div>
        <div class="linea_media">
            <div class="titulo_cajita_med">Total Personas Atendidas:</div>
            <div class="total_bs_med"><?php echo number_format($total_per_atendidas, 2, ",", "."); ?></div>
        </div>
    </div>

    <!-- otra cajita -->
    <!-- otra cajita -->

    <div class="cajitas_peq_totales_med">
        <div class="linea">
            <div class="titulo_cajita_med">Monto Total Bs:</div>
            <div class="total_bs_med" >111110<?php echo $monto_total; //number_format($monto_total, 2, ",", "."); ?></div>  
        </div>
        <div class="linea_media">
            <div class="titulo_cajita_med">Costo Promedio/Caso:</div>
            <div class="total_bs_med"><?php echo number_format($costo_promedio_caso, 2, ",", "."); ?></div>
        </div>
    </div>

    <!-- otra cajita -->

</div>
<div class="titulo_reporte" > Listado de Proveedores por <?php if ($servicio_busca != 'todos' and $servicio_busca != '') {
    echo ucfirst(strtr(strtolower($servicio_busca), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú"));
} else {
    echo "  Todos los tipos de servicios";
} ?></div>

<hr style="background-color:#E8E8E8; height:2px; border:0;" />
<div id="showTable" name="show" > 
    <!-- INICIO PANTALLAS BACKEND -->
    <table class="tableSector">
        <thead>
            <tr>
            <th>Nombre del Proveedor</th>
            <th>Nª Rif</th>
            <th>Cantidad de Reclamos</th>
            <th>Monto en Bs.</th>
            <th>Nª de Personas Atendidas</th>
            <th>Promedio de Caso/Persona</th>
            <th>Costo Promedio por Persona</th>                    
            </tr>
        </thead>
        <tbody>
            <?php if ($cuantos_tabla_inicial != 0) { ?>
                <?php
                foreach ($SINIESTRALIDAD_VW_tabla_parcial as $row_tabla):

                    $id_prov = $row_tabla['COD_BEN_PAGO'];
                    /* $long=strlen($id_prov);
                      $id_prov=substr($id_prov, 2,$long);
                      echo "MILAAAAAA".$id_prov."<br />"; */
                    $nombre_prov = $row_tabla['BEN_PAGO'];
                    $cantidad = $row_tabla['CANTIDAD'];
                    $rif = $row_tabla['RIF'];
                    $monto_servicio = $row_tabla['TOTAL'];


                    if ($cantidad > 1) {
                        if ($contratante != 'todos') {
                            if ($tipo_servicio != 'todos') {
                                $q_aten = Doctrine_Query::create()
                                        ->select('ci_paciente')
                                        ->from('SINIESTRALIDAD_VW   J')
                                        ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_inicial','DD/MM/YYYY')  
                                                                and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_final','DD/MM/YYYY')
                                                                and idepol='$cliente' 
                                                                and tipo_des='$tipo_servicio'
                                                                and codexterno='$contratante'
                                                                and INITCAP(ben_pago)='$nombre_prov'
                                                              ")
                                        ->groupBy('(ci_paciente, id)');
                                echo $q_aten . "<br />";
                            } else {
                                $q_aten = Doctrine_Query::create()
                                        ->select('ci_paciente')
                                        ->from('SINIESTRALIDAD_VW   J')
                                        ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_inicial','DD/MM/YYYY')  
                                                                and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_final','DD/MM/YYYY')
                                                                and idepol='$cliente'                                                               
                                                                and codexterno='$contratante'
                                                                and INITCAP(ben_pago)='$nombre_prov'
                                                              ")
                                        ->groupBy('(ci_paciente, id)');
                                //echo $q_aten."<br />";  
                            }
                            $q_aten->fetchArray();

                            $atendidos_por_prov = $q_aten->count();
                            //echo $atendidos_por_prov."<br />";
                        } else {
                            if ($tipo_servicio != 'todos') {
                                $q_aten = Doctrine_Query::create()
                                        ->select('ci_paciente')
                                        ->from('SINIESTRALIDAD_VW   J')
                                        ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_inicial','DD/MM/YYYY')  
                                                                    and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_final','DD/MM/YYYY')
                                                                    and idepol='$cliente' 
                                                                    and tipo_des='$tipo_servicio'                                                                  
                                                                    and INITCAP(ben_pago)='$nombre_prov'
                                                                  ")
                                        ->groupBy('(ci_paciente, id)');
                                //echo $q_aten."<br />";
                            } else {
                                $q_aten = Doctrine_Query::create()
                                        ->select('ci_paciente')
                                        ->from('SINIESTRALIDAD_VW   J')
                                        ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_inicial','DD/MM/YYYY')  
                                                                    and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_final','DD/MM/YYYY')
                                                                    and idepol='$cliente'                                                                                                                                    
                                                                    and INITCAP(ben_pago)='$nombre_prov'
                                                                  ")
                                        ->groupBy('(ci_paciente, id)');
                                //echo $q_aten."<br />";
                            }

                            $q_aten->fetchArray();

                            $atendidos_por_prov = $q_aten->count();
                            //echo $atendidos_por_prov."<br />";
                        }

                        // echo "Num atendidos".$atendidos."<br />";
                        //Esta es la formula cuando no me de 0
                        if ($atendidos_por_prov != 0) {
                            $pro_casos_per = $cantidad / $atendidos_por_prov;
                            $promedio_costo = $monto_servicio / $atendidos_por_prov;
                            //$pro_casos_per=0;
                        } else {

                            $pro_casos_per = 0;
                            $promedio_costo = $monto_servicio;
                        }
                    } else {
                        $atendidos_por_prov = 1;
                        $pro_casos_per = 1;
                        $promedio_costo = $monto_servicio;
                    }
                    $url = 'siniedetaprove/index?cliente=' . $cliente . '&contratante=' . $contratante . '&ano=' . $ano . '&mes=' . $mes . '&tipo_servicio=' . $id_tipo_serv . '&servicio=' . $tipo_serv . '&rif=' . $rif . '&tipo_lis=1';
                    ?>


                    <tr>      

                    <td class="nombre_proveedor" ><input class="botonadd" type="button" onclick="location.href='<?php echo url_for($url) ?>'" /><?php echo $nombre_prov; ?></td>
                    <td class="nombre_proveedor" ><?php echo $rif; //echo number_format($cantidad,2,",",".");  ?></td>
                    <td class="alignRight"><?php echo number_format($cantidad, 2, ",", "."); ?></td>
                    <td class="alignRight"><?php echo number_format($monto_servicio, 2, ",", "."); ?></td>
                    <td class="alignRight"><?php echo number_format($atendidos_por_prov, 2, ",", "."); ?></td>
                    <td class="alignRight"><?php echo number_format($pro_casos_per, 2, ",", "."); ?></td>
                    <td class="alignRight"><?php echo number_format($promedio_costo, 2, ",", "."); ?></td>

                    </tr>
                <?php
                endforeach;
            } else {
                ?>

                <tr>      

                <td>No existen casos registrados <?php //echo $row['mparentesco'];  ?></td>
                <td class="alignRight">0</td>
                <td class="alignRight">0</td>
                <td class="alignRight">0</td>
                <td class="alignRight">0</td>
                <td class="alignRight">0</td>
                <td class="alignRight">0</td>


                </tr>
<?php } ?>
        </tbody>
    </table> 
    <table> 
        <tfoot>
            <tr><td><?php
$total = $cuantos_tabla_inicial;
echo $total . "<br />";
$url_pag = url_for('siniedetaprove/index');
if ($cuantos_tabla_inicial > 0) {
    echo paginacion($total, $pp, $st, url_for('sinielistadprovee/gettable') . '?ano=' . $ano . '&mes=' . $mes . '&cliente=' . $cliente . '&contratante=' . $contratante . '&tipo_servicio=' . $tipo_servicio . '&st=');
}
?>
            </td></tr>
        </tfoot></table>

</div>                  
</div>

<hr style="background-color:#E8E8E8; height:2px; border:0;" />


<table class="sectorBottomMenu">
    <tr>
        <!--<td><a href="#" id="url_excel">Excel</a></td>
        <td><a href="#" id="url_pdf">PDF</a></td> -->
    <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                
</tr>                        
</table>  


<script type="text/javascript">$("#cargando").css("display", "none");</script>



<script type="text/javascript">
    $("#url_imprime").click(function (){
        $("html").printArea();
    })
</script>

