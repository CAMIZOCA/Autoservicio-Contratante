<?php 
//pantalla para llenar el combo de anno
//$items = array();
//$items[] = array( '*', 'Todos');
//foreach ($CMB_MES as $row): 
//    $items[] = array( $row['mes'], $row['anno'].' '.$row['mesnum']);
//endforeach;
//echo(json_encode($items));
?>

<?php
if ($CMB_TOT_MES > 1) {
    ?>
    <option value="0">- Seleccione una opción - </option>
    <option value="0" <?php if($var_selectDefault == 0){ echo "selected";} ?>>- Todos - </option>
    <?php foreach ($CMB_MES as $row): ?>
        <option value="<?php echo $row['mes']; ?> AND TO_CHAR (FECING, 'YYYY') =<?php echo $row['anno']; ?>"><?php echo $row['mesnum']; ?> - <?php echo $row['anno']; ?></option>
    <?php endforeach; ?>
    <?php
    
    }
elseif ($CMB_TOT_MES == 1) {
    ?>
    <?php foreach ($CMB_MES as $row): ?>
        <option value="<?php echo $row['mes']; ?>"><?php echo $row['mesnum']; ?> - <?php echo $row['anno']; ?></option>
    <?php endforeach; ?>
   
    <?php
}else{
?>    
    <option value="0">-No hay datos - </option>
  <?php  
}
?>
