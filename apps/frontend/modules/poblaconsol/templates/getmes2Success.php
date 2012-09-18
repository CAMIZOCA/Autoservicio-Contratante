<?php
//print_r($CMB_TOT_MES);
//exit;
if ($CMB_TOT_MES > 1) {
    ?>
<option value="0">- Seleccione una opción - </option>
<!--    <option value="0">- Seleccione una opción - </option>
    <option value="0" <?php if($var_selectDefault == 0){ echo "selected";} ?>>- Todos - </option>-->
    <?php foreach ($CMB_MES as $row): ?>
        <option value="<?php echo $row['stsaseg']; ?>"><?php echo cambiarNombre($row['stsaseg']); ?></option>
    <?php endforeach; ?>
    <?php
    
    }
elseif ($CMB_TOT_MES == 1) {
    ?>
        <option value="0">- Seleccione una opción - </option>
    <?php foreach ($CMB_MES as $row): ?>
        <option value="<?php echo $row['stsaseg']; ?> - <?php echo cambiarNombre($row['stsaseg']); ?></option>
    <?php endforeach; ?>
   
    <?php
}else{
?>    
    <option value="0">-No hay datos - </option>
  <?php  
}

function cambiarNombre($tipo )
{
    //$i=0;
switch ($tipo) {
   case ACT:
         return "ACTIVO";
         break;
   case INC:
         return "INCLUIDO";
         break;
   case EXC:
         return "EXCLUIDO";
         break;
   case ANU:
         return "ANULADO";
         break;
}
    
    
    //return "Hacer una taza de $tipo.\n";
}
    ?>
