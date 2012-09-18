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

$CantidadDiasHabiles = Evalua(DiasHabiles($fecha_inicial, $fecha_final));
?> 
<?php if ($cuantos_tabla_inicial != 0) { ?>
    <!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
    <?php
    ob_start();
    ?>
    <!-- FIN-->
    <h1 class="articleTitle" style=" display:none;">Reclamos por tipo de servicio</h1>
    <table class="tableSector">
        <thead>
            <tr align="center">
            <th>Tipo de Servicio</th>
            <th>Cantidad de Casos</th>
            <th>Costo Total (Incurrido)</th>
            <th>Costo Promedio/Casos  </th>
            <th>Costo Promedio/Día</th>
            <th>Casos Promedio/Día</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($cuantos_tabla_inicial != 0) { ?>
                <?php
                foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):

                    $id_tipo_serv = $row_tabla['cod_tipo_des'];
                    $tipo_serv = $row_tabla['tipo_des'];
                    $cantidad = $row_tabla['cantidad'];
                    $monto_servicio = str_replace(",", ".", $row_tabla['total']);
                    $promedio_casos = $monto_servicio / $cantidad;
                    $costo_promedio_dia = $promedio_casos / $dias_mes;
                    $casos_promedio_dia = $cantidad / $dias_mes;
                    $url = 'siniedetageneral/index?cliente=' . $cliente . '&contratante=' . $contratante . '&ano=' . $ano . '&mes=' . $mes . '&tipo_servicio=' . $id_tipo_serv . '&servicio=' . $tipo_serv . '&servi_general=' . $tipo_servicio . '&tipo_lis=1';
                    //echo $costo_promedio_dia."<br />";
                    ?>

                    <tr>      

                    <td class="nombre_proveedor"><input class="botonadd" type="button" onclick="location.href='<?php echo url_for($url) ?>'" /><?php echo $tipo_serv; ?></td>
                    <td class="alignRight"><?php echo number_format($cantidad, 2, ",", "."); ?></td>                                                    
                    <td class="alignRight"><?php echo number_format($monto_servicio, 2, ",", "."); ?></td>
                    <td class="alignRight"><?php echo number_format($promedio_casos, 2, ",", "."); ?></td>
                    <td class="alignRight"><?php echo number_format($costo_promedio_dia, 2, ",", "."); ?></td>
                    <td class="alignRight"><?php echo number_format($casos_promedio_dia, 2, ",", "."); ?></td>

                    </tr>
                    <?php
                    $totalmonto = $totalmonto + $monto_servicio;
                    $totalcantidad = $totalcantidad + $cantidad;
                    $total_promedio_casos = $total_promedio_casos + $promedio_casos;
                    $total_costo_pro_dia = $total_costo_pro_dia + $costo_promedio_dia;
                    $total_casos_pro_dia = $total_casos_pro_dia + $casos_promedio_dia;
                endforeach;
            }
            else {
                ?>

                <tr>      

                <td class="nombre_proveedor">No existen casos registrados</td>
                <td class="alignRight">0</td>
                <td class="alignRight">0</td>
                <td class="alignRight">0</td>
                <td class="alignRight">0</td>
                <td class="alignRight">0</td>
                </tr>
    <?php } ?>
        </tbody>
        <tfoot>
            <tr>
            <td class="nombre_proveedor">TOTAL</td>
            <td class="alignRight"><?php echo number_format($totalcantidad, 2, ",", "."); ?></td>
            <td class="alignRight"><?php echo number_format($totalmonto, 2, ",", "."); ?></td>
            <td class="alignRight"><?php echo number_format($total_promedio_casos, 2, ",", "."); ?></td>
            <td class="alignRight"><?php echo number_format($total_costo_pro_dia, 2, ",", "."); ?></td>
            <td class="alignRight"><?php echo number_format($total_casos_pro_dia, 2, ",", "."); ?></td>
            </tr>
        </tfoot>

    </table>
    <!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
    <?php
    echo $var.=ob_get_clean();
    $num = rand(1, 10);
    $dir = 'pdf/index?1=' . $num;

    $aux_paramentros = explode("-", $var_imp);
    $varpdf = '<table class="tableSector" >  
         <tr><td>Cliente: </td><td colspan="3">' . $aux_paramentros[0] . '</td></tr>
                          <tr><td>Contratante: </td><td colspan="3">' . $aux_paramentros[1] . '</td></tr>
                           <tr><td>Tipo de Servicio: </td><td colspan="3">' . $aux_paramentros[2] . '
                               </td></tr>
                        <tr><td>Año: </td><td colspan="3">' . $aux_paramentros[3] . '</td></tr>
                        <tr><td >Mes: </td><td colspan="3">' . $aux_paramentros[4] . '</td>
                        </tr>
                        </table><br /><br />';
    ?>
    <!--FIN-->       
<?php } ?>

</div>              


<!-- Formulario oculto para crear pdf-->
<form method="post" id="targetpdf" action="<?php echo url_for($dir) ?>" target="_blank" hidden="hidden">
    <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Reclamo por tipo de servicio" />
    <textarea id="text_pdf" name="text" rows="2" cols="20"  >
<?php echo $var; ?>
    </textarea>
</form>
<!-- fin-->

<!-- Formulario oculto para crear pdf-->
<form method="post" id="targetimp" action="<?php echo url_for('imprimir/index') ?>" target="_blank" hidden="hidden">
    <input id="titulo_pdf"  name="titulo" type="text" value="Reclamo por tipo de servicio" />
    <textarea id="text_imp" name="text_imp" rows="2" cols="20"  >
<?php echo $var . '<br /><br /><br /><br /><br /><br /><br /><br /><br />'; ?>
    </textarea>

</form>
<!-- fin-->
<!-- Formulario oculto para crear excel-->
<form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
<input id="titulo"  name="titulo" type="text" value="Reclamo por tipo de servicio" />
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
        //$("html").printArea();
        $('#targetimp').submit();
    })
    //    funcion de submit pdf
    $('#url_pdf').click(function() {
        $('#targetpdf').submit();
    }); 
    //Funcion de submit excel
    $('#url_excel').click(function() {
        $('#targetexcel').submit();
    }); 
</script>

