<?php 
//pantalla para llenar el combo de contratante filtrado por el id del cliente
$items = array();
foreach ($CONTRATO_POLIZA_VW as $row): 
    $items[] = array( $row['idepol'], $row['idepol'] . ' - ' . $row['desctrocos']);
endforeach;
echo(json_encode($items));
?>