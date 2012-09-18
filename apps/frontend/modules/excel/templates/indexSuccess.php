<?php
if ($_POST['text'] == '') {
    echo "Los datos no pudieron ser procesados";
    exit;
} else {
    $tituloPdf = $_POST['titulo'];
    $textoPdf = $_POST['text'];
}
ob_start();
?>
<!DOCTYPE html>
<html>    
    <head>
        <meta charset="UTF-8" />
    </head>
    <body>
        <h1 class="articleTitle"><?php echo $tituloPdf; ?></h1> <br />
        <?php echo $textoPdf; ?><br />
        <?php if ($imgBase64 <> '') { ?>        
            <img src="<?php echo $imgBase64; ?>"/><br />      
        <?php } ?>
    </body> 
</html>
<?php
echo $var = ob_get_clean();
?>


