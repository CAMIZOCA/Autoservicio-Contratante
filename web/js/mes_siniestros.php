<?php error_reporting(E_ALL & ~E_NOTICE); 

$cliente=$_GET["cliente"]; 
$contratante=$_GET["contratante"];
$tipo_servicio=$_GET["tipo_servicio"];
$ano=$_GET["ano"];

$Enlace2 = oci_connect('AUTO_CONTRA', 'AUTO_CONTRA', '172.20.0.26/autoserv');
//$Enlace2 = oci_connect('AUTO_CONTR_DES', 'AUTO_CONTR_DES', '172.20.0.18/autoservicio');		
	if ( !$Enlace2 ){ 
		echo "<br />No es posible conectar: " . var_dump( OCIError() ); 
		die();
			return false;
	}	

   $q_mes ="SELECT to_char(FECOCURR,'mm') as mes, to_char(FECOCURR,'yyyy') as anno
                  FROM SINIESTRALIDAD_VW  J WHERE 1=1 ";           
           if(trim($cliente)!=''){
            $q_mes.=" AND IDEPOL ='$cliente' ";   
           }
           if(trim($contratante)!='' and trim($contratante)!='todos'){
            $q_mes.=" AND CODEXTERNO ='$contratante' ";   
           }
            
           
           if(trim($tipo_servicio)!=''and trim($tipo_servicio)!='todos'and trim($tipo_servicio)!='-1'){
            $q_mes.=" AND COD_TIPO_DESC='$tipo_servicio' ";   
           } 
           
           if(trim($ano)!='' and trim($ano)!='-1'){
            $q_mes.=" and to_char(fecocurr,'yyyy') ='$ano' ";   
           }
           
           $q_mes.=" GROUP BY to_char(fecocurr,'mm'),to_char(fecocurr,'yyyy')";
           $q_mes.=" order by to_char(FECOCURR,'yyyy') asc, to_char(FECOCURR,'mm') asc";
           
           
          $resultfecha5 = oci_parse($Enlace2,$q_mes);
           oci_execute($resultfecha5);

$i=0;
$sal="";
        
        //$row575 = oci_fetch_array($resultfecha5, OCI_ASSOC+OCI_RETURN_NULLS);
         while ($row = oci_fetch_array($resultfecha5, OCI_ASSOC)) {             
            $mes= $row['MES'];
            if(trim($mes)!=''){
            $sal=$sal.$row['ANNO']." ".getMes($mes)."/";
            }
          }
             
      echo  $sal;
      
      
 function getMes($mes){
    switch ($mes) {
        case "01":
            $mes_nombre="Enero";
            break;
        case "02":
            $mes_nombre="Febrero";
            break;
        case "03":
            $mes_nombre="Marzo";
            break;
         case "04":
            $mes_nombre="Abril";
            break;
        case "05":
            $mes_nombre="Mayo";
            break;
        case "06":
            $mes_nombre="Junio";
            break;
         case "07":
            $mes_nombre="Julio";
            break;
        case "08":
            $mes_nombre="Agosto";
            break;
        case "09":
            $mes_nombre="Septiembre";
            break;
         case "10":
            $mes_nombre="Octubre";
            break;
        case "11":
            $mes_nombre="Noviembre";
            break;
        case "12":
            $mes_nombre="Diciembre";
            break;
    }
 return $mes_nombre;
}

?>