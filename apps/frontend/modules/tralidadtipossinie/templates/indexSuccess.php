<?php
use_helper('Number');
use_helper('Date');
?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php
//error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);


if ($cuantos_tabla_inicial != 0) {
    foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):

        $cantidad_total_casos = $cantidad_total_casos + $row_tabla['CANTIDAD'];
        
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
    // echo "tipo mila".$tipo_prov;
} $mes2 = $mes;
//echo "messsss ".$mes2;
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
                        <li><a href="#">Siniestralidad</a></li>
                        <li class="last">Tipo de Siniestralidad Consolidado</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Tipo de Siniestralidad Consolidado</h1>
                <div class="articleBox">
                    <form  id="form1"  name="form1" action="<?php echo url_for('tralidadtipossinie/index') ?>" method="post">
                        <table>
                            <tr><td>Cliente: <input type="hidden" id="indicador" name="indicador" value="1"  /></td><td colspan="3"><select id="cliente" name="cliente" onChange="llenar_contratantes(this.value);">
                                    <option value="0"  selected="seleted" > - Seleccione una opción - </option>
                                    <?php foreach ($CMB_CLIENTE_MVW as $row): ?>
                                        <option value="<?php echo $row['idepol']; ?>" <?php if ($cliente == $row['idepol']) { ?> selected="seleted" <?php } ?>><?php echo $row['descripcion']; ?></option>
                                    <?php endforeach; ?>

                                </select> </td></tr>
                            <tr><td>Contratante: </td><td colspan="3"><select id="contratante" name="contratante"  onChange="llenar_localidad(document.getElementById('cliente').value,this.value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?>>
                                    <option value=""  selected="seleted" > - Seleccione una opción - </option>  
                                    <option value="todos" <?php if ($contratante == 'todos') { ?> selected="seleted" <?php } ?>>Todos</option>
                                    <?php foreach ($CMB_CONTRATANTE_MVW333 as $row): ?>
                                        <option value="<?php echo $row['CODCTROCOS']; ?>" <?php if ($contratante == $row['CODCTROCOS']) { ?> selected="seleted" <?php } ?>><?php echo $row['DESCTROCOS']; ?></option>
                                    <?php endforeach; ?>

                                </select> </td></tr>
                            <tr><td>Localidad: </td><td colspan="3">
                                <select id="localidad" name="localidad" style="width: 178px;" onChange="Tipo_proveedor(document.getElementById('cliente').value,document.getElementById('contratante').value,this.value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?> >
                                    <option value=""  selected="seleted" > - Seleccione una opción - </option>  
                                    <option value="todos" <?php if ($localidad == 'todos') { ?> selected="selected" <?php } ?>>Todos</option>
                                    <?php foreach ($CMB_CIUDAD as $row): ?>
                                        <option value="<?php echo $row['CIUDAD']; ?>" <?php if ($localidad == $row['CIUDAD']) { ?> selected="selected" <?php } ?>><?php echo $row['CIUDAD']; ?></option>
                                    <?php endforeach; ?> 
                                </select> </td></tr>
                            <tr><td width="110">Consolidado: </td><td colspan="3">
                                <select id="tipo_prov" name="tipo_prov"  style=" width: 178px;" onchange="ano_consolidado(document.getElementById('cliente').value,document.getElementById('contratante').value,document.getElementById('localidad').value, this.value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?> >
                                    <option value="-1"  selected="seleted" > - Seleccione una opción - </option> 
                                    <option value="todos" <?php if ($tipo_prov == 'todos') { ?> selected="selected" <?php } ?>>Todos</option>
                                    <?php foreach ($CMB_TIPOPROV as $row2): ?>
                                        <option value="<?php echo $row2['TIPOPROV']; ?>" <?php if ($tipo_prov == $row2['TIPOPROV']) { ?> selected="selected" <?php } ?>><?php echo $row2['TIPOPROV']; ?></option>
                                    <?php endforeach; ?> 
                                </select> </td></tr>
                            <tr><td>Año: </td><td colspan="3"><select id="ano" name="ano" onchange="mes_consolidado(document.getElementById('cliente').value,document.getElementById('contratante').value,document.getElementById('localidad').value,document.getElementById('tipo_prov').value, this.value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?>>
                                    <option value="-1"  selected="seleted" > - Seleccione una opción - </option> 
                                    <?php foreach ($CMB_ANNO_GENERAL3 as $row): ?>
                                        <option value="<?php echo $row['ANNO']; ?>" <?php if ($ano == $row['ANNO']) { ?> selected="selected" <?php } ?>><?php echo $row['ANNO']; ?></option>
                                    <?php endforeach; ?>                                    
                                </select> </td></tr>
                            <tr><td >Mes: </td><td colspan="3">
                                <select id="mes"  name="mes" onchange="document.getElementById('tipo_servicio').disabled=false; fechas_mes(this.value,document.forms.form1.ano.value,'<?php echo $es_bisiesto; ?>');eliminarPais(document.forms.form1.inicio.value,document.forms.form1.fin.value), num_dias(this.value,document.forms.form1.ano.value);llenar_tipo_servicio(document.getElementById('cliente').value,document.getElementById('contratante').value,document.getElementById('ano').value,this.value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?>>
                                    <option value="-1"  <?php if ($mes2 == '-1') { ?> selected="seleted" <?php } ?>> - Seleccione una opción - </option> 
                                    <option value="0" <?php if ($mes2 == 0) { ?>  selected="seleted" <?php } ?> > Todos </option> 
                                    <?php
                                    foreach ($CMB_MES as $row):
                                        $anno = $row['ANNO'];
                                        $mes33 = $row['MES'];

                                        switch ($mes33) {
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
                                        <option value="<?php echo $mes33; ?>" <?php if ($mes2 == $mes33) { ?> selected="seleted" <?php } ?> ><?php echo $anno . ' ' . $mes_tabla; ?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </td>                        
                            </tr>
                        </table>
                        <div id="habil_fecha" style=" margin-top:10px; margin-bottom:10px; display:none; <?php //if(trim($indicador)!=1){  ?> display:none;<?php //}   ?>">
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
                            <td><input  type="submit" id="btn_getvalues" class="btn_buscar" value="Buscar" /></td>
                            </tr>
                        </table>
                    </form>
                    <!-- INICIO -->
                    <div class="clear" style="padding-bottom:30px;"></div>

                    <div id="showTable" name="show" >                    

                        <hr style="background-color:#E8E8E8; height:2px; border:0;" />

                        <!-- INICIO PANTALLAS BACKEND -->
                        <?php if (trim($indicador) == 1 or trim($tipo_listado) == 1) { ?>   

                            <!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
                            <?php
//echo $var.=ob_get_clean();
//echo $var=ob_get_clean();
                            $num = rand(1, 20);
                            $dir = 'pdf/index?2=' . $num;

                            $var = '<table class="tableSector">  
                                            <thead>
                                                <tr >
                                                    <th >Proveedores de Servicios</th>
                                                    <th>Localidad</th>
                                                    <th>Monto Indemnizado.</th>
                                                    <th>Cantidad de Casos</th>                                                    
                                                    <th>Costo Promedio por Caso</th>                    
                                                </tr>
                                            </thead>
                                            <tbody>';


                            $cantidad_total_casos = 0;
                            $monto_total = 0;
                            if ($cuantos_tabla_inicial != 0) {
                                foreach ($SINIESTRALIDAD_VW_tabla_inicial2 as $row_tabla):

                                    $id_prov = $row_tabla['COD_BEN_PAGO'];
                                    $nombre_prov = $row_tabla['BEN_PAGO'];
                                    $cantidad = $row_tabla['CANTIDAD'];
                                    $localidad2 = $row_tabla['LOCALIDAD'];
                                    $monto_servicio = str_replace(",", ".", $row_tabla['TOTAL']); 

                                    $promedio_costo = $monto_servicio / $cantidad;
                                    $cantidad_total_casos = $cantidad_total_casos + $cantidad;                                    
                                    $monto_total = $monto_total +  $monto_servicio;
                                      


                                    $var.='<tr>      

                                                <td class="nombre_proveedor">' . $nombre_prov . '</td>
                                                <td class="nombre_proveedor">' . $localidad2 . '</td>
                                                <td class="alignRight">' . number_format($monto_servicio, 2, ",", ".")  . '</td>
                                                <td class="alignRight">' . number_format($cantidad, 2, ",", ".")  . '</td>                                                    
                                                <td class="alignRight">' . number_format($promedio_costo, 2, ",", ".")  . '</td></tr>
                                ';


                                endforeach;
                            }

                            $var.='<tfoot>
                                    <tr style="font-weight:bold;">
                                    <td colspan="2"><div style="float:left; margin-left:10px; padding:5px; ">TOTAL</div></td>
                                    <td class="alignRight">' . number_format($monto_total, 2, ",", ".") . '</td>
                                    <td class="alignRight">' . $cantidad_total_casos . '</div></td>
                                    <td class="alignRight"></td>                                                    
                                    </tr>
                                    </tfoot></table> ';
                            ?>

                            <!-- otra cajita --><!-- otra cajita -->
                            <div class="cajas_totales">


                                <!-- otra cajita --><!-- otra cajita -->
                                <div class="cajitas_peq_totales_med"style="margin-left:10px;"> 
                                    <div class="linea">
                                        <div class="titulo_cajita_med">Total Reclamos:</div>
                                        <div class="total_bs_med"><?php echo $cantidad_total_casos; ?></div>  
                                    </div>
                                </div>

                                <!-- otra cajita --><!-- otra cajita -->

                                <div class="cajitas_peq_totales" style=" margin-left:10px;">
                                    <div class="linea">
                                        <div class="titulo_cajita">Monto Total Bs:</div>
                                        <div class="total_bs"><?php echo number_format($monto_total, 2, ",", "."); ?></div>  
                                    </div>
                                </div>

                                <!-- otra cajita --><!-- otra cajita -->
                            </div>


                            <!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
                            <?php
//ob_start();
                            ?>
                            <!-- FIN-->                   
                            <table class="tableSector">
                                <thead>
                                    <tr >
                                    <th >Proveedores de Servicios</th>
                                    <th>Localidad</th>
                                    <th>Monto Indemnizado.</th>
                                    <th>Cantidad de Casos</th>                                                    
                                    <th>Costo Promedio por Caso</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cantidad_total_casos = 0;
                                    $monto_total = 0;
                                    if ($cuantos_tabla_inicial != 0) {
                                        ?>
                                        <?php
                                        foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):

                                            $id_prov = $row_tabla['COD_BEN_PAGO'];
                                            $nombre_prov = $row_tabla['BEN_PAGO'];
                                            $cantidad = $row_tabla['CANTIDAD'];
                                            $localidad2 = $row_tabla['LOCALIDAD'];
                                            $monto_servicio = str_replace(",", ".", $row_tabla['TOTAL']);

                                            $promedio_costo = ($monto_servicio / $cantidad);
                                            $cantidad_total_casos = $cantidad_total_casos + $cantidad;
                                            $monto_total = $monto_total + $monto_servicio;
                                            ?>


                                            <tr>
                                            <td class="nombre_proveedor"><?php echo $nombre_prov; ?></td>
                                            <td class="nombre_proveedor"><?php echo $localidad2; ?></td>
                                            <td class="alignRight"><?php echo number_format($monto_servicio, 2, ",", "."); ?></td>
                                            <td class="alignRight"><?php echo $cantidad ?></td>
                                            <td class="alignRight"><?php echo number_format($promedio_costo, 2, ",", "."); ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    }

                                    else {
                                        ?>

                                        <tr>      

                                        <td ><div style="float:left; margin-left:10px; padding:5px; ">No exiten casos registrados</div></td>
                                        <td class="alignRight">0</td>
                                        <td class="alignRight">0</td>
                                        <td class="alignRight">0</td>



                                        </tr>
                                    <?php } ?>
                                </tbody>

                                <tfoot>
                                    <tr style="font-weight:bold;">
                                    <td colspan="2"><div style="float:left; margin-left:10px; padding:5px; ">TOTAL</div></td>
                                    <td class="alignRight"><?php echo number_format($monto_total, 2, ",", "."); ?></td>
                                    <td class="alignRight"><?php echo $cantidad_total_casos; ?></div></td>
                                    <td class="alignRight"></td>                                                    
                                    </tr>
                                </tfoot>
                            </table> 





                            <!--FIN-->      

                            <!-- Formulario oculto para crear pdf-->
                            <form method="post" id="targetpdf" action="<?php echo url_for($dir) ?>" target="_blank" hidden="hidden">
                                <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Tipo Siniestralidad Consolidado" />
                                <textarea id="text_pdf" name="text" rows="2" cols="20"  >
                                    <?php echo '<br />' . $var; ?>
                                </textarea>
                            </form>
                            <!-- fin--> 
                            <!-- Formulario oculto para crear pdf-->
                            <form method="post" id="targetimp" action="<?php echo url_for('imprimir/index') ?>" target="_blank" hidden="hidden">
                                <input id="titulo_pdf"  name="titulo" type="text" value="Detalle de Listado de Patologías por<?php echo ucfirst(strtr(strtolower($servicio_busca), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú")); ?>" />
                                <textarea id="text_imp" name="text_imp" rows="2" cols="20"  >
                                    <?php echo $var; ?>
                                </textarea>

                            </form>
                            <!-- fin-->
                            <!-- Formulario oculto para crear excel-->
                            <form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
                                <input id="titulo"  name="titulo" type="text" value="Detalle de Listado de Patologías por<?php echo ucfirst(strtr(strtolower($servicio_busca), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú")); ?>" />
                                <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
                            </form>
                            <!-- fin-->
                        </div>

                        <hr style="background-color:#E8E8E8; height:2px; border:0;" />
                        <?php
