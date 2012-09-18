<?php use_helper('Number') ?> 
<?php use_helper('Date'); ?>
<?php $sf_user->setCulture('es_VE') ?>
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
                        <li class="last">Mensualizadas</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Resultado</h1>
                <div class="articleBox">

                    <form target="_self" method="get" id="form1" action="<?php echo url_for('altbamensua1/index') ?>" >


                        <table>
                            <tr><td>Cliente: </td><td><select name="cmbcliente" id="cmbcliente"></select></td></tr>
                            <tr><td>Contratante: </td><td><select name="cmbcontratante" id="cmbcontratante"></select></td></tr>
                            <tr><td>Año: </td><td><select name="cmbanno" id="cmbanno"></select></td></tr>
                            <tr><td>Estatus: </td><td>
                                <select id="cmbestatus" name="cmbestatus">
                                    <option <?php echo $result = ($var_idestatus == 0) ? 'selected' : ''; ?> value="0">- Todos -</option>
                                    <option <?php echo $result = ($var_idestatus == 'A') ? 'selected' : ''; ?> value="A">INCLUIDO</option>
                                    <option <?php echo $result = ($var_idestatus == 'B') ? 'selected' : ''; ?> value="B">EXCLUIDO</option>
                                </select> </td></tr>
                            <tr>
                            <tr>
                            <tr><td><input type="button" id="btn_getvalues"  class="btn_buscar" value="Buscar" /></td></tr>
                            </tr>
                        </table>
                    </form>


                    <!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
                    <?php
                    //echo $var_idcliente;
                    if ($var_idcliente != '') {
                        ob_start();
                        ?><div class="cajas_totales">
                            <div class="cajitas_peq_totales">
                                <div class="linea">
                                    <div class="titulo_cajita">NUMERO DE ALTAS:</div>
                                    <div class="total_bs"><?php echo ($TOTAL_ALTA[0]['TOTAL']); ?></div>
                                </div>
                                <div class="linea_media">
                                    <div class="titulo_cajita">NUMERO DE BAJAS:</div>
                                    <div class="total_bs"><?php echo ($TOTAL_BAJA[0]['TOTAL']); ?></div>
                                </div>
                            </div>
                        </div>
                        <table class="tableSector">
                            <thead>
                                <tr>
                                <th>N° de contrato</th>
                                <th>C.I. del titular</th>
                                <th>C.I del afiliado</th>
                                <th>Nombre del afiliado</th>
                                <th>Parentesco</th>
                                <th>Sexo</th>
                                <th>Status</th>
                                <th>Fecha de movimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($ALTA_BAJA_MENSUAL_VW as $row):
                                    ?>
                                    <tr>      

                                    <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaficha/index?mod=MEN&" . $_SERVER['QUERY_STRING'] . "&idcliente=" . $var_idcliente . "&idcontratante=" . $var_idcontratante . "&idcertificado=" . $row['CERTIFICADO'] . "") ?>'" /><?php echo $row['CONTRATO']; ?></td>
                                    <td class="alignRight"><?php echo $row['CEDULATIT']; ?></td>
                                    <td class="alignRight"><?php echo $row['CEDULABEN']; ?></td>
                                    <td ><?php echo $row['NOMBRE']; ?></td>
                                    <td class="alignRight"><?php echo $row['PARENTESCO_CROSS']; ?></td>
                                    <td class="alignRight"><?php echo $row['SEXO_PARENTESCO']; ?></td>
                                    <td ><?php echo $row['ESTATUS']; ?></td>
                                    <td class="alignRight"><?php echo format_date($row['FECMOV'], 'dd/MM/y '); ?></td>
                                    </tr>
                                    <?php
                                    //suma de totales
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                        <?php
                        echo $var = ob_get_clean();
                        ?>
                        <!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->




                        <!-- Formulario para crear pdf-->
                        <form method="post" id="targetpdf" action="<?php echo url_for('altbamensua1/listpdf') ?>" target="_blank" hidden="hidden">
                            <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Altas y Bajas Mensualizadas" />
                            <textarea id="sql_pdf" name="sql_pdf" rows="2" cols="20"  >
                                <?php echo $sql_pdf; ?>
                            </textarea>
                        </form>

                        <form method="post" id="targetprint" action="<?php echo url_for('altbamensua1/listprint') ?>" target="_blank" hidden="hidden" >    
                            <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Altas y Bajas Mensualizadas" />
                            <textarea id="sql_pdf" name="sql_pdf" rows="2" cols="20"  ><?php echo $sql_pdf; ?></textarea>
                        </form>
                        <form method="post" id="targetexcel" action="<?php echo url_for('altbamensua1/listexcel') ?>" target="_blank" hidden="hidden" >    
                            <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Altas y Bajas Mensualizadas" />
                            <textarea id="sql_pdf" name="sql_pdf" rows="2" cols="20"  ><?php echo $sql_pdf; ?></textarea>
                        </form>

                        <!-- fin-->
                        
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
                    }
                    ?>   
                    <div class="clear" style="padding-bottom:30px;"></div>

                    <!-- FIN DEL BACKEND -->

                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />

                    <table class="sectorBottomMenu" >
                        <tr>
                        <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
                        <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td> 
                        <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td>                                

                        </tr>                        
                    </table>


                    <script type="text/javascript">$("#cargando").css("display", "none");</script>

                    <script type="text/javascript">
                        $("#url_imprime").click(function (){
                            //$("html").printArea();
                            $('#targetprint').submit();
                        })
    
                        $('#url_pdf').click(function() {
                            $('#targetpdf').submit();
                        });   
                        //Funcion de submit excel
                        $('#url_excel').click(function() {
                            $('#targetexcel').submit();
                        });                         
                        
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    
    
    var varCliente = <?php echo $result = ($var_idcliente == '') ? $var_cero : $var_idcliente; ?>;
    var varContratante = '<?php echo $result = ($var_idcontratante == '') ? $var_cero : $var_idcontratante; ?>';
    var varAnno = <?php echo $result = ($var_idanno == '') ? $var_cero : $var_idanno; ?>;
    var varMes = <?php echo $result = ($var_idmes == '') ? $var_cero : $var_idmes; ?>;
   
    
    if(varCliente > -1){
        $("#cmbcliente").load("<?php echo 'poblaconsol/getclientewhere?id=' . $var_idcliente; ?>");
    }
    
    if(varContratante != -1){
        $("#cmbcontratante").load("<?php echo 'poblaconsol/getcontratante?idepol=' . $var_idcliente . '&cmbcontratante=' . $var_idcontratante; ?>");
    }
    
    if(varAnno > -1){
        $("#cmbanno").load("<?php echo 'poblaconsol/getanno?idepol=' . $var_idcliente . '&cmbcontratante=' . $var_idcontratante . '&cmbanno=' . $var_idanno; ?>");
    }
    
    if(varMes > -1){
        $("#cmbmes").load("<?php echo 'poblaconsol/getmes?idepol=' . $var_idcliente . '&idcontratante=' . $var_idcontratante . '&anno=' . $var_idanno; ?>");
    }

    
   
    $(document).ready(function(){   
        
        if(varCliente == -1){    
            $("#cmbcliente").load("<?php echo url_for('poblaconsol/getcliente') ?>");            
        }
        $().mCombo("#cmbcontratante", "<?php echo url_for('poblaconsol/getcontratante') ?>", "#cmbcliente");
        $().mCombo("#cmbanno", "<?php echo url_for('poblaconsol/getanno') ?>", "#cmbcontratante", "#cmbcliente");
        $().mCombo("#cmbmes", "<?php echo url_for('poblaconsol/getmes') ?>", "#cmbanno", "#cmbcontratante", "#cmbcliente");

        
        $(document).ready(function(){   
        
            if(varCliente == ''){    
                $("#cmbcliente").load("<?php echo url_for('poblaconsol/getcliente') ?>");     
            }
            $().mCombo("#cmbcontratante", "<?php echo url_for('poblaconsol/getcontratante') ?>", "#cmbcliente" );
            $().mCombo("#cmbanno", "<?php echo url_for('poblaconsol/getanno') ?>", "#cmbcontratante", "#cmbcliente");

        
            $("#btn_getvalues").click(function() {   
                $("#form1").submit();
                return false;
            });	
        
            if(varCliente =! ''){
                $("#cmbcontratante").removeAttr('disabled');
                $("#cmbanno").removeAttr('disabled');
            }
     
        });	
        
        if(varCliente > -1){
            $("#cmbcliente").removeAttr('disabled');
        }
    
        if(varContratante != -1){
            $("#cmbcontratante").removeAttr('disabled');
        }
    
        if(varAnno > -1){
            $("#cmbanno").removeAttr('disabled');
        }
    
        if(varMes > -1){
            $("#cmbmes").removeAttr('disabled');
        }
        
    });
    
    
</script>