<?php use_helper('Number') ?> 
<?php use_helper('Date'); ?>
<?php $sf_user->setCulture('es_VE'); ?>


<div id="mainContentSector"><!--end innerwrap--> 
    <div id="innerwrap"> 
        <div id="sideBar">
            <!-- MODULO ACTIVO -->
            <?php include('_modActivo.php'); ?>
            <!-- DEADLINE -->            
            <?php include_partial('poblaconsol/quickDeadlineBox') ?>
            <!-- QUICK RECORD -->
            <?php include('_quickUserBox.php') ?>    
            <?php //include_partial('quickUserBox') ?>    
        </div>

        <div id="contentBar">
            <div class="articleContentSector">

                <!-- BREADCRUMB -->
                <div class="breadcrumbBox">
                    <ul>
                        <li><a href="<?php echo url_for('maindashboard/index') ?>">AutoServicio</a></li>
                        <!--                        <li><a href="#">Población</a></li>-->
                        <li class="last">Población Consolidada</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Población Consolidada</h1>
                <div class="articleBox">
                    <form target="#" id="form1"  >
                        <input id="get_idcliente" type="text" value="<?php echo $_GET['idcliente']; ?>" />
                        <input id="get_idcontratante" type="text" value="<?php echo $_GET['idcontratante']; ?>" />
                        <input id="get_idanno" type="text" value="<?php echo $_GET['idanno']; ?>" />
                        <input id="get_idmes" type="text" value="<?php echo $_GET['idmes']; ?>" />
                        <input id="get_idestatus" type="text" value="<?php echo $_GET['idestatus']; ?>" />
                        <table>
                            <tr><td>Cliente: </td><td style="width: 450px"><select name="cmbcliente" id="cmbcliente"></select></td></tr>
                            <tr><td>Contratante: </td><td><select name="cmbcontratante" id="cmbcontratante"></select></td></tr>                            
                            <tr><td>Año: </td><td><select name="cmbanno" id="cmbanno"></select></td></tr>
                            
                            <tr><td>Estatus: </td>
                            <td>
                                <select id="cmbestatus">
                                    
                                </select> 
                            </td>
                            </tr>
                            <tr><td>Mes: </td><td><select name="cmbmes" id="cmbmes"></select></td></tr>
                            <tr><td><input type="button" id="btn_getvalues" class="btn_buscar"  value="Buscar" /></td></tr>
                            <tr></tr>
                        </table>
                    </form>
                    <!-- INICIO -->
                    <div class="clear" style="padding-bottom:30px;"></div>
                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />
                    <!-- INICIO PANTALLAS BACKEND -->
                    <div id="cargando" style="display: none;"><img src="/images/green-loading.gif" style="text-align: center" />&nbsp;</div>
                    <div id="showTable" name="show" ></div>
                    <div class="clear" style="padding-bottom:30px;"></div>

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
        cargarContenido();
    }
    

    function cargarContenido(){

        $("#cargando").css("display", "inline");
        $("#showTable").load("<?php echo url_for('poblaconsol/gettable') ?>",{ 
            idcliente:         $("#get_idcliente").val() ,
            idcontratante :    $("#get_idcontratante").val() ,
            idanno :           $("#get_idanno").val() ,
            idmes :            $("#get_idmes").val() ,
            idestatus :        $("#get_idestatus").val() 
        });
        return false;
        
    }
    function cargarContenidoClik(){
        
        $("#cargando").css("display", "inline");
        $("#showTable").load("<?php echo url_for('poblaconsol/gettable') ?>",{ 
            idcliente:         $("#cmbcliente option:selected").val() ,
            idcontratante :    $("#cmbcontratante option:selected").val() ,
            idanno :           $("#cmbanno option:selected").val() ,
            idmes :            $("#cmbmes option:selected").val() ,
            idestatus :        $("#cmbestatus option:selected").val() 
        });
        return false;
    
    }
 

   
    $(document).ready(function(){   
        
        if(varCliente == -1){    
            $("#cmbcliente").load("<?php echo url_for('poblaconsol/getcliente') ?>");            
        }
        $().mCombo("#cmbcontratante", "<?php echo url_for('poblaconsol/getcontratante') ?>", "#cmbcliente");
        $().mCombo("#cmbanno", "<?php echo url_for('poblaconsol/getanno') ?>", "#cmbcontratante", "#cmbcliente");
        $().mCombo1("#cmbestatus", "<?php echo url_for('poblaconsol/getmes2') ?>", "#cmbanno", "#cmbcontratante", "#cmbcliente");
        $().mCombo3("#cmbmes", "<?php echo url_for('poblaconsol/getmes3') ?>", "#cmbestatus", "#cmbanno", "#cmbcontratante", "#cmbcliente");



//$().mCombo("#cmbmes", "<?php echo url_for('poblaconsol/getmes') ?>", "#cmbanno", "#cmbcontratante", "#cmbcliente");
        
        $("#btn_getvalues").click(function() {   
            cargarContenidoClik();            
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
