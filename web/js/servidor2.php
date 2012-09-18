<?php error_reporting(E_ALL & ~E_NOTICE); 
$mes=$_GET["mes"]; 
$ano=$_GET["year"];

   switch ($mes) {
        case '0':
           if(Bisiesto($ano)){
             $num_dia_mes='366';
            }
            else{
             $num_dia_mes='365';   
            }
            break;
        case '01':         
           $num_dia_mes='31';
            break;
        case '02':
            if(Bisiesto($ano)){
             
                $num_dia_mes='29';
            }
            else{
              
                $num_dia_mes='28';
            }
            break;
        case '03':
           
            $num_dia_mes='31';
            break;
        case '04':
            $num_dia_mes='30';
            break;
        case '05':
            $num_dia_mes='31';
            break;
        case '06':
            $num_dia_mes='30';
            break;
        case '07':
            $num_dia_mes='31';
            break;
        case '08':
            $num_dia_mes='31';
            break;
        case '09':
            $num_dia_mes='30';
            break;
         case '10':
            $num_dia_mes='31';
            break;         
         case '11':
            $num_dia_mes='30';
            break;
        case '12':
            $num_dia_mes='31';
            break;
    }
     
    echo $num_dia_mes;
    
    function Bisiesto($anyo){
	if(!checkdate(02,29,$anyo)){
		return false;
	}else{
		return true;
	}
}
?>
