<?php use_helper('Number') ?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php //print_r($_POST);  ?>


<table class="tableSector">
                            <thead>
                                <tr>
                                    <th>Tildar</th>
                                    <th>C.I. del Afiliado</th>
                                    <th>Nombre del Afiliado</th>
                                    <th>Sexo</th>
                                    <th>Edad</th>
                                    <th>Parentesco</th>
                                    <th>F. De nacimiento</th>
                                    <th>Codigo de ente</th>
                                    <th>F. de Inclusion</th>
                                    <th>Tiempo de inclusion(Meses)</th>                                
                                </tr>
                            </thead>
                            <tbody>
                                <?php
        foreach ($POBLACION_BUSQUEDA_GENER as $row):
            ?>
                                
                                <tr>                                
                                    <td><input class="botonadd"  type="button" /> </td>
                                    <td class="alignRight"><?php echo $row['CEDULA']; ?></td>
                                    <td class="alignRight"><?php echo $row['NOMBRE']; ?></td>
                                    <td class="alignRight"><?php echo $row['SEXO']; ?></td>
                                    <td class="alignRight"><?php echo $row['EDAD']; ?></td>
                                    <td class="alignRight"><?php echo $row['PARENTESCO']; ?></td>
                                    <td class="alignRight"><?php echo $row['FECNAC']; ?></td>
                                    <td class="alignRight"><?php echo $row['DESCTROCOS']; ?></td>
                                    <td class="alignRight"><?php echo $row['FECING']; ?></td>
                                    <td class="alignRight"><?php echo format_number($row['INCLUSION']); ?></td>
                                    
                                </tr>
                       <?php            
        endforeach;
        ?>


                            </tbody>


                        </table>


<hr style="background-color:#E8E8E8; height:2px; border:0;" />
<table class="sectorBottomMenu">
    <tr>
<!--        <td><a href="#" id="url_excel">Excel</a></td>
        <td><a href="#" id="url_pdf">PDF</a></td> -->
        <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                
    </tr>                        
</table>
<script type="text/javascript">$("#cargando").css("display", "none");</script>



<script type="text/javascript">
    $("#url_imprime").click(function (){
        $("html").printArea();
    })
</script>

