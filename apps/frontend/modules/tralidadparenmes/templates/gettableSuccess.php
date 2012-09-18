<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php  
//error_reporting(0);
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
 $total_conyugue_ene=0;         
         $total_hijos_ene=0;
         $total_hermanos_ene=0;
         $total_padres_ene=0;
         $cantidad_conyugue_ene=0;
         $cantidad_hijos_ene=0;
         $cantidad_hermanos_ene=0;
         $cantidad_padres_ene=0;
         
         $total_conyugue_feb=0;         
         $total_hijos_feb=0;
         $total_hermanos_feb=0;
         $total_padres_feb=0;
         $cantidad_conyugue_feb=0;
         $cantidad_hijos_feb=0;
         $cantidad_hermanos_feb=0;
         $cantidad_padres_feb=0;
         
         $total_conyugue_mar=0;         
         $total_hijos_mar=0;
         $total_hermanos_mar=0;
         $total_padres_mar=0;
         $cantidad_conyugue_mar=0;
         $cantidad_hijos_mar=0;
         $cantidad_hermanos_mar=0;
         $cantidad_padres_mar=0;
         
         $total_conyugue_abr=0;         
         $total_hijos_abr=0;
         $total_hermanos_abr=0;
         $total_padres_abr=0;
         $cantidad_conyugue_abr=0;
         $cantidad_hijos_abr=0;
         $cantidad_hermanos_abr=0;
         $cantidad_padres_abr=0;
         
         $total_conyugue_may=0;         
         $total_hijos_may=0;
         $total_hermanos_may=0;
         $total_padres_may=0;
         $cantidad_conyugue_may=0;
         $cantidad_hijos_may=0;
         $cantidad_hermanos_may=0;
         $cantidad_padres_may=0;
         
         $total_conyugue_jun=0;         
         $total_hijos_jun=0;
         $total_hermanos_jun=0;
         $total_padres_jun=0;
         $cantidad_conyugue_jun=0;
         $cantidad_hijos_jun=0;
         $cantidad_hermanos_jun=0;
         $cantidad_padres_jun=0;        
         
         $total_conyugue_jul=0;         
         $total_hijos_jul=0;
         $total_hermanos_jul=0;
         $total_padres_jul=0;
         $cantidad_conyugue_jul=0;
         $cantidad_hijos_jul=0;
         $cantidad_hermanos_jul=0;
         $cantidad_padres_jul=0;
         
         $total_conyugue_ago=0;         
         $total_hijos_ago=0;
         $total_hermanos_ago=0;
         $total_padres_ago=0;
         $cantidad_conyugue_ago=0;
         $cantidad_hijos_ago=0;
         $cantidad_hermanos_ago=0;
         $cantidad_padres_ago=0;
         
         $total_conyugue_sep=0;         
         $total_hijos_sep=0;
         $total_hermanos_sep=0;
         $total_padres_sep=0;
         $cantidad_conyugue_sep=0;
         $cantidad_hijos_sep=0;
         $cantidad_hermanos_sep=0;
         $cantidad_padres_sep=0;
         
         
         $total_conyugue_oct=0;         
         $total_hijos_oct=0;
         $total_hermanos_oct=0;
         $total_padres_oct=0;
         $cantidad_conyugue_oct=0;
         $cantidad_hijos_oct=0;
         $cantidad_hermanos_oct=0;
         $cantidad_padres_oct=0;
         
         $total_conyugue_nov=0;         
         $total_hijos_nov=0;
         $total_hermanos_nov=0;
         $total_padres_nov=0;
         $cantidad_conyugue_nov=0;
         $cantidad_hijos_nov=0;
         $cantidad_hermanos_nov=0;
         $cantidad_padres_nov=0;
         
         $total_conyugue_dic=0;         
         $total_hijos_dic=0;
         $total_hermanos_dic=0;
         $total_padres_dic=0;
         $cantidad_conyugue_dic=0;
         $cantidad_hijos_dic=0;
         $cantidad_hermanos_dic=0;
         $cantidad_padres_dic=0;
         
         $total_general_conjugue=0;
         $total_general_hijos=0;
         $total_general_hermanos=0;
         $total_general_padres=0;

   //$CantidadDiasHabiles = Evalua(DiasHabiles($fecha_inicial,$fecha_final)); 
   //echo "Cuantos tabla inicial: ".$cuantos_tabla_inicial;
 if($cuantos_tabla_inicial!=0){  
       foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla): 


             $parentesco=$row_tabla['PARENTESCO_CROSS'];
              $cantidad=$row_tabla['CANTIDAD'];
              $monto_incurrido=str_replace(",", ".",$row_tabla['TOTAL']);
              $mes=$row_tabla['MES'];
              
              
            
         
       if($mes=='01'){
             if(trim($parentesco)=='Esposo(a)' or trim($parentesco)=='Concubino(a)'){
                 $total_conyugue_ene=$total_conyugue_ene + $monto_incurrido;
                 $cantidad_conyugue_ene=$cantidad_conyugue_ene + $cantidad;
             }
             elseif(trim($parentesco)=='Hijo(a)'){
                 $total_hijos_ene=$total_hijos_ene + $monto_incurrido;
                 $cantidad_hijos_ene=$cantidad_hijos_ene + $cantidad;
             }
             
            elseif(trim($parentesco)=='Hermano(a)'){
                 $total_hermanos_ene=$total_hermanos_ene + $monto_incurrido;
                 $cantidad_hermanos_ene=$cantidad_hermanos_ene + $cantidad;
             }
             
             elseif(trim($parentesco)=='Progenitor(a)'){
                 $total_padres_ene=$total_padres_ene + $monto_incurrido;
                 $cantidad_padres_ene=$cantidad_padres_ene + $cantidad;
             }
             
             //elseif(trim($parentesco)!='' and trim($parentesco)!='Titular'){
             elseif(trim($parentesco)!='' and 
                     trim($parentesco)!='Esposo(a)' and
                     trim($parentesco)!='Concubino(a)' and
                     trim($parentesco)!='Hijo(a)' and
                     trim($parentesco)!='Hermano(a)' and
                     trim($parentesco)!='Progenitor(a)'                      
                     ){
                  $total_otros_ene=$total_otros_ene + $monto_incurrido;
                 $cantidad_otros_ene=$cantidad_otros_ene + $cantidad;
             }
             $total_ene=$total_conyugue_ene + $total_hijos_ene + $total_hermanos_ene + $total_padres_ene + $total_otros_ene ;           
             $cantidad_ene=$cantidad_conyugue_ene + $cantidad_hijos_ene + $cantidad_hermanos_ene + $cantidad_padres_ene + $cantidad_otros_ene;
            
          }
          
          
        if($mes=='02'){
             if(trim($parentesco)=='Esposo(a)' or trim($parentesco)=='Concubino(a)'){
                 $total_conyugue_feb=$total_conyugue_feb + $monto_incurrido;
                 $cantidad_conyugue_feb=$cantidad_conyugue_feb + $cantidad;
             }
             elseif(trim($parentesco)=='Hijo(a)'){
                 $total_hijos_feb=$total_hijos_feb + $monto_incurrido;
                 $cantidad_hijos_feb=$cantidad_hijos_feb + $cantidad;
             }
             
            elseif(trim($parentesco)=='Hermano(a)'){
                 $total_hermanos_feb=$total_hermanos_feb + $monto_incurrido;
                 $cantidad_hermanos_feb=$cantidad_hermanos_feb + $cantidad;
             }
             
             elseif(trim($parentesco)=='Progenitor(a)'){
                 $total_padres_feb=$total_padres_feb + $monto_incurrido;
                 $cantidad_padres_feb=$cantidad_padres_feb + $cantidad;
             }
             
             elseif(trim($parentesco)!='' and 
                     trim($parentesco)!='Esposo(a)' and
                     trim($parentesco)!='Concubino(a)' and
                     trim($parentesco)!='Hijo(a)' and
                     trim($parentesco)!='Hermano(a)' and
                     trim($parentesco)!='Progenitor(a)'                      
                     ){
                  $total_otros_feb=$total_otros_feb + $monto_incurrido;
                 $cantidad_otros_feb=$cantidad_otros_feb + $cantidad;
             }
             $total_feb=$total_conyugue_feb + $total_hijos_feb + $total_hermanos_feb + $total_padres_feb + $total_otros_feb ;           
             $cantidad_feb=$cantidad_conyugue_feb + $cantidad_hijos_feb + $cantidad_hermanos_feb + $cantidad_padres_feb + $cantidad_otros_feb;
          }  
          
          if($mes=='03'){
             if(trim($parentesco)=='Esposo(a)' or trim($parentesco)=='Concubino(a)'){
                 $total_conyugue_mar=$total_conyugue_mar + $monto_incurrido;
                 $cantidad_conyugue_mar=$cantidad_conyugue_mar + $cantidad;
             }
             elseif(trim($parentesco)=='Hijo(a)'){
                 $total_hijos_mar=$total_hijos_mar + $monto_incurrido;
                 $cantidad_hijos_mar=$cantidad_hijos_mar + $cantidad;
             }
             
            elseif(trim($parentesco)=='Hermano(a)'){
                 $total_hermanos_mar=$total_hermanos_mar + $monto_incurrido;
                 $cantidad_hermanos_mar=$cantidad_hermanos_mar + $cantidad;
             }
             
             elseif(trim($parentesco)=='Progenitor(a)'){
                 $total_padres_mar=$total_padres_mar + $monto_incurrido;
                 $cantidad_padres_mar=$cantidad_padres_mar + $cantidad;
             }
             
             elseif(trim($parentesco)!='' and 
                     trim($parentesco)!='Esposo(a)' and
                     trim($parentesco)!='Concubino(a)' and
                     trim($parentesco)!='Hijo(a)' and
                     trim($parentesco)!='Hermano(a)' and
                     trim($parentesco)!='Progenitor(a)'                      
                     ){
                  $total_otros_mar=$total_otros_mar + $monto_incurrido;
                 $cantidad_otros_mar=$cantidad_otros_mar + $cantidad;
             }
             $total_mar=$total_conyugue_mar + $total_hijos_mar + $total_hermanos_mar + $total_padres_mar + $total_otros_mar ;           
             $cantidad_mar=$cantidad_conyugue_mar + $cantidad_hijos_mar + $cantidad_hermanos_mar + $cantidad_padres_mar + $cantidad_otros_mar;
          }  
          
           if($mes=='04'){
              if(trim($parentesco)=='Esposo(a)' or trim($parentesco)=='Concubino(a)'){
                 $total_conyugue_abr=$total_conyugue_abr + $monto_incurrido;
                 $cantidad_conyugue_abr=$cantidad_conyugue_abr + $cantidad;
             }
             elseif(trim($parentesco)=='Hijo(a)'){
                 $total_hijos_abr=$total_hijos_abr + $monto_incurrido;
                 $cantidad_hijos_abr=$cantidad_hijos_abr + $cantidad;
             }
             
            elseif(trim($parentesco)=='Hermano(a)'){
                 $total_hermanos_abr=$total_hermanos_abr + $monto_incurrido;
                 $cantidad_hermanos_abr=$cantidad_hermanos_abr + $cantidad;
             }
             
             elseif(trim($parentesco)=='Progenitor(a)'){
                 $total_padres_abr=$total_padres_abr + $monto_incurrido;
                 $cantidad_padres_abr=$cantidad_padres_abr + $cantidad;
             }
             
             elseif(trim($parentesco)!='' and 
                     trim($parentesco)!='Esposo(a)' and
                     trim($parentesco)!='Concubino(a)' and
                     trim($parentesco)!='Hijo(a)' and
                     trim($parentesco)!='Hermano(a)' and
                     trim($parentesco)!='Progenitor(a)'                      
                     ){
                  $total_otros_abr=$total_otros_abr + $monto_incurrido;
                 $cantidad_otros_abr=$cantidad_otros_abr + $cantidad;
             }
             $total_abr=$total_conyugue_abr + $total_hijos_abr + $total_hermanos_abr + $total_padres_abr + $total_otros_abr ;           
             $cantidad_abr=$cantidad_conyugue_abr + $cantidad_hijos_abr + $cantidad_hermanos_abr + $cantidad_padres_abr + $cantidad_otros_abr;
          }  
          
           if($mes=='05'){
              if(trim($parentesco)=='Esposo(a)' or trim($parentesco)=='Concubino(a)'){
                 $total_conyugue_may=$total_conyugue_may + $monto_incurrido;
                 $cantidad_conyugue_may=$cantidad_conyugue_may + $cantidad;
             }
             elseif(trim($parentesco)=='Hijo(a)'){
                 $total_hijos_may=$total_hijos_may + $monto_incurrido;
                 $cantidad_hijos_may=$cantidad_hijos_may + $cantidad;
             }
             
            elseif(trim($parentesco)=='Hermano(a)'){
                 $total_hermanos_may=$total_hermanos_may + $monto_incurrido;
                 $cantidad_hermanos_may=$cantidad_hermanos_may + $cantidad;
             }
             
             elseif(trim($parentesco)=='Progenitor(a)'){
                 $total_padres_may=$total_padres_may + $monto_incurrido;
                 $cantidad_padres_may=$cantidad_padres_may + $cantidad;
             }
             
             elseif(trim($parentesco)!='' and 
                     trim($parentesco)!='Esposo(a)' and
                     trim($parentesco)!='Concubino(a)' and
                     trim($parentesco)!='Hijo(a)' and
                     trim($parentesco)!='Hermano(a)' and
                     trim($parentesco)!='Progenitor(a)'                      
                     ){
                  $total_otros_may=$total_otros_may + $monto_incurrido;
                 $cantidad_otros_may=$cantidad_otros_may + $cantidad;
             }
             $total_may=$total_conyugue_may + $total_hijos_may + $total_hermanos_may + $total_padres_may + $total_otros_may ;           
             $cantidad_may=$cantidad_conyugue_may + $cantidad_hijos_may + $cantidad_hermanos_may + $cantidad_padres_may + $cantidad_otros_may;
          }  
          
           if($mes=='06'){
               if(trim($parentesco)=='Esposo(a)' or trim($parentesco)=='Concubino(a)'){
                 $total_conyugue_jun=$total_conyugue_jun + $monto_incurrido;
                 $cantidad_conyugue_jun=$cantidad_conyugue_jun + $cantidad;
             }
             elseif(trim($parentesco)=='Hijo(a)'){
                 $total_hijos_jun=$total_hijos_jun + $monto_incurrido;
                 $cantidad_hijos_jun=$cantidad_hijos_jun + $cantidad;
             }
             
            elseif(trim($parentesco)=='Hermano(a)'){
                 $total_hermanos_jun=$total_hermanos_jun + $monto_incurrido;
                 $cantidad_hermanos_jun=$cantidad_hermanos_jun + $cantidad;
             }
             
             elseif(trim($parentesco)=='Progenitor(a)'){
                 $total_padres_jun=$total_padres_jun + $monto_incurrido;
                 $cantidad_padres_jun=$cantidad_padres_jun + $cantidad;
             }
             
             elseif(trim($parentesco)!='' and 
                     trim($parentesco)!='Esposo(a)' and
                     trim($parentesco)!='Concubino(a)' and
                     trim($parentesco)!='Hijo(a)' and
                     trim($parentesco)!='Hermano(a)' and
                     trim($parentesco)!='Progenitor(a)'                      
                     ){
                  $total_otros_jun=$total_otros_jun + $monto_incurrido;
                 $cantidad_otros_jun=$cantidad_otros_jun + $cantidad;
             }
             $total_jun=$total_conyugue_jun + $total_hijos_jun + $total_hermanos_jun + $total_padres_jun + $total_otros_jun ;           
             $cantidad_jun=$cantidad_conyugue_jun + $cantidad_hijos_jun + $cantidad_hermanos_jun + $cantidad_padres_jun + $cantidad_otros_jun;
            
          }  
          
           if($mes=='07'){
              if(trim($parentesco)=='Esposo(a)' or trim($parentesco)=='Concubino(a)'){
                 $total_conyugue_jul=$total_conyugue_jul + $monto_incurrido;
                 $cantidad_conyugue_jul=$cantidad_conyugue_jul + $cantidad;
             }
             elseif(trim($parentesco)=='Hijo(a)'){
                 $total_hijos_jul=$total_hijos_jul + $monto_incurrido;
                 $cantidad_hijos_jul=$cantidad_hijos_jul + $cantidad;
             }
             
            elseif(trim($parentesco)=='Hermano(a)'){
                 $total_hermanos_jul=$total_hermanos_jul + $monto_incurrido;
                 $cantidad_hermanos_jul=$cantidad_hermanos_jul + $cantidad;
             }
             
             elseif(trim($parentesco)=='Progenitor(a)'){
                 $total_padres_jul=$total_padres_jul + $monto_incurrido;
                 $cantidad_padres_jul=$cantidad_padres_jul + $cantidad;
             }
             
             elseif(trim($parentesco)!='' and 
                     trim($parentesco)!='Esposo(a)' and
                     trim($parentesco)!='Concubino(a)' and
                     trim($parentesco)!='Hijo(a)' and
                     trim($parentesco)!='Hermano(a)' and
                     trim($parentesco)!='Progenitor(a)'                      
                     ){
                  $total_otros_jul=$total_otros_jul + $monto_incurrido;
                 $cantidad_otros_jul=$cantidad_otros_jul + $cantidad;
             }
             $total_jul=$total_conyugue_jul + $total_hijos_jul + $total_hermanos_jul + $total_padres_jul + $total_otros_jul ;           
             $cantidad_jul=$cantidad_conyugue_jul + $cantidad_hijos_jul + $cantidad_hermanos_jul + $cantidad_padres_jul + $cantidad_otros_jul;
            
          }  
          
           if($mes=='08'){
              if(trim($parentesco)=='Esposo(a)' or trim($parentesco)=='Concubino(a)'){
                 $total_conyugue_ago=$total_conyugue_ago + $monto_incurrido;
                 $cantidad_conyugue_ago=$cantidad_conyugue_ago + $cantidad;
             }
             elseif(trim($parentesco)=='Hijo(a)'){
                 $total_hijos_ago=$total_hijos_ago + $monto_incurrido;
                 $cantidad_hijos_ago=$cantidad_hijos_ago + $cantidad;
             }
             
            elseif(trim($parentesco)=='Hermano(a)'){
                 $total_hermanos_ago=$total_hermanos_ago + $monto_incurrido;
                 $cantidad_hermanos_ago=$cantidad_hermanos_ago + $cantidad;
             }
             
             elseif(trim($parentesco)=='Progenitor(a)'){
                 $total_padres_ago=$total_padres_ago + $monto_incurrido;
                 $cantidad_padres_ago=$cantidad_padres_ago + $cantidad;
             }
             
             elseif(trim($parentesco)!='' and 
                     trim($parentesco)!='Esposo(a)' and
                     trim($parentesco)!='Concubino(a)' and
                     trim($parentesco)!='Hijo(a)' and
                     trim($parentesco)!='Hermano(a)' and
                     trim($parentesco)!='Progenitor(a)'                      
                     ){
                  $total_otros_ago=$total_otros_ago + $monto_incurrido;

                 $cantidad_otros_ago=$cantidad_otros_ago + $cantidad;
             }
             $total_ago=$total_conyugue_ago + $total_hijos_ago + $total_hermanos_ago + $total_padres_ago + $total_otros_ago ;           
             
             $cantidad_ago=$cantidad_conyugue_ago + $cantidad_hijos_ago + $cantidad_hermanos_ago + $cantidad_padres_ago + $cantidad_otros_ago;
         } 
          
           if($mes=='09'){
             if(trim($parentesco)=='Esposo(a)' or trim($parentesco)=='Concubino(a)'){
                 $total_conyugue_sep=$total_conyugue_sep + $monto_incurrido;
                 $cantidad_conyugue_sep=$cantidad_conyugue_sep + $cantidad;
             }
             elseif(trim($parentesco)=='Hijo(a)'){
                 $total_hijos_sep=$total_hijos_sep + $monto_incurrido;
                 $cantidad_hijos_sep=$cantidad_hijos_sep + $cantidad;
             }
             
            elseif(trim($parentesco)=='Hermano(a)'){
                 $total_hermanos_sep=$total_hermanos_sep + $monto_incurrido;
                 $cantidad_hermanos_sep=$cantidad_hermanos_sep + $cantidad;
             }
             
             elseif(trim($parentesco)=='Progenitor(a)'){
                 $total_padres_sep=$total_padres_sep + $monto_incurrido;
                 $cantidad_padres_sep=$cantidad_padres_sep + $cantidad;
             }
             
             elseif(trim($parentesco)!='' and 
                     trim($parentesco)!='Esposo(a)' and
                     trim($parentesco)!='Concubino(a)' and
                     trim($parentesco)!='Hijo(a)' and
                     trim($parentesco)!='Hermano(a)' and
                     trim($parentesco)!='Progenitor(a)'                      
                     ){
                  $total_otros_sep=$total_otros_sep + $monto_incurrido;
                 $cantidad_otros_sep=$cantidad_otros_sep + $cantidad;
             }
             $total_sep=$total_conyugue_sep + $total_hijos_sep + $total_hermanos_sep + $total_padres_sep + $total_otros_sep ;           
             $cantidad_sep=$cantidad_conyugue_sep + $cantidad_hijos_sep + $cantidad_hermanos_sep + $cantidad_padres_sep + $cantidad_otros_sep;
          } 
          if($mes=='10'){
             if(trim($parentesco)=='Esposo(a)' or trim($parentesco)=='Concubino(a)'){
                 $total_conyugue_oct=$total_conyugue_oct + $monto_incurrido;
                 $cantidad_conyugue_oct=$cantidad_conyugue_oct + $cantidad;
             }
             elseif(trim($parentesco)=='Hijo(a)'){
                 $total_hijos_oct=$total_hijos_oct + $monto_incurrido;
                 $cantidad_hijos_oct=$cantidad_hijos_oct + $cantidad;
             }
             
            elseif(trim($parentesco)=='Hermano(a)'){
                 $total_hermanos_oct=$total_hermanos_oct + $monto_incurrido;
                 $cantidad_hermanos_oct=$cantidad_hermanos_oct + $cantidad;
             }
             
             elseif(trim($parentesco)=='Progenitor(a)'){
                 $total_padres_oct=$total_padres_oct + $monto_incurrido;
                 $cantidad_padres_oct=$cantidad_padres_oct + $cantidad;
             }
             
             elseif(trim($parentesco)!='' and 
                     trim($parentesco)!='Esposo(a)' and
                     trim($parentesco)!='Concubino(a)' and
                     trim($parentesco)!='Hijo(a)' and
                     trim($parentesco)!='Hermano(a)' and
                     trim($parentesco)!='Progenitor(a)'                      
                     ){
                  $total_otros_oct=$total_otros_oct + $monto_incurrido;
                 $cantidad_otros_oct=$cantidad_otros_oct + $cantidad;
             }
             $total_oct=$total_conyugue_oct + $total_hijos_oct + $total_hermanos_oct + $total_padres_oct + $total_otros_oct ;           
             $cantidad_oct=$cantidad_conyugue_oct + $cantidad_hijos_oct + $cantidad_hermanos_oct + $cantidad_padres_oct + $cantidad_otros_oct;
          } 
           if($mes=='11'){
               if(trim($parentesco)=='Esposo(a)' or trim($parentesco)=='Concubino(a)'){
                 $total_conyugue_nov=$total_conyugue_nov + $monto_incurrido;
                 $cantidad_conyugue_nov=$cantidad_conyugue_nov + $cantidad;
             }
             elseif(trim($parentesco)=='Hijo(a)'){
                 $total_hijos_nov=$total_hijos_nov + $monto_incurrido;
                 $cantidad_hijos_nov=$cantidad_hijos_nov + $cantidad;
             }
             
            elseif(trim($parentesco)=='Hermano(a)'){
                 $total_hermanos_nov=$total_hermanos_nov + $monto_incurrido;
                 $cantidad_hermanos_nov=$cantidad_hermanos_nov + $cantidad;
             }
             
             elseif(trim($parentesco)=='Progenitor(a)'){
                 $total_padres_nov=$total_padres_nov + $monto_incurrido;
                 $cantidad_padres_nov=$cantidad_padres_nov + $cantidad;
             }
             
             elseif(trim($parentesco)!='' and 
                     trim($parentesco)!='Esposo(a)' and
                     trim($parentesco)!='Concubino(a)' and
                     trim($parentesco)!='Hijo(a)' and
                     trim($parentesco)!='Hermano(a)' and
                     trim($parentesco)!='Progenitor(a)'                      
                     ){
                  $total_otros_nov=$total_otros_nov + $monto_incurrido;
                 $cantidad_otros_nov=$cantidad_otros_nov + $cantidad;
             }
             $total_nov=$total_conyugue_nov + $total_hijos_nov + $total_hermanos_nov + $total_padres_nov + $total_otros_nov ;           
             $cantidad_nov=$cantidad_conyugue_nov + $cantidad_hijos_nov + $cantidad_hermanos_nov + $cantidad_padres_nov + $cantidad_otros_nov;
          }    
         
          
           if($mes=='12'){
             if(trim($parentesco)=='Esposo(a)' or trim($parentesco)=='Concubino(a)'){
                 $total_conyugue_dic=$total_conyugue_dic + $monto_incurrido;
                 $cantidad_conyugue_dic=$cantidad_conyugue_dic + $cantidad;
             }
             elseif(trim($parentesco)=='Hijo(a)'){
                 $total_hijos_dic=$total_hijos_dic + $monto_incurrido;
                 $cantidad_hijos_dic=$cantidad_hijos_dic + $cantidad;
             }
             
            elseif(trim($parentesco)=='Hermano(a)'){
                 $total_hermanos_dic=$total_hermanos_dic + $monto_incurrido;
                 $cantidad_hermanos_dic=$cantidad_hermanos_dic + $cantidad;
             }
             
             elseif(trim($parentesco)=='Progenitor(a)'){
                 $total_padres_dic=$total_padres_dic + $monto_incurrido;
                 $cantidad_padres_dic=$cantidad_padres_dic + $cantidad;
             }
             
             elseif(trim($parentesco)!='' and 
                     trim($parentesco)!='Esposo(a)' and
                     trim($parentesco)!='Concubino(a)' and
                     trim($parentesco)!='Hijo(a)' and
                     trim($parentesco)!='Hermano(a)' and
                     trim($parentesco)!='Progenitor(a)'                      
                     ){
                  $total_otros_dic=$total_otros_dic + $monto_incurrido;
                 $cantidad_otros_dic=$cantidad_otros_dic + $cantidad;
             }
             $total_dic=$total_conyugue_dic + $total_hijos_dic + $total_hermanos_dic + $total_padres_dic + $total_otros_dic ;           
             $cantidad_dic=$cantidad_conyugue_dic + $cantidad_hijos_dic + $cantidad_hermanos_dic + $cantidad_padres_dic + $cantidad_otros_dic;
          }  

       endforeach; 
  
 }  
 $total_general= $total_ene+ $total_feb + $total_mar+$total_abr+$total_may+$total_jun+$total_jul+$total_ago+$total_sep+$total_oct+$total_nov+ $total_dic;
 $total_general_conyugue= $total_conyugue_ene+ $total_conyugue_feb + $total_conyugue_mar+$total_conyugue_abr+$total_conyugue_may+$total_conyugue_jun+$total_conyugue_jul+$total_conyugue_ago+$total_conyugue_sep+$total_conyugue_oct+$total_conyugue_nov+ $total_conyugue_dic;
 $total_general_hijos= $total_hijos_ene+ $total_hijos_feb + $total_hijos_mar+$total_hijos_abr+$total_hijos_may+$total_hijos_jun+$total_hijos_jul+$total_hijos_ago+$total_hijos_sep+$total_hijos_oct+$total_hijos_nov+ $total_hijos_dic;
 $total_general_hermanos= $total_hermanos_ene+ $total_hermanos_feb + $total_hermanos_mar+$total_hermanos_abr+$total_hermanos_may+$total_hermanos_jun+$total_hermanos_jul+$total_hermanos_ago+$total_hermanos_sep+$total_hermanos_oct+$total_hermanos_nov+ $total_hermanos_dic;
 $total_general_padres= $total_padres_ene+ $total_padres_feb + $total_padres_mar+$total_padres_abr+$total_padres_may+$total_padres_jun+$total_padres_jul+$total_padres_ago+$total_padres_sep+$total_padres_oct+$total_padres_nov+ $total_padres_dic;
 $total_general_otros= $total_otros_ene+ $total_otros_feb + $total_otros_mar+$total_otros_abr+$total_otros_may+$total_otros_jun+$total_otros_jul+$total_otros_ago+$total_otros_sep+$total_otros_oct+$total_otros_nov+ $total_otros_dic;
 $cantidad_general_conyugue= $cantidad_conyugue_ene+ $cantidad_conyugue_feb + $cantidad_conyugue_mar+$cantidad_conyugue_abr+$cantidad_conyugue_may+$cantidad_conyugue_jun+$cantidad_conyugue_jul+$cantidad_conyugue_ago+$cantidad_conyugue_sep+$cantidad_conyugue_oct+$cantidad_conyugue_nov+ $cantidad_conyugue_dic;
 $cantidad_general_hijos= $cantidad_hijos_ene+ $cantidad_hijos_feb + $cantidad_hijos_mar+$cantidad_hijos_abr+$cantidad_hijos_may+$cantidad_hijos_jun+$cantidad_hijos_jul+$cantidad_hijos_ago+$cantidad_hijos_sep+$cantidad_hijos_oct+$cantidad_hijos_nov+ $cantidad_hijos_dic;
 $cantidad_general_padres= $cantidad_padres_ene+ $cantidad_padres_feb + $cantidad_padres_mar+$cantidad_padres_abr+$cantidad_padres_may+$cantidad_padres_jun+$cantidad_padres_jul+$cantidad_padres_ago+$cantidad_padres_sep+$cantidad_padres_oct+$cantidad_padres_nov+ $cantidad_padres_dic;
 $cantidad_general_hermanos= $cantidad_hermanos_ene+ $cantidad_hermanos_feb + $cantidad_hermanos_mar+$cantidad_hermanos_abr+$cantidad_hermanos_may+$cantidad_hermanos_jun+$cantidad_hermanos_jul+$cantidad_hermanos_ago+$cantidad_hermanos_sep+$cantidad_hermanos_oct+$cantidad_hermanos_nov+ $cantidad_hermanos_dic;
 $cantidad_general_otros= $cantidad_otros_ene+ $cantidad_otros_feb + $cantidad_otros_mar+$cantidad_otros_abr+$cantidad_otros_may+$cantidad_otros_jun+$cantidad_otros_jul+$cantidad_otros_ago+$cantidad_otros_sep+$cantidad_otros_oct+$cantidad_otros_nov+ $cantidad_otros_dic;
 $cantidad_general= $cantidad_ene+ $cantidad_feb + $cantidad_mar+$cantidad_abr+$cantidad_may+$cantidad_jun+$cantidad_jul+$cantidad_ago+$cantidad_sep+$cantidad_oct+$cantidad_nov+ $cantidad_dic;
    ?> 
    <?php if($cuantos_tabla_inicial!=0){?>
<hr style="background-color:#E8E8E8; height:2px; border:0;" />
<!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
ob_start();
?>
<!-- FIN-->

<table class="tableSector" >
           
 <thead>
        <tr>
            <th>&nbsp;</th>
            <th align="center" colspan="2"> Conyugue</th>
            <th align="center" colspan="2">Hijos</th>
            <th align="center" colspan="2">Padres</th>
            <th align="center" colspan="2">Hermanos</th>
             <th align="center" colspan="2"> Otros</th>
            <th align="center" colspan="2"> Total</th>
        </tr>
        <tr>
            <th class="nombre_proveedor"> Mes</th>
            <th class="nombre_proveedor">Incurrido</th>
            <th class="nombre_proveedor">N&ordm; Casos </th>
            <th class="nombre_proveedor">Incurrido</th>
            <th class="nombre_proveedor">N&ordm; Casos</th>
            <th class="nombre_proveedor">Incurrdo</th>
            <th class="nombre_proveedor">N&ordm; Casos</th>
            <th class="nombre_proveedor">Incurrido</th>
            <th class="nombre_proveedor">N&ordm; Casos </th>
              <th class="nombre_proveedor">Incurrido</th>
            <th class="nombre_proveedor">N&ordm; Casos </th>
            <th class="nombre_proveedor">Incurrido</th>
           <th class="nombre_proveedor">Nº Casos</th>
        </tr>
        </thead>
           <tbody>
        <?php if($total_ene>0){?>       
        <tr>
            <td class="nombre_proveedor"> Enero</td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_conyugue_ene),2,",","."); ?></td>   
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_conyugue_ene),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hijos_ene),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hijos_ene),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_padres_ene),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_padres_ene),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hermanos_ene),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hermanos_ene),2,",",".");?></td>
            <td class="alignRight"><?php             
            $montoMostrar = 0;
            $montoMostrar = $total_otros_ene;
                if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };
              ?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $cantidad_otros_ene;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_ene),2,",",".");?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_ene),2,",",".");?> </td>
           
        </tr>
        <?php } ?>
        <?php if($total_feb>0){?> 
        <tr>
            <td class="nombre_proveedor"> Febrero</td>
           <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_conyugue_feb),2,",","."); ?></td>   
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_conyugue_feb),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hijos_feb),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hijos_feb),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_padres_feb),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_padres_feb),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hermanos_feb),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hermanos_feb),2,",",".");?></td>
            <td class="alignRight"><?php             
            $montoMostrar = 0;
            $montoMostrar = $total_otros_feb;
                if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };
              ?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $cantidad_otros_feb;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_feb),2,",",".");?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_feb),2,",",".");?> </td>
           
        </tr>
        <?php }
        if($total_mar>0){?> 
        <tr>
            <td class="nombre_proveedor"> Marzo</td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_conyugue_mar),2,",","."); ?></td>   
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_conyugue_mar),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hijos_mar),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hijos_mar),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_padres_mar),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_padres_mar),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hermanos_mar),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hermanos_mar),2,",",".");?></td>
            <td class="alignRight"><?php             
            $montoMostrar = 0;
            $montoMostrar = $total_otros_mar;
                if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };
              ?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $cantidad_otros_mar;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_mar),2,",",".");?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_mar),2,",",".");?> </td>
           
        </tr>
        <?php } if($total_abr>0){?> 
        <tr>
            <td class="nombre_proveedor"> Abril</td>
           <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_conyugue_abr),2,",","."); ?></td>   
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_conyugue_abr),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hijos_abr),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hijos_abr),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_padres_abr),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_padres_abr),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hermanos_abr),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hermanos_abr),2,",",".");?></td>
            <td class="alignRight"><?php             
            $montoMostrar = 0;
            $montoMostrar = $total_otros_abr;
                if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };
              ?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $cantidad_otros_abr;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_abr),2,",",".");?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_abr),2,",",".");?> </td>
           
        </tr>
        <?php } if($total_may>0){?> 
        <tr>
            <td class="nombre_proveedor">Mayo</td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_conyugue_may),2,",","."); ?></td>   
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_conyugue_may),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hijos_may),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hijos_may),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_padres_may),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_padres_may),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hermanos_may),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hermanos_may),2,",",".");?></td>
            <td class="alignRight"><?php             
            $montoMostrar = 0;
            $montoMostrar = $total_otros_may;
                if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };
              ?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $cantidad_otros_may;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_may),2,",",".");?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_may),2,",",".");?> </td>
            
        </tr>
        <?php } if($total_jun>0){?> 
        <tr>
            <td class="nombre_proveedor">Junio</td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_conyugue_jun),2,",","."); ?></td>   
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_conyugue_jun),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hijos_jun),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hijos_jun),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_padres_jun),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_padres_jun),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hermanos_jun),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hermanos_jun),2,",",".");?></td>
            <td class="alignRight"><?php             
            $montoMostrar = 0;
            $montoMostrar = $total_otros_jun;
                if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };
              ?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $cantidad_otros_jun;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_jun),2,",",".");?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_jun),2,",",".");?> </td>
            
        </tr>
        <?php } if($total_jul>0){?> 
        <tr>
            <td class="nombre_proveedor">Julio</td>
           <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_conyugue_jul),2,",","."); ?></td>   
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_conyugue_jul),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hijos_jul),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hijos_jul),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_padres_jul),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_padres_jul),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hermanos_jul),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hermanos_jul),2,",",".");?></td>
            <td class="alignRight"><?php             
            $montoMostrar = 0;
            $montoMostrar = $total_otros_jul;
                if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };
              ?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $cantidad_otros_jul;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_jul),2,",",".");?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_jul),2,",",".");?> </td>
           
        </tr>
        <?php } if($total_ago>0){?> 
        <tr>
            <td class="nombre_proveedor">Agosto</td>
           <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_conyugue_ago),2,",","."); ?></td>   
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_conyugue_ago),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hijos_ago),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hijos_ago),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_padres_ago),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_padres_ago),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hermanos_ago),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hermanos_ago),2,",",".");?></td>
            <td class="alignRight"><?php             
            $montoMostrar = 0;
            $montoMostrar = $total_otros_ago;
                if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };
              ?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $total_otros_ago;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_ago),2,",",".");?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_ago),2,",",".");?> </td>
           
        </tr>
        <?php } if($total_sep>0){?> 
        <tr>
            <td class="nombre_proveedor"> Septiembre</td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_conyugue_sep),2,",","."); ?></td>   
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_conyugue_sep),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hijos_sep),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hijos_sep),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_padres_sep),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_padres_sep),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hermanos_sep),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hermanos_sep),2,",",".");?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $total_otros_sep;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $cantidad_otros_sep;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            
            
            
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_sep),2,",",".");?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_sep),2,",",".");?> </td>
            
        </tr>
        <?php } if($total_oct>0){?> 
        <tr>
            <td class="nombre_proveedor">Octubre</td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_conyugue_oct),2,",","."); ?></td>   
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_conyugue_oct),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hijos_oct),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hijos_oct),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_padres_oct),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_padres_oct),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hermanos_oct),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hermanos_oct),2,",",".");?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $total_otros_oct;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $cantidad_otros_oct;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_oct),2,",",".");?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_oct),2,",",".");?> </td>
            
        </tr>
        <?php } if($total_nov>0){?> 
        <tr>
            <td class="nombre_proveedor"> Noviembre</td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_conyugue_nov),2,",","."); ?></td>   
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_conyugue_nov),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hijos_nov),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hijos_nov),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_padres_nov),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_padres_nov),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hermanos_nov),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hermanos_nov),2,",",".");?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $total_otros_nov;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $cantidad_otros_nov;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_nov),2,",",".");?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_nov),2,",",".");?> </td>
            
        </tr>
        <?php } if($total_dic>0){?> 
        <tr>
            <td class="nombre_proveedor"> Diciembre</td>
           <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_conyugue_dic),2,",","."); ?></td>   
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_conyugue_dic),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hijos_dic),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hijos_dic),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_padres_dic),2,",","."); ?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_padres_dic),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_hermanos_dic),2,",","."); ?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_hermanos_dic),2,",",".");?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $total_otros_dic;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $cantidad_otros_dic;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_dic),2,",",".");?> </td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_dic),2,",",".");?> </td>
           
        </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        <tr>
            <td class="nombre_proveedor">TOTAL</td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_general_conyugue),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_general_conyugue),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_general_hijos),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_general_hijos),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_general_padres),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_general_padres),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_general_hermanos),2,",",".");?></td>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_general_hermanos),2,",",".");?></td>
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $total_general_otros;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?></td>
            
            <td class="alignRight"><?php 
            $montoMostrar = 0;
            $montoMostrar = $cantidad_general_otros;
            if (!$montoMostrar){
                    echo  '0,00';
                }  else{
                    echo number_format(str_replace(",", ".",$montoMostrar),2,",",".");
                };            
            ?>
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$total_general),2,",",".");?></td> 
            <td class="alignRight"><?php echo number_format(str_replace(",", ".",$cantidad_general),2,",",".");?>&nbsp;</td>  
        </tr>
     </tfoot>
</table>

<!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
echo $var=ob_get_clean();
?>
<!--FIN-->      

<!-- Formulario oculto para crear pdf-->
<form method="post" id="targetpdf" action="<?php echo url_for('pdf/index') ?>" target="_blank" hidden="hidden">
<input id="titulo_pdf"  name="titulo_pdf" type="text" value="Parentesco y mes" />
    <textarea id="text_pdf" name="text" rows="2" cols="20"  >
        <?php echo $var; ?>
    </textarea>
</form>
<!-- fin-->     
<!-- Formulario oculto para crear excel-->
<form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
<input id="titulo"  name="titulo" type="text" value="Parentesco y mes" />
    <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
</form>
<!-- fin-->
                  
                    <?php }?>

</div>              

            
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

