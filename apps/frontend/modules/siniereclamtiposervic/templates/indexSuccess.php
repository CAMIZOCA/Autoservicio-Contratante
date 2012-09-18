<?php use_helper('Number') ?> 
<?php use_helper('Date'); ?>
<?php $sf_user->setCulture('es_VE') ?>
<?php
error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('America/Caracas');

function fecha_to_nombre($mes33) {

    switch ($mes33) {
        case '01':
            return $mes_tabla = 'Enero ';
            break;
        case '02':
            return $mes_tabla = 'Febrero ';

            break;
        case '03':
            return $mes_tabla = 'Marzo ';

            break;
        case '04':
            return $mes_tabla = 'Abril ';

            break;
        case '05':
            return $mes_tabla = 'Mayo ';

            break;
        case '06':
            return $mes_tabla = 'Junio ';

            break;
        case '07':
            return $mes_tabla = 'Julio ';

            break;
        case '08':
            return $mes_tabla = 'Agosto ';

            break;
        case '09':
            return $mes_tabla = 'Septiembre ';

            break;
        case '10':
            return $mes_tabla = 'Octubre ';

            break;
        case '11':
            return $mes_tabla = 'Noviembre ';

            break;
        case '12':
            return $mes_tabla = 'Diciembre ';

            break;
    }
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

if (trim($cliente) != '') {
    $CantidadDiasHabiles = Evalua(DiasHabiles($fecha_inicial, $fecha_final));
}
$mes2 = $mes;
?> 
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
                        <li><a href="#">Siniestros</a></li>
                        <li class="last">Reclamos por tipo de servicio</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Reclamos por tipo de servicio </h1>
                <div class="articleBox">
                    <form target="#" id="form1" name="form1" >
                        <?php
                        ob_start();
                        ?>                   
                        <table>                      
                            <tr>
                            <td>Cliente: <input type="hidden" id="indicador" name="indicador" value="1"  /></td>
                            <td colspan="3">
                                <select id="cliente" name="cliente" onChange="llenar_contratantes(this.value);">
                                    <option value="0"  selected="seleted" > - Seleccione una opción - </option>
                                    <?php foreach ($CMB_CLIENTE_MVW as $row): ?>
                                        <option value="<?php echo $row['idepol']; ?>" <?php
                                    if ($cliente == $row['idepol']) {
                                        $cliente_busca = $row['descripcion'];
                                            ?> selected="seleted" <?php } ?>><?php echo $row['descripcion']; ?></option>
                                            <?php endforeach; ?>

                                </select> 
                            </td>
                            </tr>
                            <tr>
                            <td>Contratante: </td>
                            <td colspan="3">
                                <select id="contratante" name="contratante"  onChange="llenar_servicio2(document.getElementById('cliente').value,this.value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?>>
                                    <option value="-1"  selected="seleted" > - Seleccione una opción - </option>  
                                    <option value="todos" <?php if ($contratante == 'todos') { ?> selected="seleted" <?php } ?>>Todos</option>
                                    <?php foreach ($CMB_CONTRATANTE_MVW333 as $row): ?>
                                        <option value="<?php echo $row['CODCTROCOS']; ?>" <?php
                                    if ($contratante == $row['CODCTROCOS']) {
                                        $contratante_busca = $row['DESCTROCOS'];
                                            ?> selected="seleted" <?php } ?>><?php echo $row['DESCTROCOS']; ?>
                                        </option>
                                    <?php endforeach; ?> 
                                </select> 
                            </td>
                            </tr>
                            <tr>
                            <td>Tipo de Servicio: </td>
                            <td colspan="3">
                                <select id="tipo_servicio" name="tipo_servicio" onChange="llenar_ano2(document.getElementById('cliente').value,document.getElementById('contratante').value,document.getElementById('tipo_servicio').value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?>>
                                    <option value="-1"  selected="seleted" > - Seleccione una opción - </option>          
                                    <option value="todos" <?php if ($tipo_servicio == 'todos') { ?> selected="seleted" <?php } ?> >Todos</option>
                                    <?php foreach ($CMB_SERVICIO as $row): ?>
                                        <option value="<?php echo $row['COD_TIPO_DES']; ?>" <?php
                                    if ($tipo_servicio == $row['COD_TIPO_DES']) {
                                        $servicio_busca = $row['TIPO_DES'];
                                            ?> selected="selected" <?php } ?>><?php echo $row['TIPO_DES']; ?>
                                        </option>
                                    <?php endforeach; ?> 
                                </select> 
                            </td>
                            </tr>

                            <tr>
                            <td>Año: </td>
                            <td colspan="3">
                                <select id="ano" name="ano" onchange="llenar_tipo_mes2(document.getElementById('cliente').value,document.getElementById('contratante').value,document.getElementById('tipo_servicio').value,this.value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?> >
                                    <option value="-1"  selected="seleted" > - Seleccione una opción - </option>
                                    <?php foreach ($CMB_ANNO_GENERAL3 as $row): ?>
                                        <option value="<?php echo $row['ANNO']; ?>" <?php
                                    if ($ano == $row['ANNO']) {
                                        $ano_busca = $row['ANNO'];
                                            ?> selected="seleted" <?php } ?> ><?php echo $row['ANNO']; ?></option>
                                            <?php endforeach; ?>

                                </select> 
                            </td>
                            </tr>
                            <tr>
                            <td >Mes: </td>
                            <td colspan="3">
                                <select id="mes"  name="mes" onchange="document.getElementById('habil_fecha').style.display='block'; fecha_incio_fin(document.getElementById('cliente').value,document.getElementById('contratante').value,document.getElementById('tipo_servicio').value,document.getElementById('ano').value,this.value);" <?php if (trim($indicador) != 1) { ?>  disabled ="true" <?php } ?>>
                                    <option value="-1"  selected="seleted" > - Seleccione una opción - </option> 
                                    <option value="0" <?php if ($mes2 == 0) { ?>  selected="seleted" <?php } ?> > Todos </option> 
                                    <?php
                                    foreach ($CMB_MES as $row):
                                        $anno = $row['ANNO'];
                                        $mes33 = $row['MES'];
                                        $mes_tabla = fecha_to_nombre($row['MES']);
                                        ?>
                                        <option value="<?php echo $mes33; ?>" <?php
                                    if ($mes2 == $mes33) {
                                        $mes_busca = $anno . ' ' . $mes_tabla;
                                            ?> selected="seleted" <?php } ?> ><?php echo $anno . ' ' . $mes_tabla; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select> 
                            </td>
                            </tr>
                        </table>
                        <div id="habil_fecha" style="margin-top:10px; margin-bottom:10px;  <?php if (trim($indicador) != 1 or trim($atras) == 1) { ?> display:none; <?php } ?>">
                            <table>    
                                <tr>
                                <td height="21" width="95">Días:</td>
                                <td height="21" width="95"> <input name="dias_mes" id="dias_mes" value="<?php echo $dias_mes; ?>" readonly="true" size="5"  class="deshabilitados" /></td>
                                <td  width="95">Días Hábiles:</td>
                                <td ><input name="dias_habiles" id="dias_habiles" value="<?php echo $CantidadDiasHabiles; ?>" readonly="true" size="5" class="deshabilitados" /></td>
                                </tr>                                
                                <tr>
                                <td height="21" >Fecha Inicio:</td>
                                <td height="21" > <input name="inicio" id="inicio" value="<?php echo $fecha_inicial; ?>" readonly="true" size="10" class="deshabilitados"/></td>
                                <td  width="90">Fecha Fin:</td>
                                <td ><input name="fin" id="fin" value="<?php echo $fecha_final; ?>" readonly="true" size="10" class="deshabilitados" /></td>
                                </tr>    
                            </table>
                        </div>
                        <?php
                        echo $var2 = ob_get_clean();
                        $var2.='<br />';
                        if (trim($contratante_busca) == '') {
                            $contratante_busca = 'Todos';
                        }
                        if (trim($servicio_busca) == '') {
                            $servicio_busca = 'Todos';
                        }
                        if (trim($ano_busca) == '') {
                            $ano_busca = 'Todos';
                        }
                        if (trim($mes_busca) == '') {
                            $mes_busca = 'Todos';
                        }

                        $varpdf = '
                                <table class="tableSector" >  
                                <tr><td>11Cliente: </td><td colspan="3">' . $cliente_busca . '</td></tr>
                                <tr><td>Contratante: </td><td colspan="3">' . $contratante_busca . '</td></tr>
                                <tr><td>Tipo de Servicio: </td><td colspan="3">' . $servicio_busca . '</td></tr>
                                <tr><td>Año: </td><td colspan="3">' . $ano_busca . '</td></tr>
                                <tr><td >Mes: </td><td colspan="3">' . $mes_busca . '</td>
                                </tr>
                                </table>
                                <br />
                                <br />';
                        ?>
                        <table style="margin-top:5px;">
                            <tr>   
                            <td>
                                <input  type="hidden" id="var_imp" name="var_imp"  value='' />
                                <input  type="submit" id="btn_getvalues" class="btn_buscar" value="Buscar" />
                            </td>
                            </tr>
                        </table>
                    </form>


                    <!-- INICIO -->
                    <div class="clear" style="padding-bottom:30px;"></div>
                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />
                    <!-- INICIO PANTALLAS BACKEND -->
                    <div id="cargando" style="display: none;"><img src="/images/green-loading.gif" style="text-align: center" />&nbsp;</div>          
                    <div id="showTable" name="show" >
                        <?php if ($cuantos_tabla_inicial != 0) { ?>
                            <!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
                            <?php
                            ob_start();
                            ?>
                            <!-- FIN-->
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
                                            $monto_servicio = $row_tabla['total'];
                                            $promedio_casos = $monto_servicio / $cantidad;
                                            $costo_promedio_dia = $promedio_casos / $dias_mes;
                                            $casos_promedio_dia = $cantidad / $dias_mes;
                                            $url = 'siniedetageneral/index?cliente=' . $cliente . '&contratante=' . $contratante . '&ano=' . $ano . '&mes=' . $mes . '&tipo_servicio=' . $id_tipo_serv . '&servicio=' . $tipo_serv . '&tipo_lis=1';
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
                            echo $var = ob_get_clean();
                            $num = rand(1, 10);
                            $dir = 'pdf/index?1=' . $num;

                            $parametros = '';
                            ?>
                            <!--FIN-->       

                            <!-- Formulario oculto para crear pdf-->
                            <form method="post" id="targetpdf" action="<?php echo url_for($dir) ?>" target="_blank" hidden="hidden">
                                <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Reclamo por tipo de servicio" />
                                <textarea id="text_pdf" name="text" rows="2" cols="20"  >
                                    <?php echo $varpdf . $var; ?>
                                </textarea>
                            </form>
                            <!-- fin--> 

                            <!-- Formulario oculto para crear pdf-->
                            <form method="post" id="targetimp" action="<?php echo url_for('imprimir/index') ?>" target="_blank" hidden="hidden">
                                <input id="titulo_pdf"  name="titulo" type="text" value="Reclamo por tipo de servicio" />
                                <textarea id="text_imp" name="text_imp" rows="2" cols="20"  >
                                    <?php echo $var2 . $var . '<br /><br /><br /><br /><br /><br /><br /><br /><br />'; ?>
                                </textarea>

                            </form>
                            <!-- fin-->
                            <!-- Formulario oculto para crear excel-->
                            <form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
                                <input id="titulo"  name="titulo" type="text" value="Reclamo por tipo de servici" />
                                <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
                            </form>
                            <!-- fin-->

                            <hr style="background-color:#E8E8E8; height:2px; border:0;" />


                            <table class="sectorBottomMenu">
                                <tr>
                                <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
                                <td><a href="javascript:void(0)" id="url_pdf">PDF11</a></td>
                                <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                
                                </tr>                        
                            </table>
                        </div>              




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
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(function() {
        $("#btn_getvalues").click(function() {
            $("#cargando").css("display", "inline");
            $("#showTable").load("<?php echo url_for('siniereclamtiposervic/gettable') ?>",{ 
                cliente:         $("#cliente option:selected").val() ,
                contratante :    $("#contratante option:selected").val() ,
                ano :           $("#ano option:selected").val() ,
                mes :            $("#mes option:selected").val() ,
                tipo_servicio :        $("#tipo_servicio option:selected").val(),
                dias_habiles :        $("#dias_habiles").val(),
                var_imp:           $("#var_imp").val()
            });
            return false;
        });
    });


    function llenar_contratantes(a)
    {
        var n = document.forms.form1.contratante.length;

        //alert(a);
  
        for (var i=0; i<n;++i){      
            document.forms.form1.contratante.remove(document.forms.form1.contratante.options[i]);//eliminar lineas del 2do combo...
        }
        document.forms.form1.contratante[0]= new Option("- Seleccione una opción -",'-1'); 
        document.forms.form1.contratante[1]= new Option("Todos",'todos'); //creamos primera linea del segundo combo

 
<?php
foreach ($CMB_CLIENTE_MVW as $row_c):
    $id_pol = $row_c['idepol'];
    ?> 
                                                               
                                    	   	
                if (a== '<?php echo $id_pol; ?>'){

    <?php
    $valorwhere = 'idepol=' . $id_pol;
    $q = Doctrine_Query::create()
            ->from('CMB_CONTRATANTE_MVW  J')
            ->where($valorwhere);
    $CONTRATO_POLIZA_VW_filtrado = $q->fetchArray();
    foreach ($CONTRATO_POLIZA_VW_filtrado as $row_pf):
        $id_pol2 = $row_pf['codctrocos'];
        $des_contratante = $row_pf['desctrocos'];
        ?>
                            document.forms.form1.contratante[document.forms.form1.contratante.length]= new Option("<?php echo $des_contratante; ?>",'<?php echo $id_pol2; ?>'); 
    <?php endforeach; ?>
                }
<?php endforeach; ?>
        document.forms.form1.contratante.disabled=false;
        document.getElementById('habil_fecha').style.display="none";
    }
 
 
    function llenar_servicio2(cliente,contratante)
    {
        document.getElementById('tipo_servicio').disabled=false;
        document.getElementById('ano').disabled=true;
        document.getElementById('mes').disabled=true;
 
        var n = document.forms.form1.tipo_servicio.length;

        //alert(a);
        for (var i=0; i<n;++i){      
            document.forms.form1.tipo_servicio.remove(document.forms.form1.tipo_servicio.options[i]);//eliminar lineas del 2do combo...
        }
   
        document.forms.form1.tipo_servicio[0]= new Option("- Seleccione una opción -",'-1');//creamos primera linea del segundo combo
        document.forms.form1.tipo_servicio[1]= new Option("Todos",'todos');//creamos primera linea del segundo combo
  
        if(contratante=='' || contratante=='todos'){
<?php
foreach ($CMB_CLIENTE_MVW as $row_c):
    $id_pol = $row_c['idepol'];
    ?> 
                                                         
                    if (cliente== '<?php echo $id_pol; ?>'){

    <?php
    $q22 = Doctrine_Query::create()
            ->select("cod_tipo_des, tipo_des, id")
            ->from('SINIESTRALIDAD_VW  J')
            ->where(" idepol='$id_pol'")
            ->groupBy("cod_tipo_des, tipo_des, id")
            ->orderBy(" tipo_des ASC");

    $CMB_SERVICIO = $q22->fetchArray();

    foreach ($CMB_SERVICIO as $row_pf):
        $cod_tipo_des = $row_pf['cod_tipo_des'];
        $tipo_des = $row_pf['tipo_des'];
        ?>                        
                                                                                    
                                document.forms.form1.tipo_servicio[document.forms.form1.tipo_servicio.length]= new Option("<?php echo $tipo_des; ?>",'<?php echo $cod_tipo_des; ?>'); 
    <?php endforeach; ?>
                                                
                    }
<?php endforeach; ?>
           
        }
        else{
<?php
foreach ($CMB_CONTRATANTE_MVW333 as $rowcontratante):
    $codctrocos = $rowcontratante['CODCTROCOS'];
    ?> 
                                                            
                    if(contratante=='<?php echo $codctrocos; ?>'){
    <?php
    $q22 = Doctrine_Query::create()
            ->select("cod_tipo_des, tipo_des, id")
            ->from('SINIESTRALIDAD_VW  J')
            ->where(" idepol='$id_pol' and codexterno='$codctrocos'")
            ->groupBy("cod_tipo_des, tipo_des, id")
            ->orderBy(" tipo_des ASC");

    $CMB_SERVICIO = $q22->fetchArray();

    foreach ($CMB_SERVICIO as $row_pf):
        $cod_tipo_des = $row_pf['cod_tipo_des'];
        $tipo_des = $row_pf['tipo_des'];
        ?>                        
                                                                                    
                                document.forms.form1.tipo_servicio[document.forms.form1.tipo_servicio.length]= new Option("<?php echo $tipo_des; ?>",'<?php echo $cod_tipo_des; ?>'); 
    <?php endforeach; ?>
                    }
<?php endforeach; ?>
             
           
        } 
 
   
        document.getElementById('habil_fecha').style.display="none";
    }


    function llenar_ano2(cliente,contratante,servicio)
    {
 
        document.getElementById('mes').disabled=true;
        var n = document.forms.form1.ano.length;
        var n2 = document.forms.form1.mes.length;
  
        for (var i=0; i<n2;++i){      
            document.forms.form1.mes.remove(document.forms.form1.mes.options[i]);//eliminar lineas del 2do combo...
        }
  
        document.forms.form1.mes[0]= new Option("- Seleccione una opción -",'-1');


        //alert(a);
        for (var i=0; i<n;++i){      
            document.forms.form1.ano.remove(document.forms.form1.ano.options[i]);//eliminar lineas del 2do combo...
        }
   
        document.forms.form1.ano[0]= new Option("- Seleccione una opción -",'-1');//creamos primera linea del segundo combo

        if(contratante=='' || contratante=='todos'){
<?php
foreach ($CMB_CLIENTE_MVW as $row_c):
    $id_pol = $row_c['idepol'];
    ?> 
                                                               
                                    	   	
                    if (cliente== '<?php echo $id_pol; ?>'){

                        //alert("Milaaaaaaaaaaa holaaaaaaaa");
                                                
                        if(servicio=='todos'){
    <?php
    $valorwhere = 'idepol=' . $id_pol;
    $q = Doctrine_Query::create()
            ->select("to_char(fecocurr, 'yyyy') as anno")
            ->from("SINIESTRALIDAD_VW   J")
            ->where($valorwhere)
            //    if(servicio=='todos'){->where("codexterno=", $varTmp)    
            ->groupBy("to_char(fecocurr, 'yyyy')");

    $CMB_ANNO = $q->fetchArray();

    //$CONTRATO_POLIZA_VW_filtrado  = $q->fetchArray(); 
    foreach ($CMB_ANNO as $row_pf):
        $anno = $row_pf['anno'];
        ?>
                                    //  echo $id_pol2."<br />";
                                    document.forms.form1.ano[document.forms.form1.ano.length]= new Option("<?php echo $anno; ?>",'<?php echo $anno; ?>'); 
    <?php endforeach;
    ?>
                                                
                        }
                        else{
    <?php
    $q2_servicio = Doctrine_Query::create()
            ->select("cod_tipo_des, tipo_des, id")
            ->from('SINIESTRALIDAD_VW  J')
            ->groupBy("cod_tipo_des, tipo_des, id")
            ->orderBy(" tipo_des ASC");
    $CMB_SERVICIO = $q2_servicio->fetchArray();
    foreach ($CMB_SERVICIO as $row_ser):
        $cod_tipo_des = $row_ser['cod_tipo_des'];
        ?> 
                                    if(servicio==<?php echo $cod_tipo_des ?>){
        <?php
        $valorwhere = 'idepol=' . $id_pol;
        $q = Doctrine_Query::create()
                ->select("to_char(fecocurr, 'yyyy') as anno")
                ->from("SINIESTRALIDAD_VW   J")
                ->where("idepol='$id_pol' and cod_tipo_des='$cod_tipo_des' ")
                ->groupBy(" to_char(fecocurr, 'yyyy')");

        $CMB_ANNO = $q->fetchArray();
        foreach ($CMB_ANNO as $row_pf):
            $anno = $row_pf['anno'];
            ?>
                                                //  echo $id_pol2."<br />";
                                                document.forms.form1.ano[document.forms.form1.ano.length]= new Option("<?php echo $anno; ?>",'<?php echo $anno; ?>'); 
        <?php endforeach; ?>    
                                    }
    <?php endforeach; ?>
                        }
                                                
                    }
<?php endforeach; ?>
           
        }
        else{
         
<?php
foreach ($CMB_CONTRATANTE_MVW333 as $rowcontratante):
    $codctrocos = $rowcontratante['CODCTROCOS'];
    ?> 
                    ///// alert ("AAAAAAAAAAAAAAAAAAAAAAA"+contratante);          
                    if(contratante=='<?php echo $codctrocos; ?>'){
                        if(servicio=='todos'){
    <?php
    $valorwhere = ' CODEXTERNO=' . $codctrocos;
    $q33 = Doctrine_Query::create()
            ->select("to_char(fecocurr, 'yyyy') as anno")
            ->from("SINIESTRALIDAD_VW   J")
            ->where(" codexterno ='$codctrocos'")
            // ->where(" codexterno= ", $codctrocos)    
            ->groupBy("to_char(fecocurr, 'yyyy')");

    $CMB_ANNO = $q33->fetchArray();

    foreach ($CMB_ANNO as $row_pf):
        $anno = $row_pf['anno'];
        ?>
                                                                                  
                                    document.forms.form1.ano[document.forms.form1.ano.length]= new Option("<?php echo $anno; ?>",'<?php echo $anno; ?>'); 
    <?php endforeach;
    ?>
                        }
                        else{
    <?php
    $q2_servicio = Doctrine_Query::create()
            ->select("cod_tipo_des, tipo_des, id")
            ->from('SINIESTRALIDAD_VW  J')
            ->groupBy("cod_tipo_des, tipo_des, id")
            ->orderBy(" tipo_des ASC");
    $CMB_SERVICIO = $q2_servicio->fetchArray();

    foreach ($CMB_SERVICIO as $row_ser):
        $cod_tipo_des = $row_ser['cod_tipo_des'];
        ?> 
                                    if(servicio==<?php echo $cod_tipo_des ?>){
        <?php
        $valorwhere = 'idepol=' . $id_pol;
        $q = Doctrine_Query::create()
                ->select("to_char(fecocurr, 'yyyy') as anno")
                ->from("SINIESTRALIDAD_VW   J")
                ->where("codexterno ='$codctrocos' and idepol='$id_pol' and cod_tipo_des='$cod_tipo_des' ")
                ->groupBy(" to_char(fecocurr, 'yyyy')");

        $CMB_ANNO = $q->fetchArray();
        foreach ($CMB_ANNO as $row_pf):
            $anno = $row_pf['anno'];
            ?>
                                                //  echo $id_pol2."<br />";
                                                document.forms.form1.ano[document.forms.form1.ano.length]= new Option("<?php echo $anno; ?>",'<?php echo $anno; ?>'); 
        <?php endforeach; ?>    
                                    }
    <?php endforeach; ?>
                        }                    
                                                      
                    }
<?php endforeach; ?>
             
           
        } 
 
        document.getElementById('ano').disabled=false;
        document.getElementById('habil_fecha').style.display="none"; 
    }


    function llenar_tipo_mes2(cliente,contratante,servicio,ano)
    {
        var n = document.forms.form1.mes.length;

        //alert(a);
  
        //document.getElementById('tipo_servicio').disabled=true;
        for (var i=0; i<n;++i){      
            document.forms.form1.mes.remove(document.forms.form1.mes.options[i]);//eliminar lineas del 2do combo...
        }
   
        document.forms.form1.mes[0]= new Option("- Seleccione una opción -",'-1');//creamos primera linea del segundo combo
        document.forms.form1.mes[1]= new Option("Todos",'0');

        if(contratante=='' || contratante=='todos'){
<?php
foreach ($CMB_CLIENTE_MVW as $row_c):
    $id_pol = $row_c['idepol'];
    ?> 	
                    if (cliente== '<?php echo $id_pol; ?>'){
    <?php
    $q = Doctrine_Query::create()
            ->select("to_char(FECOCURR,'yyyy') as anno")
            ->from('SINIESTRALIDAD_VW  J')
            ->groupBy("to_char(fecocurr,'yyyy')")
            ->orderBy("to_char(FECOCURR,'yyyy') asc");

    $CMB_ANNO_GENERAL2 = $q->fetchArray();
    ?>
                                                
    <?php
    foreach ($CMB_ANNO_GENERAL2 as $row_ano2):
        $anno = $row_ano2['anno'];
        ?>
                                                                                                        
                                                                                    
                                if(ano=='<?php echo $anno; ?>'){
                                                                                        
                                    if(servicio=='todos'){  
        <?php
        $valorwhere = "idepol=" . $id_pol . " and to_char(FECOCURR,'yyyy')=" . $anno;
        $q = Doctrine_Query::create()
                ->select("to_char(FECOCURR,'mm') as mes, to_char(FECOCURR,'yyyy') as anno")
                ->from('SINIESTRALIDAD_VW  J')
                ->where($valorwhere)
                ->groupBy("to_char(fecocurr,'mm'),to_char(fecocurr,'yyyy')")
                ->orderBy("to_char(FECOCURR,'yyyy') asc, to_char(FECOCURR,'mm') asc");

        $CMB_MES = $q->fetchArray();



        //$CONTRATO_POLIZA_VW_filtrado  = $q->fetchArray(); 
        foreach ($CMB_MES as $row_pf):
            $anno = $row_pf['anno'];
            $mes = $row_pf['mes'];

            switch ($mes) {
                case '01':
                    $mes_tabla = 'Enero ';
                    break;
                case '02':
                    $mes_tabla = 'Febrero ';

                    break;
                case '03':
                    $mes_tabla = 'Marzo ';

                    break;
                case '04':
                    $mes_tabla = 'Abril ';

                    break;
                case '05':
                    $mes_tabla = 'Mayo ';

                    break;
                case '06':
                    $mes_tabla = 'Junio ';

                    break;
                case '07':
                    $mes_tabla = 'Julio ';

                    break;
                case '08':
                    $mes_tabla = 'Agosto ';

                    break;
                case '09':
                    $mes_tabla = 'Septiembre ';

                    break;
                case '10':
                    $mes_tabla = 'Octubre ';

                    break;
                case '11':
                    $mes_tabla = 'Noviembre ';

                    break;
                case '12':
                    $mes_tabla = 'Diciembre ';

                    break;
            }
            ?>

                                                document.forms.form1.mes[document.forms.form1.mes.length]= new Option("<?php echo $anno . ' ' . $mes_tabla; ?>",'<?php echo $mes; ?>'); 
        <?php endforeach; ?>
                                    }// servicio
                                    else{
        <?php
        $q2_servicio = Doctrine_Query::create()
                ->select("cod_tipo_des, tipo_des, id")
                ->from('SINIESTRALIDAD_VW  J')
                ->groupBy("cod_tipo_des, tipo_des, id")
                ->orderBy(" tipo_des ASC");
        $CMB_SERVICIO = $q2_servicio->fetchArray();

        foreach ($CMB_SERVICIO as $row_ser):
            $cod_tipo_des = $row_ser['cod_tipo_des'];
            ?> 
                                                if(servicio==<?php echo $cod_tipo_des; ?>){
            <?php
            $valorwhere = "idepol=" . $id_pol . " and to_char(FECOCURR,'yyyy')='" . $anno . "' and cod_tipo_des='" . $cod_tipo_des . "'";
            $q = Doctrine_Query::create()
                    ->select("to_char(FECOCURR,'mm') as mes, to_char(FECOCURR,'yyyy') as anno")
                    ->from('SINIESTRALIDAD_VW  J')
                    ->where($valorwhere)
                    ->groupBy("to_char(fecocurr,'mm'),to_char(fecocurr,'yyyy')")
                    ->orderBy("to_char(FECOCURR,'yyyy') asc, to_char(FECOCURR,'mm') asc");

            $CMB_MES = $q->fetchArray();



            //$CONTRATO_POLIZA_VW_filtrado  = $q->fetchArray(); 
            foreach ($CMB_MES as $row_pf):
                $anno = $row_pf['anno'];
                $mes = $row_pf['mes'];

                switch ($mes) {
                    case '01':
                        $mes_tabla = 'Enero ';
                        break;
                    case '02':
                        $mes_tabla = 'Febrero ';

                        break;
                    case '03':
                        $mes_tabla = 'Marzo ';

                        break;
                    case '04':
                        $mes_tabla = 'Abril ';

                        break;
                    case '05':
                        $mes_tabla = 'Mayo ';

                        break;
                    case '06':
                        $mes_tabla = 'Junio ';

                        break;
                    case '07':
                        $mes_tabla = 'Julio ';

                        break;
                    case '08':
                        $mes_tabla = 'Agosto ';

                        break;
                    case '09':
                        $mes_tabla = 'Septiembre ';

                        break;
                    case '10':
                        $mes_tabla = 'Octubre ';

                        break;
                    case '11':
                        $mes_tabla = 'Noviembre ';

                        break;
                    case '12':
                        $mes_tabla = 'Diciembre ';

                        break;
                }
                ?>
                                                            //  echo $id_pol2."<br />";
                                                            document.forms.form1.mes[document.forms.form1.mes.length]= new Option("<?php echo $anno . ' ' . $mes_tabla; ?>",'<?php echo $mes; ?>'); 
            <?php endforeach; ?>   
                                                }                            
        <?php endforeach; ?>                           
                                    }/// servcio else
                                                                                 
                                                                                 
                                }
    <?php endforeach;
    ?>
                    }
<?php endforeach; ?>
           
        }
        else{////ESTE ES EL PRINCIPAL
             
<?php
$q_contra = Doctrine_Query::create()
        ->select("codctrocos, desctrocos ")
        ->from('CMB_CONTRATANTE_MVW  J')
        ->orderBy("desctrocos ASC");

$CMB_CONTRATANTE_MVW55 = $q_contra->fetchArray();
?>
            //alert ("<?php echo $q_contra; ?>"); 
<?PHP
foreach ($CMB_CONTRATANTE_MVW55 as $row_con):
    $id_contratante = $row_con['codctrocos'];
    ?>
                    //alert ("<?php echo $id_contratante; ?>");          
                    if(contratante=='<?php echo $id_contratante; ?>'){
                                               
    <?php
    foreach ($CMB_CLIENTE_MVW as $row_c):
        $id_pol = $row_c['idepol'];
        ?> 	
                                if (cliente== '<?php echo $id_pol; ?>'){
        <?php
        $q = Doctrine_Query::create()
                ->select("to_char(FECOCURR,'yyyy') as anno")
                ->from('SINIESTRALIDAD_VW  J')
                ->groupBy("to_char(fecocurr,'yyyy')")
                ->orderBy("to_char(FECOCURR,'yyyy') asc");

        $CMB_ANNO_GENERAL2 = $q->fetchArray();
        ?>
                                                                                    
        <?php
        foreach ($CMB_ANNO_GENERAL2 as $row_ano2):
            $anno = $row_ano2['anno'];
            ?>
                                            if(ano=='<?php echo $anno; ?>'){
                                                if(servicio=='todos'){  
            <?php
            $valorwhere = "idepol=" . $id_pol . " and codexterno='" . $id_contratante . "' and to_char(FECOCURR,'yyyy')=" . $anno;
            $q_mes = Doctrine_Query::create()
                    ->select("to_char(FECOCURR,'mm') as mes, to_char(FECOCURR,'yyyy') as anno")
                    ->from('SINIESTRALIDAD_VW  J')
                    ->where($valorwhere)
                    ->groupBy("to_char(fecocurr,'mm'),to_char(fecocurr,'yyyy')")
                    ->orderBy("to_char(FECOCURR,'yyyy') asc, to_char(FECOCURR,'mm') asc");

            $CMB_MES = $q_mes->fetchArray();
            ?>
                                                    //alert ("paso");
                                                    //alert("<?php echo $q_mes; ?>");
                                                                                                                     
                                                                                                                        
                                                    //$CONTRATO_POLIZA_VW_filtrado  = $q->fetchArray(); 
            <?php
            foreach ($CMB_MES as $row_pf):
                $anno = $row_pf['anno'];
                $mes = $row_pf['mes'];

                switch ($mes) {
                    case '01':
                        $mes_tabla = 'Enero ';
                        break;
                    case '02':
                        $mes_tabla = 'Febrero ';

                        break;
                    case '03':
                        $mes_tabla = 'Marzo ';

                        break;
                    case '04':
                        $mes_tabla = 'Abril ';

                        break;
                    case '05':
                        $mes_tabla = 'Mayo ';

                        break;
                    case '06':
                        $mes_tabla = 'Junio ';

                        break;
                    case '07':
                        $mes_tabla = 'Julio ';

                        break;
                    case '08':
                        $mes_tabla = 'Agosto ';

                        break;
                    case '09':
                        $mes_tabla = 'Septiembre ';

                        break;
                    case '10':
                        $mes_tabla = 'Octubre ';

                        break;
                    case '11':
                        $mes_tabla = 'Noviembre ';

                        break;
                    case '12':
                        $mes_tabla = 'Diciembre ';

                        break;
                }
                ?>
                                                            document.forms.form1.mes[document.forms.form1.mes.length]= new Option("<?php echo $anno . ' ' . $mes_tabla; ?>",'<?php echo $mes; ?>'); 
                                                                                                                                                               
            <?php endforeach; ?>
                                                }// servicio
                                                else{
            <?php
            $q2_servicio = Doctrine_Query::create()
                    ->select("cod_tipo_des, tipo_des, id")
                    ->from('SINIESTRALIDAD_VW  J')
                    ->groupBy("cod_tipo_des, tipo_des, id")
                    ->orderBy(" tipo_des ASC");
            $CMB_SERVICIO = $q2_servicio->fetchArray();

            foreach ($CMB_SERVICIO as $row_ser):
                $cod_tipo_des = $row_ser['cod_tipo_des'];
                ?> 
                                                            if(servicio==<?php echo $cod_tipo_des; ?>){
                <?php
                $valorwhere = "idepol='" . $id_pol . "' and codexterno='" . $id_contratante . "'  and to_char(FECOCURR,'yyyy')=" . $anno . " and cod_tipo_des='" . $cod_tipo_des . "'";
                $q = Doctrine_Query::create()
                        ->select("to_char(FECOCURR,'mm') as mes, to_char(FECOCURR,'yyyy') as anno")
                        ->from('SINIESTRALIDAD_VW  J')
                        ->where($valorwhere)
                        ->groupBy("to_char(fecocurr,'mm'),to_char(fecocurr,'yyyy')")
                        ->orderBy("to_char(FECOCURR,'yyyy') asc, to_char(FECOCURR,'mm') asc");

                $CMB_MES = $q->fetchArray();



                //$CONTRATO_POLIZA_VW_filtrado  = $q->fetchArray(); 
                foreach ($CMB_MES as $row_pf):
                    $anno = $row_pf['anno'];
                    $mes = $row_pf['mes'];

                    switch ($mes) {
                        case '01':
                            $mes_tabla = 'Enero ';
                            break;
                        case '02':
                            $mes_tabla = 'Febrero ';
                            break;
                        case '03':
                            $mes_tabla = 'Marzo ';
                            break;
                        case '04':
                            $mes_tabla = 'Abril ';
                            break;
                        case '05':
                            $mes_tabla = 'Mayo ';
                            break;
                        case '06':
                            $mes_tabla = 'Junio ';

                            break;
                        case '07':
                            $mes_tabla = 'Julio ';

                            break;
                        case '08':
                            $mes_tabla = 'Agosto ';

                            break;
                        case '09':
                            $mes_tabla = 'Septiembre ';

                            break;
                        case '10':
                            $mes_tabla = 'Octubre ';

                            break;
                        case '11':
                            $mes_tabla = 'Noviembre ';

                            break;
                        case '12':
                            $mes_tabla = 'Diciembre ';

                            break;
                    }
                    ?>
                                                                        //  echo $id_pol2."<br />";
                                                                        document.forms.form1.mes[document.forms.form1.mes.length]= new Option("<?php echo $anno . ' ' . $mes_tabla; ?>",'<?php echo $mes; ?>'); 
                <?php endforeach; ?>   
                                                            }                            
            <?php endforeach; ?>                           
                                                }/// servcio else
                                                                                                                    
                                                                                                                    
                                                                                                                    
                                            }
        <?php endforeach; ?> 
                                }   
    <?php endforeach; ?>
                    }
<?php endforeach; ?>
        }///ESTE ES EL PRINCIPAL
        document.getElementById('mes').disabled=false;
        document.getElementById('habil_fecha').style.display="none";
        //document.getElementById('tipo_servicio').disabled=false;
    }
 
</script>
