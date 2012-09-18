<?php use_helper('Number') ?> 
<?php use_helper('Date'); ?>
<?php $sf_user->setCulture('es_VE') ?>
<?php   
//echo $_GET['mod'];
//IF ($_GET['mod'] == 'POC') {
//    $modulo = 'poblaconsol';
//}ELSE IF ($_GET['mod'] == 'PEM') {
//    $modulo = 'poblaevoluc';
//}ELSE IF ($_GET['mod'] == 'PES') {
//    $modulo = 'poblarangos';
//}ELSE IF ($_GET['mod'] == 'PEP') {
//    $modulo = 'poblarangop';
//}
//
////$url_atras="http://".$_SERVER['SERVER_NAME']."/".$modulo."?".$_SERVER['QUERY_STRING'];
//$url_atras="http://".$_SERVER['SERVER_NAME']."/poblaresum?".$_SERVER['QUERY_STRING'];
?>
<div id="mainContentSector"><!--end innerwrap--> 
    <div id="innerwrap"> 
        <div id="sideBar">
            <!-- MODULO ACTIVO -->
            <?php include('_modActivo.php'); ?>
            <!-- DEADLINE -->            
            <?php include_partial('poblaconsol/quickDeadlineBox') ?>
            <!-- QUICK RECORD -->
            <?php include_partial('poblaconsol/quickUserBox', array(
                'UserName' => $UserName, 
                'FirstName' => $FirstName,
                'LastName' => $LastName,
                'CreatedAt' => $CreatedAt                
                )) ?>    
        </div>

        <div id="contentBar">
            <div class="articleContentSector">

                <!-- BREADCRUMB -->
                <div class="breadcrumbBox">
                    <ul>
                        <li><a href="<?php echo url_for('maindashboard/index') ?>">AutoServicio</a></li>
                        <li><a href="<?php echo $url_atras_mod; ?>"><?php echo $tituloModulo; ?></a></li>
                        <?php if($_GET['mod'] != 'MEN'){ ?>
                        <li><a href="<?php echo $url_atras; ?>">Resumen de población</a></li>                        
                        <?php } ?>
                        <li class="last">Ficha</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Ficha</h1>
                <div class="articleBox">

                    <!-- INICIO -->
<!--                    <div class="clear" style="padding-bottom:30px;"></div>
                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />-->
                    <!-- INICIO PANTALLAS BACKEND -->
                    <div id="cargando" style="display: none;"><img src="/images/green-loading.gif" style="text-align: center" />&nbsp;</div>
                    
                    <!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
                    <?php
                    ob_start();
                    ?>
                    <!-- FIN-->
                    
                    <table class="tableSector">
                        <thead>
                            <tr>
                                <th colspan="2">Titular</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($registros as $row):
                                ?>
                                <tr>                                      
                                    <td>Nombre: </td><td><?php echo $row['NOMBRE'];
                                    //echo ($row['NOMBRE'] !== null ? htmlentities($row['NOMBRE'], ENT_QUOTES) : "&nbsp;");
                                    
                                    ?></td>
                                </tr>
                                <tr>                                      
                                    <td>Cedula</td><td><?php echo $row['CEDULA']; ?></td>
                                </tr>
                                <tr>                                      
                                    <td>Fecha de Vigencia: </td><td>Desde: <?php echo format_date($row['VIGENCIADESDE'], 'dd/MM/y'); ?> Hasta: <?php echo format_date($row['VIGENCIAHASTA'], 'dd/MM/y'); ?></td>
                                </tr>

                                <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>


                    <table class="tableSector">
                        <thead>
                            <tr>
                                <th colspan="7">Afiliados</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cédula</th>
                                <th>Parentesco</th>
                                <th>Edad</th>
                                <th>Fecha Nacimiento</th>
                                <th>Sexo</th>
                                <th>Fecha de Inclusión</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($registros2 as $row):
                                ?>
                                <tr>                                      
                                    <td><?php  echo $row['NOMBRE']; ?></td> 
                                    <td><?php echo $row['CEDULA']; ?></td> 
                                    <td class="alignRight"><?php echo $row['PARENTESCO_CROSS']; ?></td> 
                                    <td class="alignRight"><?php echo $row['EDAD']; ?></td>                                     
                                    <td class="alignRight"><?php echo format_date($row['FECNAC'], 'dd/MM/y'); ?></td> 
                                    <td class="alignRight"><?php echo $row['SEXO']; ?></td> 
                                    <td class="alignRight"><?php echo format_date($row['FECING'], 'dd/MM/y'); ?></td> 
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>

                    <table class="tableSector">
                        <thead>
                            <tr>
                                <th colspan="7">Coberturas</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th colspan="2"> </th>
                                <th colspan="5">Básico</th>

                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Parentesco</th>

                                <th>Contrato</th>
                                <th>Plan</th>
                                <th>Ramo</th>
                                <th>Suma Asegurada</th>
                                <th>Deducible</th>



                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tmp1 = '';
                            foreach ($registros3 as $row):
                                ?>
                                <tr>                                      
                                    <td><?php
                                ///echo 'NOM='.$row['NOMBRE'].' TMP1='. $tmp1;
                                if ($row['NOMBRE'] == $tmp1):
                                    echo $tmp1 = '';
                                else:
                                    echo $tmp1 = $row['NOMBRE'];
                                endif;
                                $tmp1 = $row['NOMBRE'];
                                ?></td> 
                                    <td><?php echo $row['PARENTESCO_CROSS']; ?></td> 
                                    <td><?php echo $row['CENTRO_COSTO']; ?></td> 
                                    <td><?php echo $row['CODPLAN']; ?></td> 
                                    <td><?php echo $row['CODRAMO']; ?></td> 
                                    <td class="alignRight"><?php echo $row['SUMAASEGMONEDA']; ?></td> 
                                    <td class="alignRight"><?php echo $row['DEDUCIBLE']; ?></td> 
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                    
                    <!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
<?php
echo $var = ob_get_clean();
?>
<!--FIN-->
                    
                    <div class="clear" style="padding-bottom:30px;"></div>
                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />
                    <table class="sectorBottomMenu">
                        <tr>
                            <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
                            <td><a href="#" id="url_pdf">PDF</a></td> 
                            <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                
                            <td><a href="<?php echo $url_atras_mod; ?>" id="url_atras">Atrás</a></td>
                        </tr>                        
                    </table>
                    <script type="text/javascript">$("#cargando").css("display", "none");</script>



                    <script type="text/javascript">
                        $("#url_imprime").click(function (){
                            $("html").printArea();
                        })
                    //    funcion de submit pdf
                        $('#url_pdf').click(function() {
                            $('#targetpdf').submit();
                        });    
                        //Funcion de submit excel
                        $('#url_excel').click(function() {
                            $('#targetexcel').submit();
                        });                         
                    </script>
                    
                    <!-- Formulario oculto para crear pdf-->
<form method="post" id="targetpdf" action="<?php echo url_for('pdfpoblacion/index') ?>" target="_blank" hidden="hidden">
<input id="titulo_pdf"  name="titulo_pdf" type="text" value="Población Consolidada" />
    <textarea id="text_pdf" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
</form>
<!-- fin-->
<!-- Formulario oculto para crear excel-->
<form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
<input id="titulo"  name="titulo" type="text" value="Población Consolidada" />
    <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
</form>
<!-- fin-->
                </div>
            </div>
        </div>
    </div>
</div>
