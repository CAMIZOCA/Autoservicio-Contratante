<?php use_helper('Number');
use_helper('Date');
?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php
//error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);
$mes2 = $mes;
/* function DiasHabiles($fecha_inicial,$fecha_final)
  {
  list($dia,$mes,$year) = explode("-",$fecha_inicial);
  $ini = mktime(0, 0, 0, $mes , $dia, $year);
  list($diaf,$mesf,$yearf) = explode("-",$fecha_final);
  $fin = mktime(0, 0, 0, $mesf , $diaf, $yearf);

  $r = 1;
  while($ini != $fin)
  {
  $ini = mktime(0, 0, 0, $mes , $dia+$r, $year);
  $newArray[] .=$ini;
  $r++;
  }
  return $newArray;
  }

  function Evalua($arreglo)
  {
  $feriados        = array(
  '1-1',  //  Año Nuevo (irrenunciable)
  '6-4',  //  Viernes Santo (feriado religioso)
  '7-4',  //  Sábado Santo (feriado religioso)
  '1-5',  //  Día Nacional del Trabajo (irrenunciable)
  '21-5',  //  Día de las Glorias Navales
  '29-6',  //  San Pedro y San Pablo (feriado religioso)
  '16-7',  //  Virgen del Carmen (feriado religioso)
  '15-8',  //  Asunción de la Virgen (feriado religioso)
  '18-9',  //  Día de la Independencia (irrenunciable)
  '19-9',  //  Día de las Glorias del Ejército
  '12-10',  //  Aniversario del Descubrimiento de América
  '31-10',  //  Día Nacional de las Iglesias Evangélicas y Protestantes (feriado religioso)
  '1-11',  //  Día de Todos los Santos (feriado religioso)
  '8-12',  //  Inmaculada Concepción de la Virgen (feriado religioso)
  '13-12',  //  elecciones presidencial y parlamentarias (puede que se traslade al domingo 13)
  '25-12',  //  Natividad del Señor (feriado religioso) (irrenunciable)
  );

  $j= count($arreglo);

  for($i=0;$i<=$j;$i++)
  {
  $dia = $arreglo[$i];

  $fecha = getdate($dia);
  $feriado = $fecha['mday']."-".$fecha['mon'];
  if($fecha["wday"]==0 or $fecha["wday"]==6)
  {
  $dia_ ++;
  }
  elseif(in_array($feriado,$feriados))
  {
  $dia_++;
  }
  }
  $rlt = $j - $dia_;
  return $rlt;
  }

  function UltimoDia($anho,$mes){
  if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) {
  $dias_febrero = 29;
  } else {
  $dias_febrero = 28;
  }
  switch($mes) {
  case 01: return 31; break;
  case 02: return $dias_febrero; break;
  case 03: return 31; break;
  case 04: return 30; break;
  case 05: return 31; break;
  case 06: return 30; break;
  case 07: return 31; break;
  case 08: return 31; break;
  case 09: return 30; break;
  case 10: return 31; break;
  case 11: return 30; break;
  case 12: return 31; break;
  }
  }


  $CantidadDiasHabiles = Evalua(DiasHabiles($fecha_inicial,$fecha_final)); */

/*   echo "fecha_inicial:".$fecha_inicial."<br />"; 
  echo "fecha_ifinal:".$fecha_final."<br />";
  echo "num mes:".$num_dia_mes."<br />";
  echo "días hábiles:".$CantidadDiasHabiles."<br />"; */

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
                        <li><a href="#">Siniestralidad</a></li>
                        <li class="last">Parentesco + Incurrido + Nª de casos</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Parentesco + Incurrido + Nª de casos</h1>
                <div class="articleBox">
                    <form  id="form1"  name="form1" action="<?php echo url_for('tralidadparenincucasos/index') ?>" method="post">
                        <table>                      
                            <tr><td>Cliente: <input type="hidden" id="indicador" name="indicador" value="1"  /></td><td colspan="3"><select id="cliente" name="cliente" onChange="llenar_contratantes(this.value);">
                                    <option value="0"  selected="seleted" > - Seleccione una opción - </option>
                                        <?php foreach ($CMB_CLIENTE_MVW as $row): ?>
                                        <option value="<?php echo $row['idepol']; ?>" <?php if ($cliente == $row['idepol']) { ?> selected="seleted" <?php } ?>><?php echo $row['descripcion']; ?></option>
                                    <?php endforeach; ?>

                                </select> </td></tr>
                            <tr><td>Contratante: </td><td colspan="3"><select id="contratante" name="contratante"  onChange="llenar_servicio2(document.getElementById('cliente').value,this.value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?>>
                                    <option value="-1"  selected="seleted" > - Seleccione una opción - </option>  
                                    <option value="todos" <?php if ($contratante == 'todos') { ?> selected="seleted" <?php } ?>>Todos</option>
                                    <?php foreach ($CMB_CONTRATANTE_MVW333 as $row): ?>
                                        <option value="<?php echo $row['CODCTROCOS']; ?>" <?php if ($contratante == $row['CODCTROCOS']) { ?> selected="seleted" <?php } ?>><?php echo $row['DESCTROCOS']; ?></option>
                                        <?php endforeach; ?>

                                </select> </td></tr>
                            <tr><td>Tipo de Servicio: </td><td colspan="3">
                                <select id="tipo_servicio" name="tipo_servicio" onChange="llenar_ano2(document.getElementById('cliente').value,document.getElementById('contratante').value,document.getElementById('tipo_servicio').value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?>>
                                    <option value="-1"  selected="seleted" > - Seleccione una opción - </option>          
                                    <option value="todos" <?php if ($tipo_servicio == 'todos') { ?> selected="seleted" <?php } ?> >Todos</option>
                                    <?php foreach ($CMB_SERVICIO as $row): ?>
                                        <option value="<?php echo $row['COD_TIPO_DES']; ?>" <?php if ($tipo_servicio == $row['COD_TIPO_DES']) { ?> selected="selected" <?php } ?>><?php echo $row['TIPO_DES']; ?></option>
                                        <?php endforeach; ?> 
                                </select> </td></tr>

                            <tr><td>Año: </td><td colspan="3"><select id="ano" name="ano" onchange="llenar_tipo_mes2(document.getElementById('cliente').value,document.getElementById('contratante').value,document.getElementById('tipo_servicio').value,this.value);" <?php if (trim($indicador) != 1) { ?> disabled ="true" <?php } ?> >
                                    <option value="-1"  selected="seleted" > - Seleccione una opción - </option>
