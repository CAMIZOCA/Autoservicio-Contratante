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
                        <li><a href="#">Población</a></li>
                        <li class="last">Población búsqueda general</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Población búsqueda general</h1>
                <div class="articleBox">
                    <form target="#" id="form1" >


                        <table>
                            <tr><td>Cliente: </td><td style="width: 450px"><select name="cmbcliente" id="cmbcliente"></select></td></tr>
                            <tr><td>Contratante: </td><td><select name="cmbcontratante" id="cmbcontratante"></select></td></tr>                            
                            <tr><td>Año: </td><td><select name="cmbanno" id="cmbanno"></select></td></tr>
                            <tr><td>Mes: </td><td><select name="cmbmes" id="cmbmes"></select></td></tr>
                            <tr><td>Estatus: </td><td>
                                    <select id="cmbestatus">
                                        <option value="ACT">Activo</option>
                                        <option value="EXC">Excluido</option>
                                        <option value="ANU">Anulado</option>                                  
                                    </select> </td>
                            </tr>
                            
                            <tr>
                                <td>C.I. de afiliados: </td>
                                <td><input type="text" id="txtcedula" name="txtcedula" value="" /></td>
                            </tr>

                            <tr>
                                <td>Nombre de afiliados: </td>
                                <td><input type="text" id="txtcedula" name="txtcedula" value="" /></td>
                            </tr>
                            
                            <tr>
                                <td>Fecha de Exlusion: </td><td> <input type="text" id="txtcedula" name="txtcedula" value="12/12/2011" /></td> </tr>
                            <tr>

<tr><td><input  type="button" id="btn_getvalues" class="btn_buscar" value="Buscar" /></td></tr>

                        </table>
                    </form>

                    <!-- INICIO -->
                    <div class="clear" style="padding-bottom:30px;"></div>

                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />
                    <div id="showTable" name="show" >
                    </div>
                    
                    <!-- FIN DEL BACKEND -->

                    <div class="clear" style="padding-bottom:30px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$("#url_imprime").click(function (){
$("html").printArea();
})

</script>


<script type="text/javascript">
    $(function() {
        
        //sdsd
        $("#cmbcliente").jCombo("<?php echo url_for('poblaconsol/getcliente') ?>");        
        $("#cmbcontratante").jCombo("<?php echo url_for('poblaconsol/getcontratante?id=') ?>", { parent: "#cmbcliente"});
        $("#cmbanno").jCombo("<?php echo url_for('poblaconsol/getanno?contratante=') ?>", { parent: "#cmbcontratante"});        
        $("#cmbmes").jCombo("<?php echo url_for('poblaconsol/getmes?contratante=') ?>", { parent: "#cmbcontratante"});
//$("#cmbmes").jCombo("<?php echo url_for('poblaconsol/getmes') ?>");


        $("#btn_getvalues").click(function() {
            $("#cargando").css("display", "inline");
            $("#showTable").load("<?php echo url_for('poblabusgen/gettable') ?>",{ 
                idcliente:         $("#cmbcliente option:selected").val() ,
                idcontratante :    $("#cmbcontratante option:selected").val() ,
                idanno :           $("#cmbanno option:selected").val() ,
                idmes :            $("#cmbmes option:selected").val() ,
                idestatus :        $("#cmbestatus option:selected").val() 
            });
            return false;
        });

	
    });
</script>