<?php error_reporting(E_ALL & ~E_NOTICE); 

$cliente=$_GET["cliente"]; 
$contratante=$_GET["contratante"];
$localidad=$_GET["ciudad"];
$Enlace2 = oci_connect('AUTO_CONTRA', 'AUTO_CONTRA', '172.20.0.26/autoserv'); //PRODUCCION
//$Enlace2 = oci_connect('AUTO_CONTR_DES', 'AUTO_CONTR_DES', '172.20.0.18/autoservicio');
	
	if ( !$Enlace2 ){ 
		echo "<br />No es posible conectar: " . var_dump( OCIError() ); 
		die();
			return false;
	}	

 $q_consolidado = "SELECT DISTINCT TIPOPROV FROM SINIESTRALIDAD_VW WHERE TIPOPROV<>' '";
        if(trim($cliente)!=''){
          $q_consolidado.=" and IDEPOL='$cliente' ";  
        }  
         if(trim($contratante)!=''and trim($contratante)!='todos'){
            $q_consolidado.=" AND CODEXTERNO ='$contratante' ";   
           }
           
          if(trim($localidad)!='' and trim($localidad)!='todos' and trim($localidad)!='-1' ){
            $q_consolidado.=" AND CIUDAD='$localidad' ";   
           }  
    
          $resultfecha4 = oci_parse($Enlace2,$q_consolidado);
           oci_execute($resultfecha4);

$i=0;
$sal="";
        
        $row55 = oci_fetch_array($resultfecha4, OCI_ASSOC+OCI_RETURN_NULLS);
        
         foreach ($row55 as $item55){
          $i++;
          $tipoprov4=$item55;
          $sal.= $tipoprov4."/";
         }
      
      echo   $sal.$q_consolidado;
?>

