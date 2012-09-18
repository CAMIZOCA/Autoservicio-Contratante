<?php use_helper('Number');
use_helper('Date');
?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php
//error_reporting(0);
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
                    $page_nav .= '<b>[' . $pge . ']</b> - ';
                } else {
                    $page_nav .= '<b>[' . $pge . ']</b> ';
                }
            } else {
                if ($i != ($last_page - 1)) {
                    $page_nav .= '<a href="' . $url . $nextst . '">' . $pge . '</a> - ';
                } else {
                    $page_nav .= '<a href="' . $url . $nextst . '">' . $pge . '</a>';
                }
            }
        }

        if ($st == 0) {
            $current_page = 1;
        } else {
            $current_page = ($st / $pp) + 1;
        }

        if ($current_page < $pages) {
            $page_last = '<b>[<a href="' . $url . ($pages - 1) * $pp . '">>>></a>]';
            $page_next = '[<a href="' . $url . $current_page * $pp . '">></a>]';
        }

        if ($st > 0) {
            $page_first = '<b>[<a href="' . $url . '0">< <<</a>]</a></b>';
            $page_previous = '[<a href="' . $url . '' . ($current_page - 2) * $pp . '">< </a>]';
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
$mes2 = $mes;
foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):

    $cantidad_total_casos = $cuantos_tabla_inicial;
    $monto_total = $monto_total + $row_tabla['INDEMNIZADO'];

endforeach;

if ($cuantos_tabla_inicial != 0) {
    $costo_promedio_caso = $monto_total / $cantidad_total_casos;
} else {
    $costo_promedio_caso = 0;
}
if ($cuantos_tabla_inicial != 0) {
    $promedio_casos_prov = $cantidad_total_casos / $cuantos_tabla_inicial;
} else {
    $promedio_casos_prov = 0;
}
?>  
<div  class="cajas_totales">
    <div class="cajitas_peq_totales">
        <div class="linea" >
            <div class="titulo_cajita">Cantidad de Proveedores:</div>
            <div class="total_bs"><?php echo format_number($total_proveedores); ?></div>  
        </div>
        <div class="linea_media">
            <div class="titulo_cajita">Cantidad Promedio de Casos/Proveedor:</div>
            <div class="total_bs"><?php echo format_number($promedio_casos_prov); ?></div>
        </div>
    </div>

    <!-- otra cajita --><!-- otra cajita -->
    <div class="cajitas_peq_totales_med">
        <div class="linea">
            <div class="titulo_cajita_med">Total Reclamos:</div>
            <div class="total_bs_med"><?php echo number_format($cantidad_total_casos, 2, ",", "."); ?></div>  
        </div>
        <div class="linea_media">
            <div class="titulo_cajita_med">Total Personas Atendidas:</div>
            <div class="total_bs_med"><?php echo number_format($total_per_atendidas, 2, ",", ".");  ?></div>
        </div>
    </div>

    <!-- otra cajita --><!-- otra cajita -->

    <div class="cajitas_peq_totales_med" >
        <div class="linea">
            <div class="titulo_cajita_med">Monto Total Bs:</div>
            <div class="total_bs_med"><?php echo number_format($monto_total, 2, ",", ".");  ?></div>  
        </div>
        <div class="linea_media">
            <div class="titulo_cajita_med">Costo Promedio/Caso:</div>
            <div class="total_bs_med"><?php echo number_format($costo_promedio_caso, 2, ",", ".");  ?></div>
        </div></div>

    <!-- otra cajita --><!-- otra cajita -->

