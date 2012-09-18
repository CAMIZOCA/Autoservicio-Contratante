<?php 
//pantalla para llenar el combo de CLIENTE
//$items = array();
//foreach ($CMB_CLIENTE_MVW as $row): 
//    //$items[] = array( $row['idepol'], $row['idepol'] . ' - ' . $row['descripcion']);
//    $items[] = array( $row['idepol'], $row['descripcion']);
//endforeach;
//echo(json_encode($items));
?>
<option value="0">- Seleccione una opción - </option>
<?php foreach ($CMB_CLIENTE_MVW as $row): ?>
    <option value="<?php echo $row['idepol']; ?>"><?php echo $row['descripcion']; ?></option>
<?php endforeach; ?>
