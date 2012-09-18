<!-- Pagina que captura el valor text que es un html y genera el pdf-->
<?php use_helper('Number') ?> 
<?php use_helper('Date'); ?>   


<?php
//  echo $_POST['sql_pdf'];
//    exit;
//print_r($_POST);
//    exit;
$sql = $_POST['sql'];
if ($sql == '') {
    echo "Los datos no pudieron ser procesados";
    exit;
} else {
    $titulo = $_POST['titulo_pdf'];
    $sql = $_POST['sql'];
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF8">
    </head>


    <style type="text/css">
        body{font-size:9px}.tableSector{border-collapse:collapse;text-align:left;margin-bottom:20px;border:1px #eee solid}.tableSector thead{background-color:#0D8661;height:25px;text-align:center;background-image:url("/images/sideBar_coursesMenuBox_titleBackground.png")}.tableSector thead th{padding-left:3px;padding-right:3px;text-align:center;border:1px #fff solid;border-top:2px #04493A solid;font-size:1.2em}.tableSector thead th:hover{background-color:#0B7857}.tableSector thead th a{color:#fff;text-decoration:none}.tableSector thead tr{color:#fff}.alignRight{text-align:right;padding-right:10px;padding-lef:10px}.tableSector tbody{border-bottom:1px #CCC solid;width:600px}.tableSector tbody tr:hover{background-color:#E7F1ED}.tableSector td{border:1px #eee solid;font-size:1.2em}.tableSector tbody .botonadd{padding:5px 5px 5px 7px;background-color:#FFF;border:0 #008265 solid;cursor:pointer;background-image:url('/images/icon_add_down.png');width:20px;height:20px;background-position:left bottom;background-repeat:no-repeat}.tableSector tbody .botonadd:hover{padding:5px 5px 5px 7px;background-color:#FFF;border:0 #008265 solid;cursor:pointer;background-image:url('../images/icon_add_up.png');width:20px;height:20px;background-position:left bottom;background-repeat:no-repeat}.tableSector tfoot{font-weight:700;background-color:#DAE5EE}h1.articleTitle{font-size:1.2em;font-weight:700;color:#007a5e;width:100%;padding:0;margin:0 0 15px}.titulo_detalle{background-color:#0D8661;height:25px;padding-left:20px;font-family:arial;color:#fff;font-weight:700}#detalle td{text-align:left;padding-left:15px;height:25px;padding-right:15px}.titulo_menor_detalle{font-weight:700}.cajas_totales{height:100px;margin-top:10px;margin-bottom:10px}.cajitas_peq_totales{width:220px;border:solid #007a5e 1px;float:left;font-family:Arial, Helvetica, sans-serif;font-size:12px}.linea{height:30px;padding:5px}.linea_media{height:30px;padding:5px;border-top:solid #007a5e 1px}.titulo_cajita{color:#333;font-weight:700}.total_bs{text-align:right;padding-right:10px;float:left;width:50px}.cajitas_peq_totales_med{width:100px;border:solid #007a5e 1px;margin-left:20px;float:left;font-family:Arial, Helvetica, sans-serif;font-size:12px}.titulo_cajita_med{float:left;height:20px;width:100px;color:#333;font-weight:700}.total_bs_med{text-align:right;padding-right:10px;float:left;width:60px}                
    </style>

    <body>

        <img src="./images/logohmo.png"/><br />



        <h1 class="articleTitle"><?php echo $titulo; ?></h1> <br />


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
                        foreach ($sql as $row_tabla):

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
                                                                and cod_tipo_des='$tipo_servicio'
                                                                and codexterno='$contratante'
                                                                and cod_ben_pago='$id_prov'
                                                              ")
                                                ->groupBy('(ci_paciente, id)');
                                        // echo $q_aten."<br />";
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
                                                                    and cod_tipo_des='$tipo_servicio'                                                                  
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
                            $url = 'siniedetaprove/index?cliente=' . $cliente . '&contratante=' . $contratante . '&ano=' . $ano . '&mes=' . $mes . '&tipo_servicio=' . $tipo_servicio . '&servicio=' . $tipo_serv . '&rif=' . $rif . '&tipo_lis=1';
                            ?>

                            <tr>  
                                <td class="nombre_proveedor"><input class="botonadd" type="button" onclick="location.href='<?php echo url_for($url) ?>'" /><?php echo $nombre_prov; ?></td>
                                <td class="nombre_proveedor"></td>
                                <td class="alignRight"><?php echo number_format($cantidad, 2, ",", ".");  ?></td>
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

                            <td>No existen casos registrados</td>
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

        </div>
        <table ><tr>  
                <td class="nombre_proveedor" >Imprimir</td>
                <td class="nombre_proveedor" > Cerrar</td>
        </table>
<?php ?>