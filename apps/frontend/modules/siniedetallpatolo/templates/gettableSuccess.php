<?php use_helper('Number');
use_helper('Date');
?> 
<?php $sf_user->setCulture('es_VE') ?>
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
    $mes2=$mes;
 /*   echo "fecha_inicial:".$fecha_inicial."<br />"; 
    echo "fecha_ifinal:".$fecha_final."<br />"; 
    echo "num mes:".$num_dia_mes."<br />";
   echo "días hábiles:".$CantidadDiasHabiles."<br />";*/
     
foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla): 
                                                   

$monto_total=$monto_total + $row_tabla['INDEMNIZADO'];

 endforeach;
 
 //echo "total_registros".$cuantos_tabla_inicial;
 if($cuantos_tabla_inicial!=0){
   $costo_promedio_caso=$monto_total/$cuantos_tabla_inicial;
 }
 else{
   $costo_promedio_caso=0;  
 }
 
 if($cuantos_tabla_inicial!=0){
   $promedio_casos_patolo=$cuantos_tabla_inicial/$num_patologias;
 }
 else{
     $promedio_casos_patolo=0;
 }
 
    ?> 
               
<div class="cajas_totales" >
    <div class="cajitas_peq_totales">
      <div class="linea">
        <div class="titulo_cajita">Cantidad de Patologías:</div>
        <div class="total_bs" ><?php echo number_format($num_patologias, 2, ",", "."); ?></div>  
      </div>
      <div class="linea_media">
          <div class="titulo_cajita">Cantidad Promedio de Casos/Patología:</div>
          <div class="total_bs"><?php echo number_format($promedio_casos_patolo, 2, ",", "."); ?></div>
      </div>
    </div>

<!-- otra cajita --><!-- otra cajita -->
    <div class="cajitas_peq_totales_med">
        <div class="linea">
            <div class="titulo_cajita_med">Total Reclamos:</div>
            <div class="total_bs_med"><?php echo number_format($cuantos_tabla_inicial, 2, ",", ".");?></div>  
        </div>
        <div class="linea_media">
            <div class="titulo_cajita_med">Total Personas Atendidas:</div>
            <div class="total_bs_med"><?php echo number_format($total_per_atendidas, 2, ",", "."); ?></div>
        </div>
    </div>

<!-- otra cajita --><!-- otra cajita -->

    <div class="cajitas_peq_totales_med">
        <div class="linea">
            <div class="titulo_cajita_med" >Monto Total Bs:</div>
            <div class="total_bs_med" ><?php echo number_format($monto_total, 2, ",", "."); ?></div>  
        </div>
        <div class="linea_media">
            <div class="titulo_cajita_med">Costo Promedio/Caso:</div>
            <div class="total_bs_med"><?php echo number_format($costo_promedio_caso, 2, ",", "."); ?></div>
        </div>
    </div>

<!-- otra cajita --><!-- otra cajita -->

</div>
<div class="titulo_reporte">Detalle de Listado de Patologías por <?php echo ucfirst(strtr(strtolower($servicio_busca), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú"));?></div>
                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />

                    <!-- INICIO PANTALLAS BACKEND -->
<table class="tableSector">
                                            <thead>
                                                <tr <div align="center" >
                                                    
                                                    <th>Nombre de la Patología</th>
                                                    <th >CI. del Afiliado</th>
                                                    <th>Nombre del Afiliado</th>
                                                    <th>Tipo Servicio</th>
                                                    <th>Parentesco</th>
                                                    <th>Fecha de Ocurrencia</th>
                                                    <th>Monto en Bs.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                          <?php if($cuantos_tabla_inicial!=0){?>
                                             <?php foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla): 
                                                   
                                                 $enfermedad=$row_tabla['ENFERMEDAD'];
                                                 $ci_paciente=$row_tabla['CI_PACIENTE'];                                                 
                                                 $paciente=$row_tabla['PACIENTE'];
                                                 $tipo_des=$row_tabla['TIPO_DES'];
                                                 $parentesco=$row_tabla['PARENTESCO'];
                                                 $fecocurr=date('d/m/Y',strtotime($row_tabla['FECOCURR']));
                                                 $monto=$row_tabla['INDEMNIZADO'];
                                                  $url='siniedetalle/index?cliente='.$cliente.'&contratante='.$contratante.'&ano='.$ano.'&mes='.$mes2.'&tipo_servicio='.$cod_tipo_des.'&servicio='.$tipo_des.'&ci_paciente='.$ci_paciente.'&enfermedad='.$enfermedad.'&tipo_lis=3';
                                             ?>                                                                                              
                                                
                                                <tr>      
                                                    
                                                    <td class="nombre_proveedor"><input class="botonadd" type="button" onclick="location.href='<?php echo url_for($url) ?>'" /><?php echo $enfermedad; ?></td>
                                                    <td class="nombre_proveedor"><?php echo $ci_paciente; ?></td>
                                                    <td class="nombre_proveedor"><?php echo $paciente; ?></td>
                                                    <td class="nombre_proveedor"><?php echo $tipo_des; ?></td>
                                                    <td class="nombre_proveedor"><?php echo $parentesco;?></td>
                                                    <td class="nombre_proveedor"><?php echo $fecocurr;?></td>
                                                    <td class="alignRight"><?php echo number_format($monto, 2, ",", "."); ?></td>
                                                   
                                                    
                                                </tr>
                                                 <?php endforeach; }
                                                
                                                else{
                                            ?>
                                                
                                                <tr>      
                                                    
                                                    <td class="nombre_proveedor" >No exiten casos registrados</td>
                                                    <td class="nombre_proveedor" > -- </td>
                                                    <td class="nombre_proveedor" > -- </td>
                                                    <td class="nombre_proveedor" > -- </td>
                                                    <td class="nombre_proveedor" > -- </td>
                                                    <td class="nombre_proveedor" > -- </td>
                                                    <td class="alignRight">0</td>
                                                    
                                                </tr>
                                                <?php } ?>
                                      
                                            </tbody>
                    
                  </table> 
 
              

            
                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />

   
                   <table class="sectorBottomMenu">
    <tr>
        <!--<td><a href="#" id="url_excel">Excel</a></td>
        <td><a href="#" id="url_pdf">PDF</a></td>--> 
        <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                
    </tr>                        
</table>
                                            

          
<script type="text/javascript">$("#cargando").css("display", "none");</script>

  

<script type="text/javascript">
$("#url_imprime").click(function (){
$("html").printArea();
})
</script>

