<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('en_US') ?>
<?php  
//error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);  
        //echo "<h1>$greetings</h1>";
 //$temp55=$_POST['mes'];
//$valor_get=
//echo "parametros:".$valor_get;
/*$cliente=$sf_params->get('cliente');
$tipo_servicio=$sf_params->get('tipo_servicio');
$ano=$sf_params->get('ano');
$mes=$sf_params->get('mes');
$contratante=$sf_params->get('contratante');


 //echo "Cliente:".$sf_params->get('cliente')."<br />";
 // echo "Servicio:".$tipo_servicio."<br />";
echo "ano:".$sf_params->get('ano')."<br />";
/* echo "mes:".$sf_params->get('mes')."<br />";
 echo "contratante:".$sf_params->get('contratante')."<br />";
 //$ano_actual=date('Y');*/
 //echo $ano_actual;
 
function DiasHabiles($fecha_inicial,$fecha_final)
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
 

     $CantidadDiasHabiles = Evalua(DiasHabiles($fecha_inicial,$fecha_final)); 

     

 
    ?>  

<div id="mainContentSector"><!--end innerwrap--> 
    <div id="innerwrap"> 
      <div id="sideBar">
            <!-- MODULO ACTIVO -->
            <?php include('_modActivo.php'); ?>
            <!-- DEADLINE -->            
            <?php include_partial('poblaconsol/quickDeadlineBox') ?>
            <!-- QUICK RECORD -->
            <?php include_partial('poblaconsol/quickUserBox', array(
                'UserName' => $UserName, 
                'FirstName' => $FirstName,
                'LastName' => $LastName,
                'CreatedAt' => $CreatedAt                
                )) ?>     
       </div>
        <div id="contentBar">
            <div class="articleContentSector">
                <!-- BREADCRUMB -->
              <div class="breadcrumbBox">
                    <ul>
                        <li><a href="<?php echo url_for('maindashboard/index') ?>">AutoServicio</a></li>
                        <li><a href="#">Siniestros</a></li>
                        <li class="last"> Listado de Personas Atendidas por Servicio</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">  Listado de Personas Atendidas por Servicio (Listado de Frecuencias)</h1>
                <div class="articleBox">
          <form  id="form1"  name="form1" action="<?php echo url_for('siniedetallpatolo/index') ?>" method="post">
                   <table>
                       <?php //echo $form; ?>
                        <tr><td>Cliente: </td><td colspan="3"><select id="cliente" name="cliente" onChange="llenar_contratantes(this.value);">
                                    <?php foreach ($ente_contratante_vw as $row): ?>
                                    <option value="<?php echo $row['idepol']; ?>" <?php if ($cliente==$row['idepol']){?> selected="seleted" <?php }?>><?php 
                                    echo $row['descripcion']; ?></option>
                                     <?php endforeach; ?>

                                </select> </td></tr>
                          <tr><td>Contratante: </td><td colspan="3"><select id="contratante" name="contratante">
                                    <option value="todos" selected="selected" >Todos</option>
                                    <?php foreach ($CONTRATO_POLIZA_VW as $row): ?>
                                    <option value="<?php echo $row['codctrocos']; ?>" <?php if ($contratante==$row['codctrocos']){?> selected="seleted" <?php }?>><?php 
                                    echo $row['desctrocos']; ?></option>
                                     <?php endforeach; ?>

                                </select> </td></tr>
                        <tr><td>Año: </td><td colspan="3"><select id="ano" name="ano" onchange="fechas_mes(document.forms.form1.mes.value,this.value,'<?php echo $es_bisiesto;?>');">
                                    <!--<option value="0"  <?php if($ano=='0'){?> selected="selected" <?php }?>  >Todos</option>--> 
                                     <?php foreach ($SINIESTRALIDAD_VW_combo_ano as $row): ?>
                                    <option value="<?php echo $row['ano']; ?>" <?php if($ano==$row['ano']){?> selected="selected" <?php }?>><?php 
                                    echo $row['ano']; ?></option>
                                     <?php  endforeach; ?>
                                    <!--<option value="2012" <?php if($ano==2012){?> selected="selected" <?php }?>>2012</option>
                                    <option value="2011" <?php if($ano==2011){?> selected="selected" <?php }?> >2011</option>-->
                                </select> </td></tr>
                        <tr><td >Mes: </td><td colspan="3">
                             <?php    //echo "fecha_inicial:".$fecha_inicial."<br />"; 
                                      //echo "fecha_ifinal:".$fecha_final."<br />"; ?>
                                <select id="mes"  name="mes" onchange="fechas_mes(this.value,document.forms.form1.ano.value,'<?php echo $es_bisiesto;?>');eliminarPais(document.forms.form1.inicio.value,document.forms.form1.fin.value), num_dias(this.value,document.forms.form1.ano.value);" >
                                    <option value="0"  <?php if($mes=='0'){?> selected="selected" <?php }?>  >Todos</option>                                    
                                    <option value="01" <?php if($mes=='01'){?> selected="selected" <?php }?>>Enero</option>
                                    <option value="02"  <?php if($mes=='02'){?> selected="selected" <?php }?>>Febrero</option>
                                    <option value="03" <?php if($mes=='03'){?> selected="selected" <?php }?>>Marzo</option>
                                    <option value="04" <?php if($mes=='04'){?> selected="selected" <?php }?>>Abril</option>
                                    <option value="05" <?php if($mes=='05'){?> selected="selected" <?php }?>>Mayo</option>
                                    <option value="06" <?php if($mes=='06'){?> selected="selected" <?php }?>>Junio</option>
                                    <option value="07" <?php if($mes=='07'){?> selected="selected" <?php }?>>Julio</option>
                                    <option value="08" <?php if($mes=='08'){?> selected="selected" <?php }?>>Agosto</option>
                                    <option value="09" <?php if($mes=='09'){?> selected="selected" <?php }?>>Septiembre</option>
                                    <option value="10" <?php if($mes=='10'){?> selected="selected" <?php }?>>Octubre</option>
                                    <option value="11" <?php if($mes=='11'){?> selected="selected" <?php }?>>Noviembre</option>
                                    <option value="12" <?php if($mes=='12'){?> selected="selected" <?php }?>>Diciembre</option>

                                </select> 
                            
                           
                            </td>
                        
                        </tr>
                        <tr>
                          <td height="21" >Días del Mes:</td>
                          <td height="21" > <input name="dias_mes" id="dias_mes" value="<?php echo $dias_mes;?>" readonly="true" size="5" /></td>
                          <td  width="90">Dias Hábiles:</td>
                          <td ><input name="dias_habiles" id="dias_habiles" value="<?php echo $CantidadDiasHabiles;?>" readonly="true" size="5" /></td>
  </tr>
                        
                      
            <tr>
                          <td height="21" >Fecha Inicio:</td>
                          <td height="21" > <input name="inicio" id="inicio" value="<?php echo $fecha_inicial;?>" readonly="true" size="10" /></td>
                          <td  width="90">Fecha Fin:</td>
                          <td ><input name="fin" id="fin" value="<?php echo $fecha_final;?>" readonly="true" size="10" /></td>
  </tr>
                                    
                        <tr><td>Tipo de Servicio: </td><td colspan="3">
                                <select id="tipo_servicio" name="tipo_servicio" >
                                     <option value="todos" <?php if($tipo_servicio=='' or $tipo_servicio=='todos' ){?> selected="selected" <?php $servicio_busca='todos';} ?>>Todos</option>
                                    <?php foreach ($SINIESTRALIDAD_VW_combo_servicios as $row): ?>
                                    <option value="<?php echo $row['cod_tipo_des']; ?>" <?php if($tipo_servicio==$row['cod_tipo_des']){?> selected="selected" <?php $servicio_busca=$row['tipo_des'];}?>><?php 
                                    echo $row['tipo_des']; ?></option>
                                     <?php  endforeach; ?> 
                                </select> </td></tr>
                        <tr>
                            <td><input type="submit" class="btn_buscar"  value="Buscar" /></td>
                          </tr>
                        </tr>
                    </table>