</div>
<div class="titulo_reporte">Detalle de Listado por Proveedores para <?php if ($servicio_busca != 'todos' and $servicio_busca != '') {
    echo ucfirst(strtr(strtolower($servicio_busca), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú"));
} else {
    echo "  Todos los Tipos de Servicios";
} ?></div>
<hr style="background-color:#E8E8E8; height:2px; border:0;" />

<!-- INICIO PANTALLAS BACKEND -->

<!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
ob_start();
?>
<!-- FIN-->                    
<table class="tableSector">
    <thead>
        <tr align="center">
        <th>Nombre del Proveedor</th>
        <th >Rif</th>
        <th>CI. del Afiliado</th>
        <th>Nombre del Afiliado</th>
        <th>Tipo Servicio</th>
        <th>Parentesco</th>
        <th>Fecha de Ocurrencia</th>
        <th>Monto en Bs.</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($cuantos_tabla_inicial != 0) { ?>
            <?php
            foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):

                $id_prov = $row_tabla['COD_BEN_PAGO'];
                $nombre_prov = $row_tabla['BEN_PAGO'];
                $ci_paciente = $row_tabla['CI_PACIENTE'];
                $paciente = $row_tabla['PACIENTE'];
                $cod_tipo_des = $row_tabla['COD_TIPO_DES'];
                $tipo_des = $row_tabla['TIPO_DES'];
                $parentesco = $row_tabla['PARENTESCO'];
                $rif = $row_tabla['RIF'];
                $fecocurr = date('d/m/Y', strtotime($row_tabla['FECOCURR']));
                $monto = $row_tabla['INDEMNIZADO'];
                $url = 'siniedetalle/index?cliente=' . $cliente . '&contratante=' . $contratante . '&ano=' . $ano . '&mes=' . $mes2 . '&tipo_servicio=' . $cod_tipo_des . '&servicio=' . $tipo_des . '&ci_paciente=' . $ci_paciente . '&rif=' . $rif . '&tipo_lis=2';
                ?> 
                <tr>      

                <td class="nombre_proveedor"><input class="botonadd" type="button" onclick="location.href='<?php echo url_for($url) ?>'"  /><?php echo $nombre_prov; ?></td>
                <td class="nombre_proveedor"><?php echo $rif; ?></td>
                <td class="nombre_proveedor"><?php echo $ci_paciente; ?></td>
                <td class="nombre_proveedor"><?php echo $paciente; ?></td>
                <td class="nombre_proveedor"><?php echo $tipo_des; ?></td>
                <td class="nombre_proveedor"><?php echo $parentesco; ?></td>
                <td class="nombre_proveedor"><?php echo $fecocurr; ?></td>
                <td class="alignRight"><?php echo number_format($monto, 2, ",", ".");  ?></td>
                </tr>
            <?php endforeach;
        }
        else {
            ?>
            <tr>      

            <td class="nombre_proveedor">No existen casos registrados</td>
            <td><?php echo "--"; ?></td>
            <td><?php echo "--"; ?></td>
            <td><?php echo "--"; ?></td>
            <td><?php echo "--"; ?></td>
            <td><?php echo "--"; ?></td>
            <td><?php echo "--"; ?></td>
            <td class="alignRight"><?php echo "0"; ?></td>


            </tr>
        <?php } ?>
    </tbody>
    <tfoot><?php
        $total = $cuantos_tabla_inicial;
        $url_pag = url_for('siniedetaprove/index');
        // if($cuantos_tabla_inicial>0){ //echo "Mila pag".paginacion($total,$pp,$st, url_for('siniedetaprove/index').'?ano='.$ano.'&st=');}
        ?></tfoot>
</table> 

<!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
echo $var = ob_get_clean();
?>
<!--FIN--> 
<!-- Formulario oculto para crear pdf-->
<form method="post" id="targetpdf" action="<?php echo url_for('pdf/index') ?>" target="_blank" hidden="hidden">
    <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Detalle de Listado por Proveedores para <?php if ($servicio_busca != 'todos' and $servicio_busca != '') {
    echo ucfirst(strtr(strtolower($servicio_busca), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú"));
} else {
    echo "  Todos los Tipos de Servicios";
} ?>" />
    <textarea id="text_pdf" name="text" rows="2" cols="20"  >
<?php echo $var; ?>
    </textarea>
</form>
<!-- fin-->
<!-- Formulario oculto para crear pdf-->
<form method="post" id="targetimp" action="<?php echo url_for('imprimir/index') ?>" target="_blank" hidden="hidden">
    <input id="titulo_pdf"  name="titulo" type="text" value="Detalle de Listado por Proveedores para <?php if ($servicio_busca != 'todos' and $servicio_busca != '') {
    echo ucfirst(strtr(strtolower($servicio_busca), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú"));
} else {
    echo "  Todos los Tipos de Servicios";
} ?>" />
    <textarea id="text_imp" name="text_imp" rows="2" cols="20"  >
<?php echo $var; ?>
    </textarea>

</form>
<!-- fin-->

<hr style="background-color:#E8E8E8; height:2px; border:0;" />


<table class="sectorBottomMenu">
    <tr>
        <!--<td><a href="#" id="url_excel">Excel</a></td>-->
    <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td>
    <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                
</tr>                        
</table> 



<script type="text/javascript">$("#cargando").css("display", "none");</script>



<script type="text/javascript">
    $("#url_imprime").click(function (){
        //$("html").printArea();
        $('#targetimp').submit();
    })

    //    funcion de submit pdf
    $('#url_pdf').click(function() {
        $('#targetpdf').submit();
    }); 
</script>

