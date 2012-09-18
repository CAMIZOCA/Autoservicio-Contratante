<?php error_reporting(E_ALL & ~E_NOTICE); 

$cliente=$_GET["cliente"]; 
$contratante=$_GET["contratante"];
$tipo_servicio=$_GET["tipo_ser"];
$ano=$_GET["anno"];
$mes=$_GET["mes"];
   
  $Enlace1 = oci_connect('AUTO_CONTRA', 'AUTO_CONTRA', '172.20.0.26/autoserv'); //Produccion
//$Enlace1 = oci_connect('AUTO_CONTR_DES', 'AUTO_CONTR_DES', '172.20.0.18/autoservicio');	
	if ( !$Enlace1 ){ 
		echo "<br />No es posible conectar: " . var_dump( OCIError() ); 
		die();
			return false;
	}	



if($mes==0){

           $q_mes =" SELECT * FROM (  
               SELECT to_char(FECOCURR,'dd-mm-yyyy') as fecha_ini
                  FROM SINIESTRALIDAD_VW  J WHERE 1=1 ";           
           if(trim($cliente)!=''){
            $q_mes.=" AND IDEPOL ='$cliente' ";   
           }
           if(trim($contratante)!='' and trim($contratante)!='todos'){
            $q_mes.=" AND CODEXTERNO ='$contratante' ";   
           }
           if(trim($tipo_servicio)!='' and trim($tipo_servicio)!='todos'){
            $q_mes.=" AND COD_TIPO_DES ='$tipo_servicio' ";   
           }
           
           if(trim($ano)!='' and trim($ano)!='-1'){
            $q_mes.=" and to_char(fecocurr,'yyyy') ='$ano' ";   
           }
           
           $q_mes.=" order by FECOCURR asc";
           $q_mes.=" ) WHERE ROWNUM = 1";
           
           //echo $q_mes;
           // Create connection to Oracle
         
	
	$resultfecha = oci_parse($Enlace1,$q_mes);
oci_execute($resultfecha);


$row = oci_fetch_array($resultfecha, OCI_ASSOC+OCI_RETURN_NULLS);
     foreach ($row as $item) {
    
      $fecha_inicio_cal=  $item;
     }
    
  if($ano!=date("Y")){
     $fecha_fin_cal="31-12-".$ano;
  }
  else{
     $fecha_fin_cal=date("d-m-Y"); 
  }
     //$aux_fec=explode("-",$fecha_inicio_cal);
     
    //echo "2ano actual".date("Y");
    
   
    $CantidadDiasHabiles = Evalua(DiasHabiles($fecha_inicio_cal,$fecha_fin_cal))+1; 
    $CantidadDiasNormales=dias_mes($fecha_inicio_cal,$fecha_fin_cal)+1;
    
    echo $fecha_inicio_cal."/". $fecha_fin_cal."/".$CantidadDiasHabiles."/".$CantidadDiasNormales;
}
else{
     $q_mes =" SELECT * FROM (  
               SELECT to_char(FECOCURR,'dd-mm-yyyy') as fecha_ini
                  FROM SINIESTRALIDAD_VW  J WHERE 1=1 ";           
           if(trim($cliente)!=''){
            $q_mes.=" AND IDEPOL ='$cliente' ";   
           }
           if(trim($contratante)!='' and trim($contratante)!='todos'){
            $q_mes.=" AND CODEXTERNO ='$contratante' ";   
           }
           if(trim($tipo_servicio)!='' and trim($tipo_servicio)!='todos'){
            $q_mes.=" AND COD_TIPO_DES ='$tipo_servicio' ";   
           }
           
           if(trim($ano)!='' and trim($ano)!='-1'){
            $q_mes.=" and to_char(fecocurr,'yyyy') ='$ano' ";   
           }
           
           $q_mes.=" order by FECOCURR asc";
           $q_mes.=" ) WHERE ROWNUM = 1";
           
           //echo$q_mes;
           // Create connection to Oracle
         
	
	$resultfecha = oci_parse($Enlace1,$q_mes);
        oci_execute($resultfecha);


    $row1 = oci_fetch_array($resultfecha, OCI_ASSOC+OCI_RETURN_NULLS);
     foreach ($row1 as $item) {
    
      $fecha_inicio_fondo=  $item;
     }
     //echo $fecha_inicio_fondo;
     $aux_fec_ini_fondo=explode("-",$fecha_inicio_fondo );
   
      switch ($mes) {
        
        case '01':   
            if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
              $fecha_ini= $fecha_inicio_fondo; 
            }
            else{
             $fecha_ini='01-01-'.$ano;
            }
            $fecha_fin='31-01-'.$ano;            
            break;
        case '02':
             
                if(Bisiesto($ano)){
                    
                     if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
                       $fecha_ini= $fecha_inicio_fondo; 
                     }
                     else{
                       $fecha_ini='01-02-'.$ano;
                     }
                    $fecha_fin='29-02-'.$ano;
                    
                    $num_dia_mes='29';
                }
                else{
                    if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
                       $fecha_ini= $fecha_inicio_fondo; 
                     }
                     else{
                       $fecha_ini='01-02-'.$ano;
                     }
                    $fecha_fin='28-02-'.$ano; 
                    $num_dia_mes='28';
                    echo $fecha_fin;
                }
            
            break;
        case '03': 
            if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
                $fecha_ini= $fecha_inicio_fondo; 
                }
                else{
                 $fecha_ini='01-03-'.$ano;
                }
            $fecha_fin='31-03-'.$ano; 
            $num_dia_mes='31';
            break;
        case '04':
            if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
                $fecha_ini= $fecha_inicio_fondo; 
                }
                else{
                 $fecha_ini='01-04-'.$ano;
                }
            $fecha_fin='30-04-'.$ano;
            $num_dia_mes='30';
            break;
        case '05':
            if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
                $fecha_ini= $fecha_inicio_fondo; 
                }
                else{
                 $fecha_ini='01-05-'.$ano;
                }
            $fecha_fin='31-05-'.$ano;
            break;
        case '06':
            if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
                $fecha_ini= $fecha_inicio_fondo; 
                }
                else{
                 $fecha_ini='01-06-'.$ano;
                }
            $fecha_fin='30-06-'.$ano;
            $num_dia_mes='30';
            break;
        case '07':
            if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
                $fecha_ini= $fecha_inicio_fondo; 
                }
                else{
                 $fecha_ini='01-07-'.$ano;
                }
            $fecha_fin='31-07-'.$ano;
            $num_dia_mes='31';
            break;
        case '08':
            if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
                $fecha_ini= $fecha_inicio_fondo; 
                }
                else{
                 $fecha_ini='01-08-'.$ano;
                }
            $fecha_fin='31-08-'.$ano;
            $num_dia_mes='31';
            break;
        case '09':
            if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
                $fecha_ini= $fecha_inicio_fondo; 
                }
                else{
                 $fecha_ini='01-09-'.$ano;
                }
            $fecha_fin='30-09-'.$ano;
            $num_dia_mes='30';
            break;
         case '10':
            if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
                $fecha_ini= $fecha_inicio_fondo; 
                }
                else{
                 $fecha_ini='01-10-'.$ano;
                }
            $fecha_fin='31-10-'.$ano;
            $num_dia_mes='31';
            break;         
         case '11':
            if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
                $fecha_ini= $fecha_inicio_fondo; 
                }
                else{
                 $fecha_ini='01-11-'.$ano;
                }
            $fecha_fin='30-11-'.$ano;
            $num_dia_mes='30';
            break;
        case '12':
            if($aux_fec_ini_fondo[1]==$mes and $aux_fec_ini_fondo[2]==$ano){
                $fecha_ini= $fecha_inicio_fondo; 
                }
                else{
                 $fecha_ini='01-12-'.$ano;
                }
            $fecha_fin='31-12-'.$ano;
            $num_dia_mes='31';
            break;
    }
      $fecha_inicio_cal= $fecha_ini;
      if($ano!=date("Y")){
         $fecha_fin_cal=$fecha_fin;
      }
      elseif($mes==date("m")){
         $fecha_fin_cal=date("d-m-Y"); 
      }
      else{
         $fecha_fin_cal=$fecha_fin;  
      }
            
            $CantidadDiasHabiles = Evalua(DiasHabiles($fecha_inicio_cal,$fecha_fin_cal))+1; 
            $CantidadDiasNormales=dias_mes($fecha_inicio_cal,$fecha_fin_cal)+1;
            
            echo  $fecha_inicio_cal."/". $fecha_fin_cal."/".$CantidadDiasHabiles."/".$CantidadDiasNormales;
    
}

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
'5-7',  //  Día de la Independencia (irrenunciable)
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

function Bisiesto($anyo){
	if(!checkdate(02,29,$anyo)){
		return false;
	}else{
		return true;
	}
}

function dias_mes($fecha1,$fecha2){
//defino fecha 1
$aux_fecha1=explode("-",$fecha1); 
$aux_fecha2=explode("-",$fecha2);

$ano1 = $aux_fecha1[2];
$mes1 = $aux_fecha1[1];
$dia1 = $aux_fecha1[0];

//defino fecha 2
$ano2 = $aux_fecha2[2];
$mes2 = $aux_fecha2[1];
$dia2 =$aux_fecha2[0];

//calculo timestam de las dos fechas
$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
$timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2);

//resto a una fecha la otra
$segundos_diferencia = $timestamp1 - $timestamp2;
//echo $segundos_diferencia;

//convierto segundos en días
$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

//obtengo el valor absoulto de los días (quito el posible signo negativo)
$dias_diferencia = abs($dias_diferencia);

//quito los decimales a los días de diferencia
$dias_diferencia = floor($dias_diferencia);

return $dias_diferencia;
}
?> 


