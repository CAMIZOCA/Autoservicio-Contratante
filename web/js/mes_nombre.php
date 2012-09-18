<?php error_reporting(E_ALL & ~E_NOTICE); 
$mes=$_GET["mes"]; 


   switch ($mes) {
        case 'Enero':           
             $num_mes='01';           
            break;
        case 'Febrero':         
             $num_mes='02';
            break;
        case 'Marzo':
            $num_mes='03';
            break;
        case 'Abril':
           $num_mes='04';
            break;
        case 'Mayo':
            $num_mes='05';
            break;
        case 'Junio':
            $num_mes='06';
            break;
        case 'Julio':
            $num_mes='07';
            break;
        case 'Agosto':
            $num_mes='08';
            break;
        case 'Septiembre':
            $num_mes='09';
            break;
        case 'Octubre':
            $num_mes='10';
            break;
         case 'Noviembre':
            $num_mes='11';
            break;         
         case 'Diciembre':
            $num_mes='12';
            break;
     
    }
     
    echo  $num_mes ;
  
?>
