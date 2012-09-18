<?php
if ($CMB_TOTAL_ANNO > 1) {
    ?>
    <option value="0">- Seleccione una opción -</option>
    <option value="0" <?php if($var_selectDefault == 0){ echo "selected";} ?> >- Todos - </option>
    <?php foreach ($CMB_ANNO as $row): ?>
        <option <?php if($var_selectDefault == $row['anno']){ echo "selected";} ?> value="<?php echo $row['anno']; ?>"><?php echo $row['anno']; ?></option>
    <?php endforeach; ?>
    <?php
} elseif ($CMB_TOTAL_ANNO == 1) {
    ?>
        <option value="0">- Seleccione una opción -</option>
    <?php foreach ($CMB_ANNO as $row): ?>
        <option <?php if($var_selectDefault == $row['anno']){ echo "selected";} ?> value="<?php echo $row['anno']; ?>"><?php echo $row['anno']; ?></option>
    <?php endforeach; ?>

    <?php
}else{
?>    
    <option value="0">NO HAY DATOS</option>
  <?php  
}
?>


