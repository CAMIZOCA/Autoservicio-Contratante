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
<!--                        <li><a href="#">Población</a></li>-->
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
                                        <option value="0">- Todos -</option>
                                        <option value="A">INCLUIDO</option>
                                        <option value="B">EXCLUIDO</option>
                                    </select> </td></tr>
                            <tr>
                            <tr>
                            <tr><td><input type="button" id="btn_getvalues"  class="btn_buscar" value="Buscar" /></td></tr>
                            </tr>
                        </table>
                    </form>

                    <div class="clear" style="padding-bottom:30px;"></div>
                    
                    
                    
                    <?php //echo $url = $_SERVER['REQUEST_URI'] . '&orderby=';    ?>
                    <div id="cargando" style="display: none;"><img src="/images/green-loading.gif" style="text-align: center" />&nbsp;</div>
                    <div id="showTable" name="show" ></div>
                    
<!--                    <iframe style="width: 100%;" src="http://autoservicio/altbamensua1?cmbcliente=293371&cmbcontratante=0&cmbanno=0&cmbestatus=0"></iframe> -->
                    





                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
            
        
        $("#cmbcliente").load("<?php echo url_for('poblaconsol/getcliente') ?>");            
        $().mCombo("#cmbcontratante", "<?php echo url_for('poblaconsol/getcontratante') ?>", "#cmbcliente" );
        $().mCombo("#cmbanno", "<?php echo url_for('poblaconsol/getanno') ?>", "#cmbcontratante", "#cmbcliente");

        
        $("#btn_getvalues").click(function() {   
            $("#form1").submit();
            return false;
        });	
        

    });
</script>

