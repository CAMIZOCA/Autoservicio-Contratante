<?php error_reporting(E_ALL & ~E_NOTICE); 

$cliente=$_GET["cliente"]; 
$contratante=$_GET["contratante"];
$ciudad=$_GET["ciudad"];
//echo "ciudad ".$ciudad;
$tipo_pro=$_GET["tipo_pro"];

$Enlace2 = oci_connect('AUTO_CONTRA', 'AUTO_CONTRA', '172.20.0.26/autoserv'); //PRODUCCION
//$Enlace2 = oci_connect('AUTO_CONTR_DES', 'AUTO_CONTR_DES', '172.20.0.18/autoservicio');
	
	if ( !$Enlace2 ){ 
		echo "<br />No es posible conectar: " . var_dump( OCIError() ); 
		die();
			return false;
	}	

 $q223 ="SELECT to_char(fecocurr, 'yyyy') as anno FROM SINIESTRALIDAD_VW  J 
                    WHERE 1=1 ";           
           if(trim($cliente)!=''){
            $q223.=" AND IDEPOL ='$cliente' ";   
           }
           if(trim($contratante)!='' and trim($contratante)!='todos'){
            $q223.=" AND CODEXTERNO ='$contratante' ";   
           }
           if(trim($ciudad)!=''and trim($ciudad)!='todos' and trim($ciudad)!='-1') {
            $q223.=" AND CIUDAD='$ciudad' ";   
           }  
            if(trim($tipo_prov)!=''and trim($tipo_prov)!='todos' and trim($tipo_prov)!='-1'){
             $q223.=" AND TIPOPROV='$tipo_prov' ";   
           } 
           $q223.=" GROUP BY to_char(fecocurr, 'yyyy')";
          
    
          $resultfecha4 = oci_parse($Enlace2,$q223);
           oci_execute($resultfecha4);

$i=0;
$sal="";
        
        //$row55 = oci_fetch_array($resultfecha4, OCI_ASSOC+OCI_RETURN_NULLS);
        while ($row = oci_fetch_array($resultfecha4, OCI_ASSOC)) {
            $sal=$sal.$row['ANNO']."/";

          }
                 
         echo $sal;
?>

