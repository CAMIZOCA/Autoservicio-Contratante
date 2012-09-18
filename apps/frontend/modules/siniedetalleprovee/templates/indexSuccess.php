<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('en_US') ?>
<?php 
error_reporting(E_ALL & ~E_NOTICE);  
   
 
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
    
 /*   echo "fecha_inicial:".$fecha_inicial."<br />"; 
    echo "fecha_ifinal:".$fecha_final."<br />"; 
    echo "num mes:".$num_dia_mes."<br />";
   echo "días hábiles:".$CantidadDiasHabiles."<br />";*/
     
foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla): 
                                                   
$cantidad_total_casos=$cuantos_tabla_inicial;
$monto_total=$monto_total + $row_tabla['indemnizado'];

 endforeach;
 $monto_total=$monto_total;
 if($cuantos_tabla_inicial!=0){
   $costo_promedio_caso=$monto_total/$cantidad_total_casos;
 }
 else{
   $costo_promedio_caso=0;  
 }
 if($cuantos_tabla_inicial!=0){
$promedio_casos_prov=$cantidad_total_casos/$cuantos_tabla_inicial;
 }
 else{
     $promedio_casos_prov=0;
 }
 
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
                        <li class="last">Detalle de Listado por Proveedores</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Detalle de Listado por Proveedores</h1>
                <div class="articleBox">
               <form  id="form1"  name="form1" action="<?php echo url_for('siniedetalleprovee/index') ?>" method="post">
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
                            <td><input type="submit"  class="btn_buscar" value="Buscar" /></td>
                          </tr>
                        </tr>
                    </table>
</form>
                    <!-- INICIO -->
                    <div class="clear" style="padding-bottom:30px;"></div>
                   <div style="height:70px; margin-top:10px; margin-bottom: 30px; ">
<div style="width:300px; border:solid #007a5e 1px; margin-left:20px; float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
<div style="height:20px;padding:5px; ">
<div style="float:left; height:20px; width:160px; color:#333; font-weight:bold;">Cantidad de Proveedores:</div><div style="float:left; height:25px; margin-left:10px;"><?php echo $total_proveedores;?></div>  
</div>
<div style="height:20px; border-top:solid #007a5e 1px; padding:5px;">
  <div style="float:left; height:20px;width:230px; color:#333; font-weight:bold;">Cantidad Promedio de Casos/Proveedor:</div><div style="float:left; height:20px; margin-left:10px;"><?php echo $promedio_casos_prov;?></div>
</div></div>

<!-- otra cajita --><!-- otra cajita -->
<div style="width:220px; border:solid #007a5e 1px; margin-left:20px;  float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
<div style="height:20px;padding:5px; ">
<div style="float:left; height:20px; width:100px; color:#333; font-weight:bold;">Total Reclamos:</div><div style="float:left; height:25px; margin-left:10px;"><?php echo $cuantos_tabla_inicial;?></div>  
</div>
<div style="height:20px; border-top:solid #007a5e 1px; padding:5px;">
  <div style="float:left; height:20px;width:160px; color:#333; font-weight:bold;">Total Personas Atendidas:</div><div style="float:left; height:20px; margin-left:10px;"><?php echo $total_per_atendidas;?></div>
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
<div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#007a5e; font-weight:bold; margin-bottom:15px;" align="center">Detalle de Listado de <?php echo $servicio_busca;?></div>
                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />

                    <!-- INICIO PANTALLAS BACKEND -->
