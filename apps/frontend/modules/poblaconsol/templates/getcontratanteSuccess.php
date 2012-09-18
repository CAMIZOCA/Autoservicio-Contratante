<?php
if ($CMB_TOT_CONTRATANTE_MVW > 1) {
    ?>
    <option value="0">- Seleccione una opción - </option>
    <option value="0" <?php if($var_selectDefault == 0){ echo "selected";} ?> >- Todos - </option>
    <?php foreach ($CMB_CONTRATANTE_MVW as $row): ?>
    <option <?php if($var_selectDefault == $row['codctrocos']){ echo "selected";} ?> value="<?php echo $row['codctrocos']; ?>"><?php echo $row['desctrocos']; ?></option>
    <?php endforeach; ?>
    <?php
} else {
    ?>
        <option value="0" <?php if($var_selectDefault == 0){ echo "selected";} ?> >- Seleccione una opción -</option>
    <?php foreach ($CMB_CONTRATANTE_MVW as $row): ?>
        <option <?php if($var_selectDefault == $row['codctrocos']){ echo "selected";} ?>  value="<?php echo $row['codctrocos']; ?>"><?php echo $row['desctrocos']; ?></option>
    <?php endforeach; ?>
    <?php
}
?>