<?php foreach ($CMB_ANNO_GENERAL3 as $row): ?>
                                        <option value="<?php echo $row['ANNO']; ?>" <?php if ($ano == $row['ANNO']) { ?> selected="seleted" <?php } ?> ><?php echo $row['ANNO']; ?></option>
                                    <?php endforeach; ?>

                                </select> </td></tr>
                            <tr><td >Mes: </td><td colspan="3">

                                <select id="mes"  name="mes" onchange="document.getElementById('tipo_servicio').disabled=false; fechas_mes(this.value,document.forms.form1.ano.value,'<?php echo $es_bisiesto; ?>');eliminarPais(document.forms.form1.inicio.value,document.forms.form1.fin.value), num_dias(this.value,document.forms.form1.ano.value);llenar_tipo_servicio(document.getElementById('cliente').value,document.getElementById('contratante').value,document.getElementById('ano').value,this.value);" <?php if (trim($indicador) != 1) { ?>  disabled ="true" <?php } ?>>
                                    <option value="-1"  selected="seleted" > - Seleccione una opción - </option> 
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
                        <div id="habil_fecha" style=" margin-top:10px; margin-bottom:10px; <?php //if(trim($indicador)!=1){ ?> display:none;<?php //}  ?>">
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
<?php if (trim($indicador) == 1) { ?>
                        <hr style="background-color:#E8E8E8; height:2px; border:0;" />

                        <!-- INICIO PANTALLAS BACKEND -->

                        <div id="showTable" name="show" >
                            <!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
    <?php
    ob_start();
    ?>
                            <!-- FIN-->    
                            <table class="tableSector">
                                <thead align="center">
                                    <tr>
                                    <th>Parentesco</th>
                                    <th >Incurrido</th>
                                    <th>Cantidad de Casos</th>                                                   
                                    </tr>
                                </thead>
                                <tbody>
    <?php
    foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):



        $parentesco = $row_tabla['parentesco_cross'];
        $cantidad = $row_tabla['cantidad'];
        $monto_servicio = str_replace(",", ".", $row_tabla['total']);

        $totalmonto = $totalmonto + $monto_servicio;
        $totalcantidad = $totalcantidad + $cantidad;

    endforeach;
    $var_srcipt = '<script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
          var data = new google.visualization.DataTable();';

    $var_srcipt = $var_srcipt . " data.addColumn('string', 'Tipo servicio');
            data.addColumn('number', 'Incurrido');       
            data.addColumn('number', 'Cantidad de casos');           
            data.addRows([ 
                ['INCURRIDO - TOTAL '," . $totalmonto . "," . $totalcantidad . "],";
    $mml = 0;
    if ($cuantos_tabla_inicial != 0) {
        ?>
                                        <?php
                                        foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):
                                            $mml++;

                                            $parentesco = $row_tabla['parentesco_cross'];
                                            $cantidad = $row_tabla['cantidad'];
                                            $monto_servicio = $row_tabla['total'];

                                            $var_srcipt = $var_srcipt . "['INCURRIDO - " . $parentesco . "'," . $monto_servicio . "," . $cantidad . "]";

                                            if ($mml < $cuantos_tabla_inicial) {

                                                $var_srcipt = $var_srcipt . ",";
                                            }
                                            ?>

                                            <tr align="center">
                                            <td><?php echo $parentesco; ?></td>
                                            <td class="alignRight"><?php echo number_format(str_replace(",", ".", $monto_servicio), 2, ",", "."); ?></td>   
                                            <td class="alignRight"><?php echo number_format(str_replace(",", ".", $cantidad), 2, ",", "."); ?></td>

                                            </tr>
                                            <?php
                                        endforeach;
                                    } else {
                                        ?>

                                        <tr align="center">      

                                        <td>No existen casos registrados</td>
                                        <td class="alignRight">0</td>
                                        <td class="alignRight">0</td>
                                        </tr>
                                    <?php
                                    }

                                    $var_srcipt = $var_srcipt . " ]); var options = {
          width: 800, height: 400,
          title: 'Parentesco + Incurrido + Nª de casos',         
          legendTextStyle: {color:'#666666'},
          is3D:'true'
          
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      </script> ";
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr style="font-weight:bold;" align="center">
                                    <td>Total</td>
                                    <td class="alignRight"><?php echo number_format(str_replace(",", ".", $totalmonto), 2, ",", "."); ?></td>
                                    <td class="alignRight"><?php echo number_format(str_replace(",", ".", $totalcantidad), 2, ",", "."); ?></td>
                                    </tr>
                                </tfoot>

                            </table>



                        </div> 

                        <div style="height:430px; margin-left:15px;" align="left">

                            <div id="chart_div"></div>
                        </div>

                        <!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
                        <?php
                        echo $var = ob_get_clean();
                        ?>
                        <!--FIN--> 


                        <!-- Formulario oculto para crear pdf-->
                        <form method="post" id="targetpdf" action="<?php echo url_for('pdf/index') ?>" target="_blank" hidden="hidden">
                            <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Parentesco + Incurrido + Nª de casos" />
                            <textarea id="text_pdf" name="text" rows="2" cols="20"  >
                                <?php echo $var; ?>
                            </textarea>
                        </form>
                        <!-- fin-->   
                        <!-- Formulario oculto para crear excel-->
                        <form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
                            <input id="titulo"  name="titulo" type="text" value="Parentesco + Incurrido + Nª de casos" />
                            <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
                        </form>
                        <!-- fin-->

                        <hr style="background-color:#E8E8E8; height:2px; border:0;" />


                        <table class="sectorBottomMenu">
                            <tr>
                            <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
                            <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td>
                            <td><a href="javascript:void(0)" onclick="window.print();" id="url_imprime">Imprimir</a></td>                                
                            </tr>                        
                        </table>
                        <div class="clear" style="padding-bottom:30px;"></div>
                    <?php } ?>                      

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    /*$("#url_imprime").click(function (){
$("html").printArea();
})*/
    
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
   

      }
 
      function llenar_servicio2(cliente,contratante)
      {
          //alert("MIlaaaaaaaaaaaaaaaaaaaaaaaa"+cliente); 
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

                             //alert("Milaaaaaaaaaaa holaaaaaaaa");
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
 
                   //document.getElementById('ano').disabled=false;
 
               }


               function llenar_ano2(cliente,contratante,servicio)
               {
                   //alert("MIlaaaaaaaaaaaaaaaaaaaaaaaa"+cliente); 
                   document.getElementById('mes').disabled=true;
                   //document.getElementById('tipo_servicio').disabled=true;
    
                   var n = document.forms.form1.ano.length;
                   var n2 = document.forms.form1.mes.length;
                   //alert(a);
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
            //->where("codexterno=", $varTmp)    
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
                ->where("idepol=$id_pol and cod_tipo_des='$cod_tipo_des' ")
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
                
    <?php foreach ($CMB_ANNO_GENERAL2 as $row_ano2):
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
                                                //  echo $id_pol2."<br />";
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
            $valorwhere = "idepol=" . $id_pol . " and to_char(FECOCURR,'yyyy')=" . $anno . " and cod_tipo_des='" . $cod_tipo_des . "'";
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
                    
        <?php foreach ($CMB_ANNO_GENERAL2 as $row_ano2):
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
                $valorwhere = "idepol=" . $id_pol . " and codexterno='" . $id_contratante . "'  and to_char(FECOCURR,'yyyy')='" . $anno . "' and cod_tipo_des='" . $cod_tipo_des . "'";
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
  

 
                  function fechas_mes(a,y)
                  {
<?php if (((fmod($ano2, 4) == 0) and (fmod($ano2, 100) != 0)) or (fmod($ano2, 400) == 0)) {
    $bi = 1;
} else {
    $bi = 0;
} ?>
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
                if(<?php echo $bi ?>==1){ document.forms.form1.fin.value="29-2-"+y;}
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
<?php if ($cuantos_tabla_inicial != 0) {
    echo $var_srcipt;
}
?>