<table class="tableSector">
                                            <thead>
                                                <tr>
                                                    <th><div align="center" >Nombre del Proveedor</div></th>
                                                    <th ><div align="center" style="margin-right:20px; width:80px;">Rif</div></th>
                                                    <th><div align="center" style="margin-right:20px; width:90px;">CI. del Afiliado</div></th>
                                                    <th><div align="center" style="margin-right:20px; width:90px;">Tipo Servicio</div></th>
                                                    <th><div align="center" style="margin-right:20px; width:90px;">Parentesco</div></th>
                                                    <th><div align="center" style="margin-right:20px; width:90px;">Fecha de Ocurrencia</div></th>
                                                    <th><div align="center" style=" width:140px;">Monto en Bs.</div></th>
                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if($cuantos_tabla_inicial!=0){?>
                                             <?php foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla): 
                                                   
                                                 $id_prov=$row_tabla['cod_ben_pago'];
                                                 $nombre_prov=$row_tabla['ben_pago'];
                                                 $ci_paciente=$row_tabla['ci_paciente'];
                                                 $paciente=$row_tabla['paciente'];
                                                 $tipo_des=$row_tabla['tipo_des'];
                                                 $parentesco=$row_tabla['parentesco'];
                                                 $fecocurr=date('d/m/Y',strtotime($row_tabla['fecocurr']));
                                                 $monto=$row_tabla['indemnizado'];
                                                  $url='siniedetalle/index?cliente='.$cliente.'&contratante='.$contratante.'&ano='.$ano.'&mes='.$mes2.'&tipo_servicio='.$cod_tipo_des.'&servicio='.$tipo_des.'&ci_paciente='.$ci_paciente.'&rif='.$rif.'&tipo_lis=3';
                                             ?>
                                                                                              
                                               
                                                <tr>      
                                                    
                                                    <td><div style="float:left; "><input class="botonadd" type="button" /></div><div style="float:left; margin-left:9px; padding:5px; width:200px;"><?php echo $nombre_prov; ?></div></td>
                                                    <td><div align="center" style="margin-right:20px; width:80px;"><?php //echo $row['mtotal']; ?></div></td>
                                                    <td><div align="center" style="margin-right:20px; width:90px;"><?php echo $ci_paciente; ?></div></td>
                                                    <td><div align="center" style="margin-right:20px; width:90px;"><?php echo $tipo_des; ?></div></td>
                                                    <td><div align="center" style="margin-right:20px; width:90px;"><?php echo $parentesco;?></div></td>
                                                    <td><div align="center" style="margin-right:20px; width:90px;"><?php echo $fecocurr;?></div></td>
                                                    <td><div align="right" style=" padding-right:40px; width:100px;"><?php echo format_number($monto);?></div></td>
                                                    
                                                </tr>
                                                <?php endforeach; }
                                                
                                                else{
                                            ?>
                                                
                                                <tr>      
                                                    
                                                    <td width="250"><div style="float:left; margin-left:9px; width:200px;">No Exiten registros para esta busqueda</div><?php //echo $row['mparentesco']; ?></td>
                                                    <td><div align="center" style="margin-right:20px; width:80px;">0</div></td>
                                                    <td><div align="center" style="margin-right:20px; width:80px;">0</div></td>
                                                    <td><div align="center" style="margin-right:20px; width:80px;">0</div></td>
                                                    <td><div align="center" style="margin-right:20px; width:80px;">0</div></td>
                                                    <td><div align="center" style="margin-right:20px; width:80px;">0</div></td>
                                                    <td><div align="right" style=" padding-right:40px; width:100px;">0</div></td>
                                                    
                                                </tr>
                                                <?php } ?>
                                               
                                               
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

  

  var n = document.forms.form1.contratante.length;

  //alert(a);
  
  for (var i=0; i<n;++i){      
      document.forms.form1.contratante.remove(document.forms.form1.contratante.options[i]);//eliminar lineas del 2do combo...
  }
     document.forms.form1.contratante[0]= new Option("- Seleccione una opción -",'-1'); 
   document.forms.form1.contratante[1]= new Option("Todos",'todos'); //creamos primera linea del segundo combo

 
     <?php  foreach ($CMB_CLIENTE_MVW as $row_c): 
            $id_pol=$row_c['idepol'];
         ?> 
                           
	   	
	   if (a== '<?php echo $id_pol;?>'){

            <?php
            $valorwhere='idepol='.$id_pol;
            $q = Doctrine_Query::create()
                ->from('CMB_CONTRATANTE_MVW  J')
                ->where($valorwhere);
        $CONTRATO_POLIZA_VW_filtrado  = $q->fetchArray(); 
        foreach ($CONTRATO_POLIZA_VW_filtrado as $row_pf): 
            $id_pol2=$row_pf['codctrocos'];
            $des_contratante=$row_pf['desctrocos'];?>
         
           document.forms.form1.contratante[document.forms.form1.contratante.length]= new Option("<?php echo $des_contratante;?>",'<?php echo $id_pol2;?>'); 
            <?php   endforeach;  ?>
           }
  <?php  endforeach; ?>
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
     <?php  foreach ($CMB_CLIENTE_MVW as $row_c): 
            $id_pol=$row_c['idepol'];
         ?> 
                           
	   	
	   if (cliente== '<?php echo $id_pol;?>'){

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
            $cod_tipo_des=$row_pf['cod_tipo_des'];
            $tipo_des=$row_pf['tipo_des']; ?>                        
            
           document.forms.form1.tipo_servicio[document.forms.form1.tipo_servicio.length]= new Option("<?php echo $tipo_des;?>",'<?php echo $cod_tipo_des;?>'); 
        <?php  endforeach; ?>
            
           }
           <?php  endforeach; ?>
           
        }
       else{
          
           <?php 
         foreach ($CMB_CONTRATANTE_MVW333 as $rowcontratante): 
               $codctrocos=$rowcontratante['CODCTROCOS'];        
            ?> 
                        
           if(contratante=='<?php echo $codctrocos;?>'){
            <?php   $q22 = Doctrine_Query::create()                
                ->select("cod_tipo_des, tipo_des, id")
                ->from('SINIESTRALIDAD_VW  J')
                ->where(" idepol='$id_pol' and codexterno='$codctrocos'")
             ->groupBy("cod_tipo_des, tipo_des, id")
             ->orderBy(" tipo_des ASC");         

            $CMB_SERVICIO = $q22->fetchArray();
            
        foreach ( $CMB_SERVICIO as $row_pf): 
            $cod_tipo_des=$row_pf['cod_tipo_des'];
            $tipo_des=$row_pf['tipo_des']; ?>                        
            
           document.forms.form1.tipo_servicio[document.forms.form1.tipo_servicio.length]= new Option("<?php echo $tipo_des;?>",'<?php echo $cod_tipo_des;?>'); 
        <?php  endforeach; ?>
             }
           <?php  endforeach; ?>
             
           
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
     <?php  foreach ($CMB_CLIENTE_MVW as $row_c): 
            $id_pol=$row_c['idepol'];
         ?> 
                           
	   	
	 if (cliente== '<?php echo $id_pol;?>'){

            //alert("Milaaaaaaaaaaa holaaaaaaaa");
            
            if(servicio=='todos'){
            <?php
            
            $valorwhere='idepol='.$id_pol;
             $q = Doctrine_Query::create() 
                 ->select("to_char(fecocurr, 'yyyy') as anno")
                ->from("SINIESTRALIDAD_VW   J")
                ->where($valorwhere)      
                //->where("codexterno=", $varTmp)    
                ->groupBy("to_char(fecocurr, 'yyyy')");
             
           $CMB_ANNO = $q->fetchArray();
            
        //$CONTRATO_POLIZA_VW_filtrado  = $q->fetchArray(); 
        foreach ($CMB_ANNO as $row_pf): 
            $anno=$row_pf['anno']; ?>
          //  echo $id_pol2."<br />";
           document.forms.form1.ano[document.forms.form1.ano.length]= new Option("<?php echo $anno;?>",'<?php echo $anno;?>'); 
            <?php   endforeach; 
        ?>
            
            }
            else{
            <?php $q2_servicio = Doctrine_Query::create()                
            ->select("cod_tipo_des, tipo_des, id")
            ->from('SINIESTRALIDAD_VW  J')            
            ->groupBy("cod_tipo_des, tipo_des, id")
            ->orderBy(" tipo_des ASC");
           $CMB_SERVICIO = $q2_servicio->fetchArray();
           foreach ($CMB_SERVICIO as $row_ser): 
            $cod_tipo_des=$row_ser['cod_tipo_des'];
             ?> 
              if(servicio==<?php echo $cod_tipo_des?>){
                <?php  
                $valorwhere='idepol='.$id_pol;
                $q = Doctrine_Query::create() 
                ->select("to_char(fecocurr, 'yyyy') as anno")
                ->from("SINIESTRALIDAD_VW   J")
                ->where("idepol=$id_pol and cod_tipo_des=$cod_tipo_des ") 
                ->groupBy(" to_char(fecocurr, 'yyyy')");
                
                $CMB_ANNO = $q->fetchArray();
               foreach ($CMB_ANNO as $row_pf): 
            $anno=$row_pf['anno']; ?>
          //  echo $id_pol2."<br />";
           document.forms.form1.ano[document.forms.form1.ano.length]= new Option("<?php echo $anno;?>",'<?php echo $anno;?>'); 
            <?php   endforeach; ?>    
                }
                <?php   endforeach; ?>
            }
            
           }
           <?php  endforeach; ?>
           
        }
       else{
         
           <?php 
         foreach ($CMB_CONTRATANTE_MVW333 as $rowcontratante): 
               $codctrocos=$rowcontratante['CODCTROCOS'];        
            ?> 
              ///// alert ("AAAAAAAAAAAAAAAAAAAAAAA"+contratante);          
           if(contratante=='<?php echo $codctrocos;?>'){
               if(servicio=='todos'){
      <?php
            
            $valorwhere=' CODEXTERNO='.$codctrocos;
             $q33 = Doctrine_Query::create() 
                 ->select("to_char(fecocurr, 'yyyy') as anno")
                ->from("SINIESTRALIDAD_VW   J")
               ->where(" codexterno ='$codctrocos'")      
               // ->where(" codexterno= ", $codctrocos)    
                ->groupBy("to_char(fecocurr, 'yyyy')");
             
           $CMB_ANNO = $q33->fetchArray(); 
           
            foreach ($CMB_ANNO as $row_pf): 
            $anno=$row_pf['anno']; ?>
          
           document.forms.form1.ano[document.forms.form1.ano.length]= new Option("<?php echo $anno;?>",'<?php echo $anno;?>'); 
            <?php   endforeach; 
        ?>
                                }
             else{
                 <?php $q2_servicio = Doctrine_Query::create()                
            ->select("cod_tipo_des, tipo_des, id")
            ->from('SINIESTRALIDAD_VW  J')            
            ->groupBy("cod_tipo_des, tipo_des, id")
            ->orderBy(" tipo_des ASC");
           $CMB_SERVICIO = $q2_servicio->fetchArray();
                 
                 foreach ($CMB_SERVICIO as $row_ser): 
            $cod_tipo_des=$row_ser['cod_tipo_des'];
             ?> 
              if(servicio==<?php echo $cod_tipo_des?>){
                <?php  
                $valorwhere='idepol='.$id_pol;
                $q = Doctrine_Query::create() 
                ->select("to_char(fecocurr, 'yyyy') as anno")
                ->from("SINIESTRALIDAD_VW   J")
                ->where("codexterno ='$codctrocos' and idepol=$id_pol and cod_tipo_des=$cod_tipo_des ") 
                ->groupBy(" to_char(fecocurr, 'yyyy')");
                
                $CMB_ANNO = $q->fetchArray();
               foreach ($CMB_ANNO as $row_pf): 
            $anno=$row_pf['anno']; ?>
          //  echo $id_pol2."<br />";
           document.forms.form1.ano[document.forms.form1.ano.length]= new Option("<?php echo $anno;?>",'<?php echo $anno;?>'); 
            <?php   endforeach; ?>    
                }
                <?php   endforeach; ?>
            }                    
                  
             }
           <?php  endforeach; ?>
             
           
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
     <?php  foreach ($CMB_CLIENTE_MVW as $row_c): 
            $id_pol=$row_c['idepol'];
         ?> 
                           
	   	
	   if (cliente== '<?php echo $id_pol;?>'){
<?php 
             
              $q = Doctrine_Query::create()                
                ->select("to_char(FECOCURR,'yyyy') as anno")
                ->from('SINIESTRALIDAD_VW  J')               
             ->groupBy("to_char(fecocurr,'yyyy')")
             ->orderBy("to_char(FECOCURR,'yyyy') asc");         

            $CMB_ANNO_GENERAL2 = $q->fetchArray();?>
            
            <?php foreach ($CMB_ANNO_GENERAL2 as $row_ano2): 
            $anno=$row_ano2['anno'];?>
                                
            
            if(ano=='<?php echo $anno;?>'){
                
            if(servicio=='todos'){  
            <?php 
              $valorwhere="idepol=".$id_pol." and to_char(FECOCURR,'yyyy')=".$anno;
              $q = Doctrine_Query::create()                
                ->select("to_char(FECOCURR,'mm') as mes, to_char(FECOCURR,'yyyy') as anno")
                ->from('SINIESTRALIDAD_VW  J')
                ->where($valorwhere)
             ->groupBy("to_char(fecocurr,'mm'),to_char(fecocurr,'yyyy')")
             ->orderBy("to_char(FECOCURR,'yyyy') asc, to_char(FECOCURR,'mm') asc");         

            $CMB_MES = $q->fetchArray();
             
         
            
        //$CONTRATO_POLIZA_VW_filtrado  = $q->fetchArray(); 
        foreach ($CMB_MES as $row_pf): 
            $anno=$row_pf['anno'];
            $mes=$row_pf['mes'];
            
             switch ($mes) {
          case '01':
           $mes_tabla='Enero ';  
            break;
        case '02':
            $mes_tabla='Febrero ';
            
            break;
        case '03':
            $mes_tabla='Marzo ';
           
            break;
        case '04':
            $mes_tabla='Abril ';
            
            break;
        case '05':
            $mes_tabla='Mayo ';
            
            break;
        case '06':
            $mes_tabla='Junio ';
            
            break;
        case '07':
            $mes_tabla='Julio ';
            
            break;
        case '08':
            $mes_tabla='Agosto ';
            
            break;
        case '09':
            $mes_tabla='Septiembre ';
           
            break;
         case '10':
            $mes_tabla='Octubre ';
           
            break;         
         case '11':
            $mes_tabla='Noviembre ';
         
            break;
        case '12':
            $mes_tabla='Diciembre ';
            
            break;                                                      

    }
            
            ?>
          //  echo $id_pol2."<br />";
           document.forms.form1.mes[document.forms.form1.mes.length]= new Option("<?php echo $anno.' '.$mes_tabla;?>",'<?php echo $mes;?>'); 
            <?php   endforeach;         ?>
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
               $cod_tipo_des=$row_ser['cod_tipo_des'];  
            ?> 
            if(servicio==<?php echo $cod_tipo_des;?>){
                         <?php 
              $valorwhere="idepol=".$id_pol." and to_char(FECOCURR,'yyyy')=".$anno." and cod_tipo_des=".$cod_tipo_des;
              $q = Doctrine_Query::create()                
                ->select("to_char(FECOCURR,'mm') as mes, to_char(FECOCURR,'yyyy') as anno")
                ->from('SINIESTRALIDAD_VW  J')
                ->where($valorwhere)
             ->groupBy("to_char(fecocurr,'mm'),to_char(fecocurr,'yyyy')")
             ->orderBy("to_char(FECOCURR,'yyyy') asc, to_char(FECOCURR,'mm') asc");         

            $CMB_MES = $q->fetchArray();
             
         
            
        //$CONTRATO_POLIZA_VW_filtrado  = $q->fetchArray(); 
        foreach ($CMB_MES as $row_pf): 
            $anno=$row_pf['anno'];
            $mes=$row_pf['mes'];
            
             switch ($mes) {
          case '01':
           $mes_tabla='Enero ';  
            break;
        case '02':
            $mes_tabla='Febrero ';
            
            break;
        case '03':
            $mes_tabla='Marzo ';
           
            break;
        case '04':
            $mes_tabla='Abril ';
            
            break;
        case '05':
            $mes_tabla='Mayo ';
            
            break;
        case '06':
            $mes_tabla='Junio ';
            
            break;
        case '07':
            $mes_tabla='Julio ';
            
            break;
        case '08':
            $mes_tabla='Agosto ';
            
            break;
        case '09':
            $mes_tabla='Septiembre ';
           
            break;
         case '10':
            $mes_tabla='Octubre ';
           
            break;         
         case '11':
            $mes_tabla='Noviembre ';
         
            break;
        case '12':
            $mes_tabla='Diciembre ';
            
            break;                                                      

    }
            
            ?>
          //  echo $id_pol2."<br />";
           document.forms.form1.mes[document.forms.form1.mes.length]= new Option("<?php echo $anno.' '.$mes_tabla;?>",'<?php echo $mes;?>'); 
            <?php   endforeach;         ?>   
            }                            
            <?php   endforeach;         ?>                           
         }/// servcio else
         
         
         }
              <?php   endforeach; 
        ?>
           }
           <?php  endforeach; ?>
           
        }
       else{////ESTE ES EL PRINCIPAL
           
           
       }///ESTE ES EL PRINCIPAL
             
 
   document.getElementById('mes').disabled=false;
   document.getElementById('habil_fecha').style.display="none";
   //document.getElementById('tipo_servicio').disabled=false;
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