</form>
                    <!-- INICIO -->
                    <div class="clear" style="padding-bottom:30px;"></div>
                  <div  style="height:70px; margin-top:10px; margin-bottom: 30px; " >
<div style="width:300px; border:solid #007a5e 1px; margin-left:20px; float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
<div style="height:20px;padding:5px; ">
<div style="float:left; height:20px; width:160px; color:#333; font-weight:bold;">Cantidad de Proveedores:</div><div style="float:left; height:25px; margin-left:10px;"  ><?php echo $total_proveedores;?></div>  
</div>
<div style="height:20px; border-top:solid #007a5e 1px; padding:5px;">
  <div style="float:left; height:20px;width:230px; color:#333; font-weight:bold;">Cantidad Promedio de Casos/Proveedor:</div><div style="float:left; height:20px; margin-left:10px;"><?php echo $promedio_casos_prov;?></div>
</div></div>

<!-- otra cajita --><!-- otra cajita -->
<div style="width:220px; border:solid #007a5e 1px; margin-left:20px;  float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
<div style="height:20px;padding:5px; ">
<div style="float:left; height:20px; width:100px; color:#333; font-weight:bold;">Total Reclamos:</div><div style="float:left; height:25px; margin-left:10px;"><?php echo $cantidad_total_casos;?></div>  
</div>
<div style="height:20px; border-top:solid #007a5e 1px; padding:5px;">
<div style="float:left; height:20px;width:160px; color:#333; font-weight:bold;">Total Personas Atendidas:</div><div style="float:left; height:20px; margin-left:10px;"><?php echo $total_per_atendidas."?";?></div>
</div></div>

