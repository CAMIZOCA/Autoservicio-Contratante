<?php
use_helper('Number');
use_helper('Date');
?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php
//error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

//echo $mes;
//echo "<h1>$greetings</h1>";
//$temp55=$_POST['mes'];
//$valor_get=
//echo "parametros:".$valor_get;
/* $cliente=$sf_params->get('cliente');
  $tipo_servicio=$sf_params->get('tipo_servicio');
  $ano=$sf_params->get('ano');
  $mes=$sf_params->get('mes');
  $contratante=$sf_params->get('contratante');


  //echo "Cliente:".$sf_params->get('cliente')."<br />";
  // echo "Servicio:".$tipo_servicio."<br />";
  echo "ano:".$sf_params->get('ano')."<br />";
  /* echo "mes:".$sf_params->get('mes')."<br />";
  echo "contratante:".$sf_params->get('contratante')."<br />";
  //$ano_actual=date('Y'); */
//echo $ano_actual;

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

///echo "Este valor".$cuantos_tabla_inicial;
$mes2 = $mes;
//echo "meeees".$mes;
/// echo "Total ".$cuantos_tabla_inicial;
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
                        <li class="last"><?php echo "Detalles de   ";
            echo ucfirst(strtr(strtolower($servicio), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú"));
            ?></li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle"><?php echo "Detalles de  ";
            echo ucfirst(strtr(strtolower($servicio), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú"));
            ?></h1>
                <div class="articleBox">
                    <form  id="form1"  name="form1" action="<?php echo url_for('sinielistadpatolo/index') ?>" method="post">
                        <table>
                                    <?php //echo $form;   ?>
                            <tr><td>Cliente: </td><td colspan="3"><select id="cliente" name="cliente" onChange="llenar_contratantes(this.value);" disabled ="true" class="deshabilitados">
<?php foreach ($CMB_CLIENTE_MVW as $row): ?>
                                        <option value="<?php echo $row['idepol']; ?>" <?php if ($cliente == $row['idepol']) { ?> selected="seleted" <?php } ?>><?php echo $row['descripcion']; ?></option>
<?php endforeach; ?>

                                </select> </td></tr>
                            <tr><td>Contratante: </td><td colspan="3"><select id="contratante" name="contratante" disabled ="true" class="deshabilitados">
                                    <option value="todos" selected="selected" >Todos</option>
<?php foreach ($CMB_CONTRATANTE_MVW as $row): ?>
                                        <option value="<?php echo $row['codctrocos']; ?>" <?php if ($contratante == $row['codctrocos']) { ?> selected="seleted" <?php } ?>><?php echo $row['desctrocos']; ?></option>
<?php endforeach; ?>

                                </select> </td></tr>
                            <tr><td>Tipo de Servicio: </td><td colspan="3">
                                <select id="tipo_servicio" name="tipo_servicio" disabled ="true" class="deshabilitados">
                                    <option value="todos" <?php if ($tipo_servicio == '' or $tipo_servicio == 'todos') { ?> selected="selected" <?php $servicio_busca = 'todos';
}
?>>Todos</option>
<?php foreach ($SINIESTRALIDAD_VW_combo_servicios as $row): ?>
                                        <option value="<?php echo $row['cod_tipo_des']; ?>" <?php if ($tipo_servicio == $row['cod_tipo_des']) { ?> selected="selected" <?php $servicio_busca = $row['tipo_des'];
    }
    ?>><?php echo $row['tipo_des']; ?></option>
                                    <?php endforeach; ?> 
                                </select> </td></tr>
                            <tr>
                            <tr><td>Año: </td><td colspan="3"><select id="ano" name="ano" onchange="fechas_mes(document.forms.form1.mes.value,this.value,'<?php echo $es_bisiesto; ?>');" disabled ="true" class="deshabilitados">
                                        <!--<option value="0"  <?php if ($ano == '0') { ?> selected="selected" <?php } ?>  >Todos</option>--> 
<?php foreach ($SINIESTRALIDAD_VW_combo_ano as $row): ?>
                                        <option value="<?php echo $row['ano']; ?>" <?php if ($ano == $row['ano']) { ?> selected="selected" <?php } ?>><?php echo $row['ano']; ?></option>
                                <?php endforeach; ?>
                                <!--<option value="2012" <?php if ($ano == 2012) { ?> selected="selected" <?php } ?>>2012</option>
                                <option value="2011" <?php if ($ano == 2011) { ?> selected="selected" <?php } ?> >2011</option>-->
                                </select> </td></tr>
                            <tr><td >Mes: </td><td colspan="3">
<?php
//echo "fecha_inicial:".$fecha_inicial."<br />"; 
//echo "messss 2:".$mes2."<br />"; 
?>
                                <select id="mes"  name="mes" onchange="fechas_mes(this.value,document.forms.form1.ano.value,'<?php echo $es_bisiesto; ?>');eliminarPais(document.forms.form1.inicio.value,document.forms.form1.fin.value), num_dias(this.value,document.forms.form1.ano.value);" disabled ="true" class="deshabilitados">
                                    <option value="0"  <?php if ($mes == '0') { ?> selected="selected" <?php } ?>  >Todos</option>                                    
                                    <option value="01" <?php if ($mes == '01') { ?> selected="selected" <?php } ?>><?php echo $ano; ?> Enero</option>
                                    <option value="02"  <?php if ($mes == '02') { ?> selected="selected" <?php } ?>><?php echo $ano; ?> Febrero</option>
                                    <option value="03" <?php if ($mes == '03') { ?> selected="selected" <?php } ?>><?php echo $ano; ?> Marzo</option>
                                    <option value="04" <?php if ($mes == '04') { ?> selected="selected" <?php } ?>><?php echo $ano; ?> Abril</option>
                                    <option value="05" <?php if ($mes == '05') { ?> selected="selected" <?php } ?>><?php echo $ano; ?> Mayo</option>
                                    <option value="06" <?php if ($mes == '06') { ?> selected="selected" <?php } ?>><?php echo $ano; ?> Junio</option>
                                    <option value="07" <?php if ($mes == '07') { ?> selected="selected" <?php } ?>><?php echo $ano; ?> Julio</option>
                                    <option value="08" <?php if ($mes == '08') { ?> selected="selected" <?php } ?>><?php echo $ano; ?> Agosto</option>
                                    <option value="09" <?php if ($mes == '09') { ?> selected="selected" <?php } ?>><?php echo $ano; ?> Septiembre</option>
                                    <option value="10" <?php if ($mes == '10') { ?> selected="selected" <?php } ?>><?php echo $ano; ?> Octubre</option>
                                    <option value="11" <?php if ($mes == '11') { ?> selected="selected" <?php } ?>><?php echo $ano; ?> Noviembre</option>
                                    <option value="12" <?php if ($mes == '12') { ?> selected="selected" <?php } ?>><?php echo $ano; ?> Diciembre</option>

                                </select> 


                            </td>

                            </tr>
                        </table>
                        <div id="habil_fecha" style="margin-top:10px; margin-bottom:10px;  <?php if (trim($indicador) != 1) { ?> display:none; <?php } ?>">
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

                        <table style="margin-top:5px;">            

    <td><!--<input type="submit" value="Buscar" />--></td>
                            </tr>
                            </tr>
                        </table>
                    </form>
                    <!-- INICIO -->
                    <div class="clear" style="padding-bottom:30px;"></div>
                    <!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
//ob_start();
?>
                    <!-- FIN-->   

                    <div id="showTable" name="show" >                   

                        <div style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#007a5e; font-weight:bold; margin-bottom:15px; margin-left: 30px;" align="left"><?php
                            if ($tipo_lis == 1) {
                                echo "Detalles de  ";
                                echo ucfirst(strtr(strtolower($servicio), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú"));
                            }# hola tío 
?></div>
                        <hr style="background-color:#E8E8E8; height:2px; border:0;" />

                        <!-- INICIO PANTALLAS BACKEND -->
                        <table class="tableSector">
                            <thead>
                                <tr>
                                <th>Fecha Ocurrencia</th>
                                <th>Centro Clínico</th>
                                <th>Afiliado</th>
                                <th>Monto Faturado Bs</th>
                                <th>Tipo de Servicio</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($cuantos_tabla_inicial != 0) { ?>
                                    <?php
                                    foreach ($tabla_detalle as $row_tabla):

                                        $fecocurr = date('d/m/Y', strtotime($row_tabla['FECOCURR']));
                                        $COD_BEN_PAGO = $row_tabla['COD_BEN_PAGO'];
                                        $BEN_PAGO = $row_tabla['BEN_PAGO'];
                                        $CI_PACIENTE = $row_tabla['CI_PACIENTE'];
                                        $PACIENTE = $row_tabla['PACIENTE'];
                                        $monto_servicio = $row_tabla['TOTAL'];
                                        $tipo_servicio2 = $row_tabla['TIPO_DES'];
                                        //echo $url;
                                        $url = 'siniedetalle/index?cliente=' . $cliente . '&contratante=' . $contratante . '&ano=' . $ano . '&mes=' . $mes2 . '&tipo_servicio=' . $tipo_servicio . '&servicio=' . $tipo_serv . '&ci_paciente=' . $CI_PACIENTE . '&tipo_lis=1&clase_lis=1';
                                        ?>                                            

                                        <tr>      

                                        <td ><input class="botonadd" type="button"  type="button" onclick="location.href='<?php echo url_for($url) ?>'"/><?php echo $fecocurr; ?></td>
                                        <td ><?php echo $BEN_PAGO; ?></td>
                                        <td ><?php echo $PACIENTE; ?></td>
                                        <td class="alignRight"><?php echo format_number($monto_servicio); ?></td>                                                    
                                        <td><?php echo $tipo_servicio2; ?></td>

                                        </tr>
        <?php
    endforeach;
}

else {
    ?>

                                    <tr> 
                                    <td width="250">No exiten casos registrados</td>
                                    <td >--</td>
                                    <td >--</td>
                                    <td class="alignRight">0</td>
                                    <td >--</td>
                                    </tr>
                        <?php } ?>  
                            </tbody>

                        </table>   
                        <!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
                        <?php
//echo $var=ob_get_clean();
                        $var = '<table class="tableSector">
                                            <thead>
                                                <tr>
                                                    <th>Fecha Ocurrencia</th>
                                                    <th>Centro Clínico</th>
                                                    <th>Afiliado</th>
                                                    <th>Monto Faturado Bs</th>
                                                    <th>Tipo de Servicio</th> 
                                                </tr>
                                            </thead>
                                            <tbody>';

                        if ($cuantos_tabla_inicial != 0) {

                            foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):

                                $fecocurr = date('d/m/Y', strtotime($row_tabla['FECOCURR']));
                                $COD_BEN_PAGO = $row_tabla['COD_BEN_PAGO'];
                                $BEN_PAGO = $row_tabla['BEN_PAGO'];
                                $CI_PACIENTE = $row_tabla['CI_PACIENTE'];
                                $PACIENTE = $row_tabla['PACIENTE'];
                                $monto_servicio = $row_tabla['TOTAL'];
                                $tipo_servicio2 = $row_tabla['TIPO_DES'];
                                //echo $url;
                                $url = 'siniedetalle/index?cliente=' . $cliente . '&contratante=' . $contratante . '&ano=' . $ano . '&mes=' . $mes2 . '&tipo_servicio=' . $tipo_servicio . '&servicio=' . $tipo_serv . '&ci_paciente=' . $CI_PACIENTE . '&tipo_lis=1&clase_lis=1';


                                $var.='<tr><td ><input class="botonadd" type="button"  type="button" />' . $fecocurr . '</td>
                                                    <td >' . $BEN_PAGO . '</td>
                                                    <td >' . $PACIENTE . '</td>
                                                    <td class="alignRight">' . $monto_servicio . '</td>                                                    
                                                    <td>' . $tipo_servicio2 . '</td></tr>';

                            endforeach;
                        }
                        $var.='</tbody></table>   ';
                        $num = rand(1, 10);
                        $dir = 'pdf/index?1=' . $num;
                        ?>


                        <!--FIN-->  
                        <!-- Formulario oculto para crear pdf-->
                        <form method="post" id="targetpdf" action="<?php echo url_for($dir) ?>" target="_blank" hidden="hidden">
                            <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Detalles de <?php echo ucfirst(strtr(strtolower($servicio), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú")); ?>" />
                            <textarea id="text_pdf" name="text" rows="2" cols="20"  >
<?php echo $var; ?>
                            </textarea>
                        </form>
                        <!-- fin-->  
                    </div>
                    <!-- Formulario oculto para crear excel-->
                    <form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
                        <input id="titulo"  name="titulo" type="text" value="Detalles de <?php echo ucfirst(strtr(strtolower($servicio), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú")); ?>"  />
                        <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
                    </form>
                    <!-- fin-->
                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />

                    <?php
                    //$total=$cuantos_tabla_inicial;
                    //echo $total."<br />";  
                    //  $url_pag=url_for('siniedetaprove/index');
                    //if($cuantos_tabla_inicial>0){ echo paginacion($total,$pp,$st, url_for('sinielistadprovee/index').'?ano='.$ano.'&mes='.$mes.'&cliente='.$cliente.'&contratante='.$contratante.'&tipo_servicio='.$tipo_servicio.'&indicador='.$indicador.'&st=');}

                    $url2 = '';

                    $cantidadRegistrosPorPagina = 10;
                    $cantidadEnlaces = 10; // Cantidad de enlaces que tendra el paginador.
                    $totalRegistros = $cuantos_tabla_inicial;
//echo $totalRegistros;
// Comenzamos incluyendo el Paginador.
                    require_once 'Paginador.php';

// Instanciamos la clase Paginador
                    $paginador = new Paginador();

// Configuramos cuanto registros por pagina que debe ser igual a el limit de la consulta mysql
                    $paginador->setCantidadRegistros($cantidadRegistrosPorPagina);
// Cantidad de enlaces del paginador sin contar los no numericos.
                    $paginador->setCantidadEnlaces($cantidadEnlaces);

// Agregamos estilos al Paginador
                    $paginador->setClass('primero', 'previous');
                    $paginador->setClass('bloqueAnterior', 'previous');
                    $paginador->setClass('anterior', 'previous');
                    $paginador->setClass('siguiente', 'next');
                    $paginador->setClass('bloqueSiguiente', 'next');
                    $paginador->setClass('ultimo', 'next');
                    $paginador->setClass('numero', '<>');
                    $paginador->setClass('actual', 'active');
                    $paginador->setUrlDestino($url2);
// Y mandamos a paginar desde la pagina actual y le pasamos tambien el total
// de registros de la consulta mysql.
                    $datos = $paginador->paginar($pagina, $totalRegistros);

// Preguntamos si retorno algo, si retorno paginamos. Nos retorna un arreglo
// que se puede usar para paginar del modo clasico. Si queremos paginar con
// el enlace ya confeccionado realizamos lo siguiente.
//echo $datos;
                    if ($datos) {

                        $enlaces = $paginador->getHtmlPaginacion('pagina', 'li');
                        ?>
                        <ul id="pagination-digg">
                        <?php
                        foreach ($enlaces as $enlace) {
                            echo $enlace . "\n";
                        }
                        ?>
                        </ul>
                        <br /><br />
                            <?php
                        }
                        ?>             

                    <table class="sectorBottomMenu">
                        <tr>
                        <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
                        <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td>
                        <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td> 
<?php
$url_atras = '../siniereclamtiposervic/index' . '?ano=' . $ano . '&mes=' . $mes . '&cliente=' . $cliente . '&contratante=' . $contratante . '&tipo_servicio=' . $tipo_servicio . '&indicador=1&pagina=' . $pagina_ubi . '&servi_general=' . $servi_general . '&atras=1';
?>
                        <td><a href="<?php echo $url_atras; ?>" id="url_atras">Atras</a></td>
                        </tr>                        
                    </table>
                    <div class="clear" style="padding-bottom:30px;"></div>


                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#url_imprime").click(function (){
        $("html").printArea();
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
<script>
    function llenar_contratantes(a)
    {
        //alert("MIlaaaaaaaaaaaaaaaaaaaaaaaa"); 
        var n = document.forms.form1.contratante.length;

        //alert(a);
        for (var i=0; i<n;++i){      
            document.forms.form1.contratante.remove(document.forms.form1.contratante.options[i]);//eliminar lineas del 2do combo...
        }
   
        document.forms.form1.contratante[0]= new Option("Todos",'todos'); //creamos primera linea del segundo combo

 
<?php
foreach ($ente_contratante_vw as $row_c):
    $id_pol = $row_c['idepol'];
    ?> 
                                   
        	   	
                if (a== '<?php echo $id_pol; ?>'){

                    //alert("Milaaaaaaaaaaa holaaaaaaaa");
    <?php
    $valorwhere = 'idepol=' . $id_pol;
    $q = Doctrine_Query::create()
            ->from('CONTRATO_POLIZA_VW  J')
            ->where($valorwhere);
    $CONTRATO_POLIZA_VW_filtrado = $q->fetchArray();
    foreach ($CONTRATO_POLIZA_VW_filtrado as $row_pf):
        $id_pol2 = $row_pf['idepol'];
        $des_contratante = $row_pf['desctrocos'];
        ?>
                            //  echo $id_pol2."<br />";
                            document.forms.form1.contratante[document.forms.form1.contratante.length]= new Option("<?php echo $des_contratante; ?>",'<?php echo $id_pol2; ?>'); 
    <?php endforeach;
    ?>
                    
                }
<?php endforeach; ?>
 

    }
 


    function fechas_mes(a,y,diab)
    {
     
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
            if(diab==0){ document.forms.form1.fin.value="29-2-"+y;}
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
