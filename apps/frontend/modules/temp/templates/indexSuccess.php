<?php
$var = "--<img src='./uploads/tmp/5006c3b9c7125.png' />--";
    $content = "
hola mudno";

    require_once('./html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','es');
    $html2pdf->WriteHTML($var);
     $html2pdf->Output('nombre_del_documento.pdf', 'D'); 
?>