<?php use_helper('Number') ?> 
<?php use_helper('Date'); ?>
<?php $sf_user->setCulture('es_VE') ?>
<?php
//echo $_SERVER['SERVER_NAME'];
$url_atras = "http://" . $_SERVER['SERVER_NAME'] . "/altbaevoluc/index?" . $_SERVER['QUERY_STRING'];
?>
<div id="mainContentSector"><!--end innerwrap--> 
    <div id="innerwrap"> 
        <div id="sideBar">
            <!-- MODULO ACTIVO -->
            <?php include('_modActivo.php'); ?>
            <!-- DEADLINE -->            
            <?php include_partial('poblaconsol/quickDeadlineBox') ?>
            <!-- QUICK RECORD -->
            <?php
            include_partial('poblaconsol/quickUserBox', array(
                'UserName' => $UserName,
                'FirstName' => $FirstName,
                'LastName' => $LastName,
                'CreatedAt' => $CreatedAt
            ))
            ?>   
        </div>

        <div id="contentBar">
            <div class="articleContentSector">

                <!-- BREADCRUMB -->
                <div class="breadcrumbBox">
                    <ul>
                        <li><a href="<?php echo url_for('maindashboard/index') ?>">AutoServicio</a></li>
                        <li><a href="<?php echo $url_atras; ?>">Evolución</a></li>
                        <li class="last">Resumen de altas y bajas</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Resultado</h1>
                <div class="articleBox">
                    <div id="cargando" style="display: none;"><img src="/images/green-loading.gif" style="text-align: center" />&nbsp;</div>
                    <div id="showTable" name="show" ></div>
                    <table class="tableSector">
                        <thead>
                            <tr>
                            <th>Afiliado </th>
                            <th>C.I. </th>
                            <th>Contrato </th>
                            <th>Fecha Movimiento </th>
                            <th>Plazo de espera</th>
                            <th>Parentesco</a> </th>
                            <th>Sexo</th>
                            <th>Edad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //print_r($registros );
                            foreach ($registros as $row):
                                ?>
                                <?php

                                $var_idcliente = $_GET['idcliente'];
                                $var_idcontratante = $_GET['idcontratante'];
                                $var_CERTIFICADO = $row['CERTIFICADO'];
                                ?>       

                                <tr>
                                <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaficha/index?".$_SERVER['QUERY_STRING']."&idcliente=" . $var_idcliente . "&idcontratante=" . $var_idcontratante . "&idcertificado=" . $var_CERTIFICADO . "") ?>'" /><?php echo $row['NOMBRE'];?></td>
<!--                                <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaficha/index?idcliente=" . $var_idcliente . "&idcontratante=" . $var_idcontratante . "&idcertificado=" . $var_CERTIFICADO . "") ?>'" /><?php echo $row['NOMBRE']; ?></td>-->
                                <td class="alignRight"><?php echo $row['CEDULA']; ?></td>
                                <td class="alignRight"><?php echo $row['IDEPOL']; ?></td>
                                <td class="alignRight"><?php echo format_date($row['FECMOV'], 'dd-MM-y'); ?></td>
                                <td class="alignRight"><?php echo $row['PLAZO_ESPERA']; ?></td>

                                <td class="alignRight"><?php echo $row['PARENTESCO_CROSS']; ?></td>
                                <td class="alignRight"><?php echo $row['SEXO_PARENTESCO']; ?></td>
                                <td class="alignRight"><?php echo $row['EDAD']; ?></td>
                                </tr>
                                <?php
                            endforeach;
                            ?>

                        </tbody>
                    </table>

                    <table class="sectorBottomMenu" >
                        <tr>
                    <!--        <td><a href="#" id="url_excel">Excel</a></td>-->
                        <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td> 
                    <!--    <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>      -->
                        <td><a href="<?php echo $url_atras; ?>" id="url_atras">Atrás</a></td>

                        </tr>                        
                    </table>

                    <br /><br />

                    <!-- Formulario oculto para crear pdf-->
                    <form method="post" id="targetpdf" action="<?php echo url_for('altbaevoluc/listpdf') ?>" target="_blank" hidden="hidden">
                    <!--<form method="post" id="targetpdf" action="<?php echo url_for('altbaevoluc/lis') ?>" target="_blank" >-->
                        <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Altas y Bajas - Evolución" />
                        <textarea id="sql_pdf" name="sql_pdf" rows="2" cols="20"  ><?php echo $sql_pdf; ?></textarea>
                    </form>
                    <!-- fin-->



                    <script type="text/javascript">$("#cargando").css("display", "none");</script>


                    <script type="text/javascript">
                        $("#url_imprime").click(function (){
                            $("html").printArea();
                        })
                        //    funcion de submit pdf
                        $('#url_pdf').click(function() {
                            $('#targetpdf').submit();
                        });    
                    </script>



                    <div class="clear" style="padding-bottom:30px;"></div>
                    <?php
// Parametros a ser usados por el Paginador.
                    $cantidadRegistrosPorPagina = 10;
                    $cantidadEnlaces = 25; // Cantidad de enlaces que tendra el paginador.
                    $totalRegistros = $totalRegistros;
                    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0;

// Comenzamos incluyendo el Paginador.
                    require_once 'Paginador.php';

// Instanciamos la clase Paginador
                    $paginador = new Paginador();

// Configuramos cuanto registros por pagina que debe ser igual a el limit de la consulta mysql
                    $paginador->setCantidadRegistros($cantidadRegistrosPorPagina);
// Cantidad de enlaces del paginador sin contar los no numericos.
                    $paginador->setCantidadEnlaces($cantidadEnlaces);

// Agregamos estilos al Paginador
                    $paginador->setClass('primero', 'previous');
                    $paginador->setClass('bloqueAnterior', 'previous');
                    $paginador->setClass('anterior', 'previous');
                    $paginador->setClass('siguiente', 'next');
                    $paginador->setClass('bloqueSiguiente', 'next');
                    $paginador->setClass('ultimo', 'next');
                    $paginador->setClass('numero', '<>');
                    $paginador->setClass('actual', 'active');

// Y mandamos a paginar desde la pagina actual y le pasamos tambien el total
// de registros de la consulta mysql.
                    $datos = $paginador->paginar($pagina, $totalRegistros);

// Preguntamos si retorno algo, si retorno paginamos. Nos retorna un arreglo
// que se puede usar para paginar del modo clasico. Si queremos paginar con
// el enlace ya confeccionado realizamos lo siguiente.
                    if ($datos) {
                        $enlaces = $paginador->getHtmlPaginacion('pagina', 'li');
                        ?>
                        <ul id="pagination-digg">
                            <?php
                            foreach ($enlaces as $enlace) {
                                echo $enlace . "\n";
                            }
                            ?>
                        </ul>
                        <br /><br />
                        <?php
                    }
                    ?>  


                </div>
            </div>
        </div>
    </div>
</div>
