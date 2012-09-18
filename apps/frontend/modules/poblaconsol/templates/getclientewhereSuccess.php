<option value="0">- Seleccione una opción - </option>
<?php foreach ($CMB_CLIENTE_MVW as $row): ?>
    <option  <?php if($var_idcliente == $row['idepol']){ echo "selected";} ?> value="<?php echo $row['idepol']; ?>"><?php echo $row['descripcion']; ?></option>
<?php endforeach; ?>
