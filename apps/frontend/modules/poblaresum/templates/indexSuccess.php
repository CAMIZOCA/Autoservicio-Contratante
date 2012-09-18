<?php use_helper('Number') ?> 
<?php use_helper('Date'); ?>
<?php $sf_user->setCulture('es_VE') ?>
<script type='text/javascript'>
    google.load('visualization', '1', {packages:['table']});
    google.setOnLoadCallback(drawTable);
    function drawTable() {
        // Version 1: arrayToDataTable method
        var data2 = google.visualization.arrayToDataTable([
            ['Afiliado','C.I.','Contrato','Fecha Ingreso','Plazo de espera','Parentesco','Sexo','Edad'],
<?php
foreach ($registros as $row):
    ?>
                    [   '<?php echo $row['NOMBRE']; ?>',
                        '<?php echo $row['CEDULA']; ?>',
                        '<?php echo $row['IDEPOL']; ?>',
                        '<?php echo format_date($row['FECING'], 'dd-MM-y'); ?>',
                        '<?php echo $row['PLAZO_ESPERA']; ?>',
                        '<?php echo $row['PARENTESCO_CROSS']; ?>',
                        '<?php echo $row['SEXO_PARENTESCO']; ?>',
                        '<?php echo $row['EDAD']; ?>'],
    <?php
endforeach;
?>
  
        ]);



        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data2, {showRowNumber: true});
        
        
        google.visualization.events.addListener(table, 'select', selectHandler);


        function selectHandler() {
            var selection = table.getSelection();
            var message = '';
            for (var i = 0; i < selection.length; i++) {
                var item = selection[i];
                if (item.row != null && item.column != null) {
                    var str = data.getFormattedValue(item.row, item.column);
                    message += '{row:' + item.row + ',column:' + item.column + '} = ' + str + '\n';
                } else if (item.row != null) {
                    var str = data.getFormattedValue(item.row, 0);
                    message += '{row:' + item.row + ', column:none}; value (col 0) = ' + str + '\n';
                } else if (item.column != null) {
                    var str = data.getFormattedValue(0, item.column);
                    message += '{row:none, column:' + item.column + '}; value (row 0) = ' + str + '\n';
                }
            }
            if (message == '') {
                message = 'nothing';
            }
            alert('You selected ' + message);

        }
    }
</script>


<script type="text/javascript">
    google.load('visualization', '1', {'packages' : ['table']});
    google.setOnLoadCallback(init);

    var dataSourceUrl = 'https://spreadsheets.google.com/tq?key=rh_6pF1K_XsruwVr_doofvw&pub=1';
    var query, options, container;

    function init() {
        query = new google.visualization.Query(dataSourceUrl);
        container = document.getElementById("table");
        options = {'pageSize': 5};
        sendAndDraw();
    }

    function sendAndDraw() {
        query.abort();
        var tableQueryWrapper = new TableQueryWrapper(query, container, options);
        tableQueryWrapper.sendAndDraw();
    }

    function setOption(prop, value) {
        options[prop] = value;
        sendAndDraw();
    }

</script>


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
                        <li><a href="<?php echo $url_atras; ?>"><?php echo $tituloModulo; ?></a></li>
                        <li class="last">Resumen de población</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Resultado</h1>
                <div class="articleBox">
                    <?php include_partial('poblaresum/list', array('registros' => $registros, 'totalRegistros' => $totalRegistros, 'url_atras' => $url_atras)) ?>
                    <!-- Formulario oculto para crear pdf-->
                    <form method="post" id="targetpdf" action="<?php echo url_for('poblaresum/listpdf') ?>" target="_blank" hidden="hidden" >
                        <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Resumen Población" />
                        <textarea id="sql_pdf" name="sql_pdf" rows="2" cols="20"  ><?php echo $sqlpdf; ?></textarea>
                    </form>
                    <form method="post" id="targetprint" action="<?php echo url_for('poblaresum/listprint') ?>" target="_blank" hidden="hidden" >
<!--                    <form method="post" id="targetprint" action="<?php echo url_for('poblaresum/listprint') ?>" target="_blank"  >                        -->
                        <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Resumen Población" />
                        <textarea id="sql_print" name="sql_print" rows="2" cols="20"  ><?php echo $sqlpdf; ?></textarea>
                    </form>


                    <form method="post" id="targetexcel" action="<?php echo url_for('poblaresum/listexcel') ?>" target="_blank" hidden="hidden" >
                        <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Resumen Población" />
                        <textarea id="sql_pdf" name="sql_pdf" rows="2" cols="20"  ><?php echo $sqlpdf; ?></textarea>
                    </form>

                    <!-- Formulario oculto para crear excel-->
                    <form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
                        <input id="titulo"  name="titulo" type="text" value="Resumen Población" />
                        <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
                    </form>
                    <!-- fin-->
                </div>
            </div>
        </div>
    </div>
</div>
