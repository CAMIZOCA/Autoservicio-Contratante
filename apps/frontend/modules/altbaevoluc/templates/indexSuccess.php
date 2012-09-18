<?php use_helper('Date'); ?>
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
                        <!--                        <li><a href="#">Altas y Bajas</a></li>-->
                        <li class="last">Evolución</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Evolución</h1>
                <div class="articleBox">
                    <form target="#" id="form1" >
                        <input id="get_idcliente" type="text" value="<?php echo $_GET['idcliente']; ?>" />
                        <input id="get_idcontratante" type="text" value="<?php echo $_GET['idcontratante']; ?>" />
                        <input id="get_idanno" type="text" value="<?php echo $_GET['idanno']; ?>" />

                        <table>
                            <tr><td>Cliente: </td><td><select name="cmbcliente" id="cmbcliente"></select></td></tr>
                            <tr><td>Contratante: </td><td><select name="cmbcontratante" id="cmbcontratante"></select></td></tr>
                            <tr><td>Año: </td><td><select name="cmbanno" id="cmbanno"></select></td></tr>
                            <tr>
                            <tr><td><input type="button" id="btn_getvalues" class="btn_buscar" value="Buscar" /></td></tr>
                            </tr>
                        </table>
                    </form>

                    <div class="clear" style="padding-bottom:30px;"></div>
                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />
                    <div id="cargando" style="display: none;"><img src="/images/green-loading.gif" style="text-align: center" />&nbsp;</div>
                    <div id="showTable" name="show" ></div>
                    <div class="clear" style="padding-bottom:30px;"></div>



                </div></div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">




  
    var varCliente = <?php echo $result = ($var_idcliente == '') ? $var_cero : $var_idcliente; ?>;
    var varContratante = '<?php echo $result = ($var_idcontratante == '') ? $var_cero : $var_idcontratante; ?>';
    var varAnno = <?php echo $result = ($var_idanno == '') ? $var_cero : $var_idanno; ?>;
    
   
    
    if(varCliente > -1){
        $("#cmbcliente").load("<?php echo '/poblaconsol/getclientewhere?id=' . $var_idcliente; ?>");
    }
    
    if(varContratante != -1){
        $("#cmbcontratante").load("<?php echo '/poblaconsol/getcontratante?idepol=' . $var_idcliente . '&cmbcontratante=' . $var_idcontratante; ?>");
    }
    
    if(varAnno > -1){
        $("#cmbanno").load("<?php echo '/poblaconsol/getanno?idepol=' . $var_idcliente . '&cmbcontratante=' . $var_idcontratante . '&cmbanno=' . $var_idanno; ?>");
        cargarContenido();
    }
    

    function cargarContenido(){

        $("#cargando").css("display", "inline");
        $("#showTable").load("<?php echo url_for('altbaevoluc/gettable') ?>",{ 
            idcliente:         $("#get_idcliente").val() ,
            idcontratante :    $("#get_idcontratante").val() ,
            idanno :           $("#get_idanno").val() 
        });
        return false;
        
    }
    function cargarContenidoClik(){
        
        $("#cargando").css("display", "inline");
        $("#showTable").load("<?php echo url_for('altbaevoluc/gettable') ?>",{ 
            idcliente:         $("#cmbcliente option:selected").val() ,
            idcontratante :    $("#cmbcontratante option:selected").val() ,
            idanno :           $("#cmbanno option:selected").val() 
        });
        return false;
    
    }
 

    
   
   
   
   
   
    $(document).ready(function(){   
        
        if(varCliente == -1){    
            $("#cmbcliente").load("<?php echo url_for('poblaconsol/getcliente') ?>");            
        }
        $().mCombo("#cmbcontratante", "<?php echo url_for('poblaconsol/getcontratante') ?>", "#cmbcliente");
        $().mCombo("#cmbanno", "<?php echo url_for('poblaconsol/getanno') ?>", "#cmbcontratante", "#cmbcliente");
        $().mCombo("#cmbmes", "<?php echo url_for('poblaconsol/getmes') ?>", "#cmbanno", "#cmbcontratante", "#cmbcliente");

        
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
    


    //    $(document).ready(function(){
    //            
    //        
    //        $("#cmbcliente").load("<?php echo url_for('poblaconsol/getcliente') ?>");            
    //        $().mCombo("#cmbcontratante", "<?php echo url_for('poblaconsol/getcontratante') ?>", "#cmbcliente" );
    //        $().mCombo("#cmbanno", "<?php echo url_for('poblaconsol/getanno') ?>", "#cmbcontratante", "#cmbcliente");
    //
    //        $("#btn_getvalues").click(function() {   
    //            
    //            $("#cargando").css("display", "inline");
    //            $("#showTable").load("<?php echo url_for('altbaevoluc/gettable') ?>",{ 
    //                idcliente:         $("#cmbcliente option:selected").val() ,
    //                idcontratante:     $("#cmbcontratante option:selected").val() ,
    //                idanno:            $("#cmbanno option:selected").val() ,
    //                idestatus:         $("#cmbestatus option:selected").val() ,
    //                idpoblacion:       $("#cmbpoblacion option:selected").val() 
    //            });
    //          
    //            return false;
    //        });	
    //        
    //
    //    });
</script>

