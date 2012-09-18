<?php
if ($_POST['text'] == '') {
    echo "Los datos no pudieron ser procesados";
    exit;
} else {
    $tituloPdf = $_POST['titulo_pdf'];
    $textoPdf = $_POST['text'];
}
require_once("uploads/dompdf_config.inc.php");
spl_autoload_register('DOMPDF_autoload');
ob_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF8">
    </head>
    <style type="text/css">
        body{
            font-size:9px;
        }
        .tableSector {
            /*           border-collapse:collapse;    */
            text-align:left;
            margin-bottom:20px;
            border:1px #eee solid;

        }

        .tableSector thead {
/*            background-color: #0D8661;*/
            height: 25px;  
            text-align: center;
/*            background-image: url("/images/sideBar_coursesMenuBox_titleBackground.png");*/
        }

        .tableSector thead th {
            padding-left: 3px;
            padding-right: 3px;
            text-align: center;
            border:1px #ffffff solid;        
            border-top: 2px #04493A solid;
            font-size: 1.2em;
        }

        .tableSector thead th:hover {
/*            background-color: #0B7857;*/
        }

        .tableSector thead th a {
            /*            color:#ffffff;*/
            text-decoration: none;
        }

        .tableSector thead tr {
            /*            color: #ffffff;    */
        }

        .alignRight{    
            text-align: right;    
            padding-right: 10px;
            padding-lef: 10px;
        }

        .tableSector tbody {
            border-bottom:1px #CCCCCC solid;
            /*            width:600px;*/

        }

        .tableSector tbody tr:hover {
/*            background-color: #E7F1ED;*/
        }
        .tableSector td {
            border:1px #eee solid;
            font-size: 1.2em;
        }

        .tableSector tbody .botonadd{
            padding:5px 5px 5px 7px;
            background-color:#FFF;
            border:0px #008265 solid;
            cursor:pointer;
            background-image:url('/images/icon_add_down.png');
            width: 20px;
            height: 20px;
            background-position:left bottom;
            background-repeat:no-repeat;
        }	

        .tableSector tbody .botonadd:hover {
            padding:5px 5px 5px 7px;
            background-color:#FFF;
            border:0px #008265 solid;
            cursor:pointer;
            background-image:url('../images/icon_add_up.png');
            width: 20px;
            height: 20px;
            background-position:left bottom;
            background-repeat:no-repeat;
        }	


        .tableSector tfoot {
            font-weight: bold;
            background-color: #DAE5EE;
        }/**/

        h1.articleTitle {
            font-size:1.2em;
            font-weight:bold;
            color:#007a5e;
            width:100%;
            padding:0;
            margin:0 0 15px 0;
        }

        .titulo_detalle{
            background-color: #0D8661;   
            height: 25px;
            padding-left:20px;  
            color:#ffffff;
            font-weight: bold;
        }

        .titulo_menor_detalle{
            font-weight: bold;
        }


        .cajas_totales{
            height:100px;; 
            margin-top:10px; 
            margin-bottom:10px;


        }
        .cajitas_peq_totales{
            width:220px; 
            border:solid #007a5e 1px;    
            float:left; 
            font-family:Arial, Helvetica, sans-serif; 
            font-size:12px;
        }

        .linea{
            height:30px;
            padding:5px;
        }
        .linea_media{
            height:30px;
            padding:5px;
            border-top:solid #007a5e 1px;
        }
        .titulo_cajita{

            color:#333; 
            font-weight:bold;
        }

        .total_bs{  
            text-align: right;    
            padding-right: 10px;
            float:left;     
            width:50px;
        }
        .cajitas_peq_totales_med{
            width:100px;
            border:solid #007a5e 1px; 
            margin-left:20px; 
            float:left; 
            font-family:Arial, Helvetica, sans-serif; 
            font-size:12px;
        }

        .titulo_cajita_med{
            float:left; 
            height:20px; 
            width:100px; 
            color:#333; 
            font-weight:bold;
        }

        .total_bs_med{  
            text-align: right;    
            padding-right: 10px;
            float:left;   
            width:60px;
        }

    </style>

    <body>

        <img src="./images/logohmo.png"/><br />       

        <h1 class="articleTitle"><?php echo $tituloPdf; ?></h1> <br />
        <?php echo $textoPdf; ?><br />
        <?php if ($imgBase64 <> '') { ?>        
            <img src="<?php echo $imgBase64; ?>"/><br />      
        <?php } ?>

    </body> 
</html>
<?php



$var = ob_get_clean();


if (!$imgBase64) {

   
   //genero pdf
    $dompdf = new DOMPDF();
    if(trim($tituloPdf)=='Resumen Histórico'){
    $dompdf ->set_paper('letter', 'landscape');
    }

    $dompdf->load_html($var);
    $dompdf->render();

    $dompdf->stream("reporte.pdf", array("Attachment" => 0));
    $dompdf->stream("reporte.pdf");

}else{

    require_once('./html2pdf/html2pdf.class.php');
    //$html2pdf = new HTML2PDF('p', 'A4', 'es', array(50, 50, 50, 50));
    $html2pdf = new HTML2PDF('L', 'A4', 'es', array(50, 50, 50, 50));
    $html2pdf->WriteHTML($var);
    $html2pdf->Output('nombre_del_documento.pdf', 'D');

}



?>


