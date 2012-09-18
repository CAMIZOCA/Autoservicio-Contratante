<?php 
//pantalla para llenar el combo de CLIENTE
$items = array();
foreach ($ente_contratante_vw as $row): 
    $items[] = array( $row['idepol'], $row['idepol'] . ' - ' . $row['descripcion']);
endforeach;
echo(json_encode($items));
?>