// Parametros a ser usados por el Paginador.
                        $url = '/index' . '?ano=' . $ano . '&mes=' . $mes . '&cliente=' . $cliente . '&contratante=' . $contratante . '&tipo_servicio=' . $tipo_servicio . '&indicador=' . $indicador . '&tipo_prov=' . $tipo_prov . '&localidad=' . $localidad;
                        $cantidadRegistrosPorPagina = 10;
                        $cantidadEnlaces = 10; // Cantidad de enlaces que tendra el paginador.
                        $totalRegistros = $cuantos_tabla_inicial;
//echo $totalRegistros;


                        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0;

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
                        $paginador->setUrlDestino($url);
// Y mandamos a paginar desde la pagina actual y le pasamos tambien el total
// de registros de la consulta mysql.
                        $datos = $paginador->paginar($pagina, $totalRegistros);

// Preguntamos si retorno algo, si retorno paginamos. Nos retorna un arreglo
// que se puede usar para paginar del modo clasico. Si queremos paginar con
// el enlace ya confeccionado realizamos lo siguiente.
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
                            </tr>                        
                        </table>
                    <?php } ?>  
                    <div class="clear" style="padding-bottom:30px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
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
<script>
    
    function llenar_contratantes(a)
    {

        var n = document.forms.form1.contratante.length;

  
  
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
   

    }
 
    function llenar_localidad(cliente,contratante)
    {

        var n = document.forms.form1.localidad.length;
        var m = document.forms.form1.tipo_prov.length;
        var o = document.forms.form1.ano.length;
        var p = document.forms.form1.mes.length;
    
    
        for (var i=0; i<n;++i){      
            document.forms.form1.localidad.remove(document.forms.form1.localidad.options[i]);//eliminar lineas del 2do combo...
        }
   
        document.forms.form1.localidad[0]= new Option("- Seleccione una opción -",'-1'); 
        document.forms.form1.localidad[1]= new Option("Todos",'todos'); //creamos primera linea del segundo combo

        if(contratante=='' || contratante=='todos'){
<?php
foreach ($CMB_CLIENTE_MVW as $row_c):
    $id_pol = $row_c['idepol'];
    ?> 	
                    if (cliente== '<?php echo $id_pol; ?>'){
                        
    <?php
    $q22 = Doctrine_Query::create()
            ->select("ciudad, id")
            ->from('SINIESTRALIDAD_VW  J')
            ->where(" idepol='$id_pol' and ciudad<>' '")
            ->groupBy(" ciudad, id")
            ->orderBy(" ciudad ASC");

    $CMB_SERVICIO = $q22->fetchArray();

    foreach ($CMB_SERVICIO as $row_pf):
        $ciudad = $row_pf['ciudad'];
        ?>                        
                                    
                                document.forms.form1.localidad[document.forms.form1.localidad.length]= new Option("<?php echo $ciudad; ?>",'<?php echo $ciudad; ?>'); 
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
    foreach ($CMB_CLIENTE_MVW as $row_c):
        $id_pol = $row_c['idepol'];
        ?> 	
                                if (cliente== '<?php echo $id_pol; ?>'){
        <?php
        $q22 = Doctrine_Query::create()
                ->select("ciudad, id")
                ->from('SINIESTRALIDAD_VW  J')
                ->where(" idepol='$id_pol' and codexterno='$codctrocos'")
                ->groupBy(" ciudad, id")
                ->orderBy(" ciudad ASC");

        $CMB_SERVICIO = $q22->fetchArray();

        foreach ($CMB_SERVICIO as $row_pf):
            $ciudad = $row_pf['ciudad'];
            ?>                        
                                                
                                            document.forms.form1.localidad[document.forms.form1.localidad.length]= new Option("<?php echo $ciudad; ?>",'<?php echo $ciudad; ?>'); 
        <?php endforeach; ?>
                                }
    <?php endforeach; ?>
                    }
<?php endforeach; ?>   
           
        } 
        document.forms.form1.localidad.disabled=false;


  
  
        for (var i=0; i<m;++i){      
            document.forms.form1.tipo_prov.remove(document.forms.form1.tipo_prov.options[i]);//eliminar lineas del 2do combo...
        }
   
        document.forms.form1.tipo_prov[0]= new Option("- Seleccione una opción -",'-1'); 
   
        for (var i=0; i<o;++i){      
            document.forms.form1.ano.remove(document.forms.form1.ano.options[i]);//eliminar lineas del 2do combo...
        }
   
        document.forms.form1.ano[0]= new Option("- Seleccione una opción -",'-1'); 
  
        /*for (var i=0; i<p;++i){      
      document.forms.form1.mes.remove(document.forms.form1.mes.options[i]);//eliminar lineas del 2do combo...
  }
   
   document.forms.form1.mes[0]= new Option("- Seleccione una opción -",'-1'); */
    
        document.forms.form1.tipo_prov.disabled=true;
        document.forms.form1.ano.disabled=true;
        //document.forms.form1.mes.disabled=true;

    }
 
    function llenar_tipo_proveedor(cliente,contratante,localidad)
    {

        var n = document.forms.form1.tipo_prov.length;

  
  
        for (var i=0; i<n;++i){      
            document.forms.form1.tipo_prov.remove(document.forms.form1.tipo_prov.options[i]);//eliminar lineas del 2do combo...
        }
   
        document.forms.form1.tipo_prov[0]= new Option(" - Seleccione una opción - ",'-1'); 
        document.forms.form1.tipo_prov[1]= new Option("Todos",'todos'); //creamos primera linea del segundo combo

        if(contratante=='' || contratante=='todos'){
<?php
foreach ($CMB_CLIENTE_MVW as $row_c):
    $id_pol = $row_c['idepol'];
    ?> 	
                    if (cliente== '<?php echo $id_pol; ?>'){
                        if(localidad=='todos'){
    <?php
    $q223 = Doctrine_Query::create()
            ->select(" DISTINCT tipoprov ")
            ->from(' SINIESTRALIDAD_VW J ')
            ->where(" idepol='$id_pol' and tipoprov<>' ' ");
    ?> 
                          
                          
    <? $CMB_TIPO = $q223->fetchArray(); ?>
    <?PHP
    foreach ($CMB_TIPO as $row_pf):
        $tipoprov = $row_pf['tipoprov'];
        ?>            
                                    document.forms.form1.tipo_prov[document.forms.form1.tipo_prov.length]= new Option("<?php echo $tipoprov; ?>",'<?php echo $tipoprov; ?>'); 
    <?php endforeach; ?>
                        }
                        else{   
    <?php
    $q22 = Doctrine_Query::create()
            ->select("ciudad, id")
            ->from('SINIESTRALIDAD_VW  J')
            ->where(" idepol='$id_pol' and ciudad<> ' '")
            ->groupBy(" ciudad, id")
            ->orderBy(" ciudad ASC");

    $CMB_SERVICIO = $q22->fetchArray();

    foreach ($CMB_SERVICIO as $row_pf):
        $ciudad = $row_pf['ciudad'];
        ?>                        
                                    if(localidad=='<?php echo $ciudad; ?>'){
        <?php
        $q223 = Doctrine_Query::create()
                ->select(" DISTINCT tipoprov ")
                ->from(' SINIESTRALIDAD_VW J ')
                ->where(" idepol='$id_pol' and tipoprov<>' ' and ciudad='$ciudad'");

        $CMB_TIPO22 = $q223->fetchArray();
        ?>
                                                            
                                       
                                        
        <?php
        foreach ($CMB_TIPO22 as $row_p2):
            $tipoprov = $row_p2['tipoprov'];
            ?>          
                                                document.forms.form1.tipo_prov[document.forms.form1.tipo_prov.length]= new Option("<?php echo $tipoprov; ?>",'<?php echo $tipoprov; ?>');
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
                                    
                    if(contratante=='<?php echo $codctrocos; ?>'){
    <?php
    foreach ($CMB_CLIENTE_MVW as $row_c):
        $id_pol = $row_c['idepol'];
        ?> 	
                                if (cliente== '<?php echo $id_pol; ?>'){
                                    if(localidad=='todos'){
        <?php
        $q223 = Doctrine_Query::create()
                ->select(" DISTINCT tipoprov ")
                ->from(' SINIESTRALIDAD_VW J ')
                ->where(" idepol='$id_pol' and tipoprov<>' '  ");
        ?> 
                                      
                                      
        <? $CMB_TIPO = $q223->fetchArray(); ?>
        <?PHP
        foreach ($CMB_TIPO as $row_pf):
            $tipoprov = $row_pf['tipoprov'];
            ?>            
                                                document.forms.form1.tipo_prov[document.forms.form1.tipo_prov.length]= new Option("<?php echo $tipoprov; ?>",'<?php echo $tipoprov; ?>'); 
        <?php endforeach; ?>
                                    }
                                    else{   
        <?php
        $q22 = Doctrine_Query::create()
                ->select("ciudad, id")
                ->from('SINIESTRALIDAD_VW  J')
                ->where(" idepol='$id_pol' and ciudad<> ' ' ")
                ->groupBy(" ciudad, id")
                ->orderBy(" ciudad ASC");

        $CMB_SERVICIO = $q22->fetchArray();

        foreach ($CMB_SERVICIO as $row_pf):
            $ciudad = $row_pf['ciudad'];
            ?>                        
                                                if(localidad=='<?php echo $ciudad; ?>'){
            <?php
            $q223 = Doctrine_Query::create()
                    ->select(" DISTINCT tipoprov ")
                    ->from(' SINIESTRALIDAD_VW J ')
                    ->where(" idepol='$id_pol' and tipoprov<>' ' and ciudad='$ciudad'");

            $CMB_TIPO22 = $q223->fetchArray();
            ?>
                                                                        
                                                                   
                                                    
            <?php
            foreach ($CMB_TIPO22 as $row_p2):
                $tipoprov = $row_p2['tipoprov'];
                ?>          
                                                            document.forms.form1.tipo_prov[document.forms.form1.tipo_prov.length]= new Option("<?php echo $tipoprov; ?>",'<?php echo $tipoprov; ?>');
            <?php endforeach; ?>
                                                 
                                                }
        <?php endforeach; ?>
                                
                                    }  
                                }// localidad else
    <?php endforeach; ?> 
                    }
<?php endforeach; ?> 
        } // else
        document.forms.form1.tipo_prov.disabled=false;
   

    }

    function llenar_tipo_ano()
    { 
        document.forms.form1.ano.disabled=false;
    }
 
    function llenar_tipo_mes()
    { 
        document.forms.form1.mes.disabled=false;
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