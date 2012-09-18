<!-- Pagina que captura el valor text que es un html y genera el pdf-->

<?php use_helper('Number') ?> 
<?php use_helper('Date'); ?>   


<?php
//print_r($_POST);
//    exit;
if ($sql_pdf == '') {
    echo "Los datos no pudieron ser procesados";
    exit;
} else {
    $tituloPdf = $_POST['titulo_pdf'];
    $sql_pdf = $_POST['sql_pdf'];
}
require_once("./uploads/dompdf_config.inc.php");
spl_autoload_register('DOMPDF_autoload');
ob_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
   <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF8">

        <script type="text/javascript" src="/js/jquery-1.6.min.js"></script>
        <script type="text/javascript" src="/js/jquery.PrintArea.js"></script>
        <script type="text/javascript" src="/js/jquery.ez-pinned-footer.js" charset="utf-8"></script>
        <link rel="stylesheet" href="/css/print.css" type="text/css" media="print" />
        <style>
            body {
                margin: 0px;
                padding: 0px;
            }
            #footer {
                padding: 20px;
                background-color: #0D8661;
                color: #fff;
                font-size: 12px;
            }
            a{
                color: #fff;
            }
        </style>

        <script>
            $(window).load(function() {
                $("#footer").pinFooter();
            });

            $(window).resize(function() {
                $("#footer").pinFooter();
            });
        </script>
    </head>


    <style type="text/css">
        body{font-size:9px}.tableSector{border-collapse:collapse;text-align:left;margin-bottom:20px;border:1px #eee solid}.tableSector thead{background-color:#0D8661;height:25px;text-align:center;background-image:url("/images/sideBar_coursesMenuBox_titleBackground.png")}.tableSector thead th{padding-left:3px;padding-right:3px;text-align:center;border:1px #fff solid;border-top:2px #04493A solid;font-size:1.2em}.tableSector thead th:hover{background-color:#0B7857}.tableSector thead th a{color:#fff;text-decoration:none}.tableSector thead tr{color:#fff}.alignRight{text-align:right;padding-right:10px;padding-lef:10px}.tableSector tbody{border-bottom:1px #CCC solid;width:600px}.tableSector tbody tr:hover{background-color:#E7F1ED}.tableSector td{border:1px #eee solid;font-size:1.2em}.tableSector tbody .botonadd{padding:5px 5px 5px 7px;background-color:#FFF;border:0 #008265 solid;cursor:pointer;background-image:url('/images/icon_add_down.png');width:20px;height:20px;background-position:left bottom;background-repeat:no-repeat}.tableSector tbody .botonadd:hover{padding:5px 5px 5px 7px;background-color:#FFF;border:0 #008265 solid;cursor:pointer;background-image:url('../images/icon_add_up.png');width:20px;height:20px;background-position:left bottom;background-repeat:no-repeat}.tableSector tfoot{font-weight:700;background-color:#DAE5EE}h1.articleTitle{font-size:1.2em;font-weight:700;color:#007a5e;width:100%;padding:0;margin:0 0 15px}.titulo_detalle{background-color:#0D8661;height:25px;padding-left:20px;font-family:arial;color:#fff;font-weight:700}#detalle td{text-align:left;padding-left:15px;height:25px;padding-right:15px}.titulo_menor_detalle{font-weight:700}.cajas_totales{height:100px;margin-top:10px;margin-bottom:10px}.cajitas_peq_totales{width:220px;border:solid #007a5e 1px;float:left;font-family:Arial, Helvetica, sans-serif;font-size:12px}.linea{height:30px;padding:5px}.linea_media{height:30px;padding:5px;border-top:solid #007a5e 1px}.titulo_cajita{color:#333;font-weight:700}.total_bs{text-align:right;padding-right:10px;float:left;width:50px}.cajitas_peq_totales_med{width:100px;border:solid #007a5e 1px;margin-left:20px;float:left;font-family:Arial, Helvetica, sans-serif;font-size:12px}.titulo_cajita_med{float:left;height:20px;width:100px;color:#333;font-weight:700}.total_bs_med{text-align:right;padding-right:10px;float:left;width:60px}                
    </style>

    <body>

       <img src="../../images/logohmo.png"/><br />



        <h1 class="articleTitle"><?php echo $tituloPdf; ?></h1> <br />


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
                foreach ($registros as $row):
                    ?>
                    <tr>      
                        <td><input class="botonadd" type="button" onclick="location.href='<?php echo url_for("poblaficha/index?idcliente=" . $_GET['cmbcliente'] . "&idcontratante=" . $_GET['cmbcontratante'] . "&idcertificado=" . $row['CERTIFICADO'] . "") ?>'" /><?php echo $row['CONTRATO']; ?></td>
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
        <div id="footer">
                <div>
                    <button href="javascript:void(0)" id="url_imprime" >Imprimir</button>
                    <button href="javascript:void(0)" id="cerrar" >cerrar</button>
                </div>
            </div> 
    </body> 
</html>

<?php
echo $var = ob_get_clean();
?>

<script type="text/javascript">
    $("#url_imprime").click(function (){
        $("html").printArea();
    })
    $("#cerrar").click(function (){
        window.close();
    })   
    
</script>