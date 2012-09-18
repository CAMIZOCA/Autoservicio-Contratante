<?php
if ($CMB_TOT_MES > 1) {
    ?>
    <option value="0">- Seleccione una opción - </option>
    <option value="0" <?php if($var_selectDefault == 0){ echo "selected";} ?>>- Todos - </option>
    <?php foreach ($CMB_MES as $row): ?>
        <option value="<?php echo $row['mes']; ?>"><?php echo $row['mesnum']; ?></option>
    <?php endforeach; ?>
    <?php
    
    }
elseif ($CMB_TOT_MES == 1) {
    ?>
    <?php foreach ($CMB_MES as $row): ?>
        <option value="<?php echo $row['mes']; ?>"><?php echo $row['mesnum']; ?></option>
    <?php endforeach; ?>
   
    <?php
}
else{
?>    
    <option value="0">-No hay datos - </option>
  <?php  
}
?>
