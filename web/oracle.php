<?php 
	$Enlace = oci_connect('AUTO_CONTRA', 'AUTO_CONTRA', '172.20.0.26/autoserv');
	
	if ( !$Enlace ){ 
		echo "<br />No es posible conectar: " . var_dump( OCIError() ); 
		die();
			return false;
	}else{
	 echo "Si conecto :) ";
		//return true;
	}	
	
	$stid = oci_parse($Enlace, "SELECT 
        ROWNUM AS CONTADOR, 
        NUMID, CERTIFICADO, 
        CEDULA, 
        NOMBRE, 
        FECING, 
        IDEPOL, 
        PLAZO_ESPERA, 
        SEXO_PARENTESCO, 
        PARENTESCO_CROSS, 
        EDAD 
    FROM POBLACION_MVW 
    where 
    CEDULA = 'V-6267076'");
oci_execute($stid);

echo "<table border='1'>\n";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) {        
		echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    echo "</tr>\n";
}
echo "</table>\n";
	
	
	
	
?>