<!-- otra cajita --><!-- otra cajita -->

<div style="width:240px; border:solid #007a5e 1px; margin-left:20px; float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px; ">
<div style="height:20px;padding:5px; ">
<div style="float:left; height:20px; width:140px; color:#333; font-weight:bold;">Monto Total Bs:</div><div style="float:left; height:25px; margin-left:10px; width:70px;" align="right" ><?php echo format_number($monto_total);?></div>  
</div>
<div style="height:20px; border-top:solid #007a5e 1px; padding:5px;">
  <div style="float:left; height:20px;width:140px; color:#333; font-weight:bold;">Costo Promedio/Caso:</div><div style="float:left; height:20px; margin-left:10px; width:70px;"  align="right"><?php echo format_number($costo_promedio_caso);?></div>
</div></div>

<!-- otra cajita --><!-- otra cajita -->
                   </div>  
                   
<div style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#007a5e; font-weight:bold; margin-bottom:15px;" align="center"> Listado de Personas Atendidas y Frecuencia por Patologías <?php echo ucfirst(strtr(strtolower($servicio_busca), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú"));?></div>
                  <div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#007a5e; font-weight:bold; margin-bottom:15px; height:60px;" align="center">
                      <div style="width:250px; border:solid #007a5e 1px; margin-left:20px; float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                        <div style="height:20px;padding:5px; ">
                          <div style="float:left; height:20px; width:160px; color:#333; font-weight:bold;">Total Patologías:</div>
                          <div style="float:left; height:25px; margin-left:10px;">200</div>
                        </div>
                      </div>
                      <div style="width:250px; border:solid #007a5e 1px; margin-left:20px; float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                        <div style="height:20px;padding:5px; ">
                          <div style="float:left; height:20px; width:160px; color:#333; font-weight:bold;">Total Reclamos:</div>
                          <div style="float:left; height:25px; margin-left:10px;">200</div>
                        </div>
                      </div>
                      <div style="width:250px; border:solid #007a5e 1px; margin-left:20px; float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                        <div style="height:20px;padding:5px; ">
                          <div style="float:left; height:20px; width:160px; color:#333; font-weight:bold;">Total Personas Atendidas:</div>
                          <div style="float:left; height:25px; margin-left:10px;">200</div>
                        </div>
                        
                      </div>
                    </div>
                    <!-- INICIO PANTALLAS BACKEND -->
<table class="tableSector">
                                            <thead>
                                                <tr>
                                                    <th>Tipo de Servicio</th>
                                                    <th>Total de Personas Atendidas</th>
                                                    <th>Cantidad Total de Casos Generados</th>
                                                    <th>Costo Total</th>
                                                    <th>Costo Promedio/Persona Bs</th>
                                                    <th>Número de Casos Promedio/Persona</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php //foreach ($POBLACION_CONSOLIDADA_VW as $row): ?>
                                                                                              
                                                
                                                <tr>      
                                                    
                                                    <td align="left"><input type="button" />Claves de Emergencia<?php //echo $row['mparentesco']; ?></td>
                                                    <td align="center">0<?php //echo $row['mtotal']; ?></td>
                                                    <td align="center">0<?php //echo $row['fparentesco']; ?></td>
                                                    <td align="center">0<?php //echo $row['ftotal']; ?></td>
                                                    <td align="center">0<?php //echo $row['totalgrupo']; ?></td>
                                                    <td align="center">0&nbsp;</td>
                                                </tr>
                                                 <tr>      
                                                    
                                                    <td align="left"><input type="button" />Cartas Avales<?php //echo $row['mparentesco']; ?></td>
                                                    <td align="center">0<?php //echo $row['mtotal']; ?></td>
                                                    <td align="center">0<?php //echo $row['fparentesco']; ?></td>
                                                    <td align="center">0<?php //echo $row['ftotal']; ?></td>
                                                    <td align="center">0<?php //echo $row['totalgrupo']; ?></td>
                                                    <td align="center">0&nbsp;</td>
                                                </tr>
                                                <?php 
                                                //suma de totales
                                                //$totalMasculino = $totalMasculino + $row['mtotal'];
                                               // $totalFemenino = $totalFemenino + $row['ftotal'];
                                                //$totalGrupo = $totalGrupo + $row['totalgrupo'];
                                                //endforeach; 
                                                ?>
                                            </tbody>
                                            <tbody>
                                            </tbody>
                    
                  </table> 

                    

            
                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />


                    <table class="sectorBottomMenu">
                        <tr>
                            <td>
                                Exportar a: 
                            </td>
                            <td><select id="temp">
                                    <option value="1">PDF</option>
                                    <option value="2">EXCEL</option>
                                </select>
                                <input type="button" value="Descargar" /></td>
                        </tr>
                        <tr>
                            <td>Impresión: </td>
                            <td><input type="button" value="Vista Previa" /> </td>
                        </tr>
                    </table>
                    <div class="clear" style="padding-bottom:30px;"></div>
              </div>
            </div>
        </div>
    </div>
</div>
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

 
     <?php  foreach ($ente_contratante_vw as $row_c): 
            $id_pol=$row_c['idepol'];
         ?> 
                           
	   	
	   if (a== '<?php echo $id_pol;?>'){

            //alert("Milaaaaaaaaaaa holaaaaaaaa");
            <?php
            
            $valorwhere='idepol='.$id_pol;
            $q = Doctrine_Query::create()
                ->from('CONTRATO_POLIZA_VW  J')
                ->where($valorwhere);
        $CONTRATO_POLIZA_VW_filtrado  = $q->fetchArray(); 
        foreach ($CONTRATO_POLIZA_VW_filtrado as $row_pf): 
            $id_pol2=$row_pf['idepol'];
            $des_contratante=$row_pf['desctrocos'];?>
          //  echo $id_pol2."<br />";
           document.forms.form1.contratante[document.forms.form1.contratante.length]= new Option("<?php echo $des_contratante;?>",'<?php echo $id_pol2;?>'); 
            <?php   endforeach; 
        ?>
            
           }
           <?php  endforeach; ?>
 

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