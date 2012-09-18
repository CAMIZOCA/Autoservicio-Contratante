<?php use_helper('Number');
use_helper('Date');
?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php
//error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

function DiasHabiles($fecha_inicial, $fecha_final) {
    list($dia, $mes, $year) = explode("-", $fecha_inicial);
    $ini = mktime(0, 0, 0, $mes, $dia, $year);
    list($diaf, $mesf, $yearf) = explode("-", $fecha_final);
    $fin = mktime(0, 0, 0, $mesf, $diaf, $yearf);

    $r = 1;
    while ($ini != $fin) {
        $ini = mktime(0, 0, 0, $mes, $dia + $r, $year);
        $newArray[] .=$ini;
        $r++;
    }
    return $newArray;
}

function Evalua($arreglo) {
    $feriados = array(
        '1-1', //  Año Nuevo (irrenunciable)
        '6-4', //  Viernes Santo (feriado religioso)
        '7-4', //  Sábado Santo (feriado religioso)
        '1-5', //  Día Nacional del Trabajo (irrenunciable)
        '21-5', //  Día de las Glorias Navales
        '29-6', //  San Pedro y San Pablo (feriado religioso)
        '16-7', //  Virgen del Carmen (feriado religioso)
        '15-8', //  Asunción de la Virgen (feriado religioso)
        '18-9', //  Día de la Independencia (irrenunciable)
        '19-9', //  Día de las Glorias del Ejército
        '12-10', //  Aniversario del Descubrimiento de América
        '31-10', //  Día Nacional de las Iglesias Evangélicas y Protestantes (feriado religioso)
        '1-11', //  Día de Todos los Santos (feriado religioso)
        '8-12', //  Inmaculada Concepción de la Virgen (feriado religioso)
        '13-12', //  elecciones presidencial y parlamentarias (puede que se traslade al domingo 13)
        '25-12', //  Natividad del Señor (feriado religioso) (irrenunciable)
    );

    $j = count($arreglo);

    for ($i = 0; $i <= $j; $i++) {
        $dia = $arreglo[$i];

        $fecha = getdate($dia);
        $feriado = $fecha['mday'] . "-" . $fecha['mon'];
        if ($fecha["wday"] == 0 or $fecha["wday"] == 6) {
            $dia_++;
        } elseif (in_array($feriado, $feriados)) {
            $dia_++;
        }
    }
    $rlt = $j - $dia_;
    return $rlt;
}

function UltimoDia($anho, $mes) {
    if (((fmod($anho, 4) == 0) and (fmod($anho, 100) != 0)) or (fmod($anho, 400) == 0)) {
        $dias_febrero = 29;
    } else {
        $dias_febrero = 28;
    }
    switch ($mes) {
        case 01: return 31;
            break;
        case 02: return $dias_febrero;
            break;
        case 03: return 31;
            break;
        case 04: return 30;
            break;
        case 05: return 31;
            break;
        case 06: return 30;
            break;
        case 07: return 31;
            break;
        case 08: return 31;
            break;
        case 09: return 30;
            break;
        case 10: return 31;
            break;
        case 11: return 30;
            break;
        case 12: return 31;
            break;
    }
}

$CantidadDiasHabiles = Evalua(DiasHabiles($fecha_inicial, $fecha_final));


if ($cuantos_tabla_inicial != 0) {
    foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):

        $cantidad_total_casos = $cantidad_total_casos + $row_tabla['cantidad'];
        $monto_total = $monto_total + str_replace(",", ".", $row_tabla['TOTAL']);

    endforeach;
}


if ($cuantos_tabla_inicial != 0) {
    $costo_promedio_caso = ($monto_total / $cantidad_total_casos);
} else {
    $costo_promedio_caso = 0;
}

if ($cuantos_tabla_inicial != 0) {
    $promedio_casos_prov = ($cantidad_total_casos / $total_proveedores);
} else {
    $promedio_casos_prov = 0;
}

if ($cantidad > 1) {
    if ($contratante != 'todos') {

        $q_aten = Doctrine_Query::create()
                ->select('ci_paciente')
                ->from('SINIESTRALIDAD_VW J')
                ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_inicial','DD/MM/YYYY')  
                                                                and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_final','DD/MM/YYYY')
                                                                and idepol='$cliente' 
                                                                and INITCAP(tipo_des)='$tipo_ser'
                                                                and codexterno='$contratante'
                                                                and INITCAP(enfermedad)='$enfermedad'")
                ->groupBy('(ci_paciente, id)');
        // echo $q_aten."<br />";

        $q_aten->fetchArray();

        $atendidos = $q_aten->count();
    } else {
        $q_aten = Doctrine_Query::create()
                ->select('ci_paciente')
                ->from('SINIESTRALIDAD_VW   J')
                ->where(" to_date( to_char(fecnotif, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_inicial','DD/MM/YYYY')  
                                                                    and to_date( to_char(fecnotif, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_final','DD/MM/YYYY')
                                                                    and idepol='$cliente' 
                                                                    and INITCAP(tipo_des)='$tipo_ser'                                                                  
                                                                    and INITCAP(enfermedad)='$enfermedad'
                                                                  ")
                ->groupBy('(ci_paciente, id)');
        // echo $q_aten."<br />";

        $q_aten->fetchArray();

        $atendidos = $q_aten->count();
    }
}
$mes2 = $mes;
?>  


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
                        <li><a href="#">Siniestralidad</a></li>
                        <li class="last">Resumen Histórico de Siniestralidad</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle"> Resumen Histórico de Siniestralidad</h1>
                <div class="articleBox">
                    <form  target="#" id="form1" name="form1" >
                        <table>
<?php //echo $form;  ?>
                            <tr><td>Cliente: </td><td colspan="3"><select id="cliente" name="cliente" onChange="llenar_ano(this.value);">
                                    <option  value="-1"  selected="seleted" > -  Seleccione una opción - </option>
                                        <?php foreach ($ente_contratante_vw as $row): ?>
                                        <option value="<?php echo $row['idepol']; ?>" ><?php echo $row['descripcion']; ?></option>
                                    <?php endforeach; ?>

                                </select> </td></tr>
                       <!--   <tr><td>Contratante: </td><td colspan="3"><select id="contratante" name="contratante">
                                    <option value="todos" selected="selected" >Todos</option>
                            <?php foreach ($CONTRATO_POLIZA_VW as $row): ?>
                                        <option value="<?php echo $row['codctrocos']; ?>" <?php if ($contratante == $row['codctrocos']) { ?> selected="seleted" <?php } ?>><?php echo $row['desctrocos']; ?></option>
                            <?php endforeach; ?>

                                </select> </td></tr>-->
                            <tr><td>Año: </td><td colspan="3"><select id="ano" name="ano" onchange="llenar_mes(document.forms.form1.cliente.value,this.value);fechas_mes('document.forms.form1.mes.value,this.value');" disabled ="true">
                                    <option  value="-1"  selected="seleted" > -  Seleccione una opción - </option>
                                    <?php foreach ($CMB_ANO_GENERAL as $row): ?>
                                        <option value="<?php echo $row['ANOPARAM']; ?>" ><?php echo $row['ANOPARAM']; ?></option>
                                        <?php endforeach; ?>                                    
                                </select> </td></tr>
                            <tr><td >Mes: </td><td colspan="3">                          
                                <select id="mes"  name="mes" onchange="fechas_mes(this.value,document.forms.form1.ano.value,'<?php echo $es_bisiesto; ?>');eliminarPais(document.forms.form1.inicio.value,document.forms.form1.fin.value), num_dias(this.value,document.forms.form1.ano.value);" disabled ="true">
                                    <option  value="-1"  selected="seleted" > -  Seleccione una opción - </option>
                                    <option value="0" >Todos</option>                                    
                                    <option value="01" >Enero</option>
                                    <option value="02" >Febrero</option>
                                    <option value="03" >Marzo</option>
                                    <option value="04" >Abril</option>
                                    <option value="05" >Mayo</option>
                                    <option value="06" >Junio</option>
                                    <option value="07" >Julio</option>
                                    <option value="08" >Agosto</option>
                                    <option value="09" >Septiembre</option>
                                    <option value="10" >Octubre</option>
                                    <option value="11" >Noviembre</option>
                                    <option value="12" >Diciembre</option>

                                </select> 


                            </td>

                            </tr>
      
                            <tr>
                            <td>&NegativeMediumSpace;</td>
                            </tr>
                            <tr>
                            <td><input  type="button" id="btn_getvalues" class="btn_buscar"  value="Buscar" /></td>
                            </tr>
                            </tr>
                        </table>
                    </form>
                    <!-- INICIO -->
                    <div class="clear" style="padding-bottom:30px;"></div>
                    <div id="cargando" style="display: none;"><img src="/images/green-loading.gif" style="text-align: center" />&nbsp;</div>          
                    <div id="showTable" name="show" >  

                    </div>
                    <div class="clear" style="padding-bottom:30px;"></div>

                </div>    
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        
      

        $("#btn_getvalues").click(function() {
            /* $("#cargando").css("display", "inline");*/
            $("#showTable").load("<?php echo url_for('tralidadresumehistor/gettable') ?>",{ 
                cliente:         $("#cliente option:selected").val() ,               
                ano :           $("#ano option:selected").val() ,
                mes :            $("#mes option:selected").val()  
            });
            return false;
        });

	
    });
</script>
<script type="text/javascript">
    $("#url_imprime").click(function (){
        $("html").printArea();
    })
</script>
<script>
  
    function llenar_ano(a)
    {
        //alert("MIlaaaaaaaaaaaaaaaaaaaaaaaa"); 
        var n = document.forms.form1.ano.length;

        //alert(a);
        for (var i=0; i<n;++i){      
            document.forms.form1.ano.remove(document.forms.form1.ano.options[i]);//eliminar lineas del 2do combo...
        }
   
        document.forms.form1.ano[0]= new Option(" -  Seleccione una opción  - ",'-1');
        //document.forms.form1.ano[1]= new Option(" Todos ",'todos'); //creamos primera linea del segundo combo

 
<?php
foreach ($ente_contratante_vw as $row_c):
    $id_pol = $row_c['idepol'];
    ?> 
                               
    	   	
                     if (a== '<?php echo $id_pol; ?>'){

                         // alert("Milaaaaaaaaaaa holaaaaaaaa");
    <?php
    $query = "SELECT ANOPARAM FROM DISPONIBILIDAD_FONDO_VW  J where IDEPOL='$id_pol'
            GROUP BY ANOPARAM ORDER BY ANOPARAM ASC";
    $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
    $stmt2 = $pdo2->prepare($query);
    $stmt2->execute();
    $CMB_ANO_GENERAL = $stmt2->fetchAll();
    foreach ($CMB_ANO_GENERAL as $row_pf):
        $ANOPARAM = $row_pf['ANOPARAM'];
        ?>
                            document.forms.form1.ano[document.forms.form1.ano.length]= new Option("<?php echo $ANOPARAM; ?>",'<?php echo $ANOPARAM; ?>'); 
    <?php endforeach;
    ?>
                
                    }
<?php endforeach; ?>
 
                   document.getElementById('ano').disabled=false;
               }
 
               function llenar_mes(a,b)
               {
                   //alert("MIlaaaaaaaaaaaaaaaaaaaaaaaa"); 
                   var n = document.forms.form1.mes.length;

                   //alert(a);
                   for (var i=0; i<n;++i){      
                       document.forms.form1.mes.remove(document.forms.form1.mes.options[i]);//eliminar lineas del 2do combo...
                   }
   
                   document.forms.form1.mes[0]= new Option(" -  Seleccione una opción  - ",'-1');
                   document.forms.form1.mes[1]= new Option(" Todos ",'0'); //creamos primera linea del segundo combo

 
<?php
foreach ($ente_contratante_vw as $row_c):
    $id_pol = $row_c['idepol'];
    ?> 
                               
    	   	
                     if (a== '<?php echo $id_pol; ?>'){

                         //alert("id poliza");
    <?php
    $query = "SELECT ANOPARAM FROM DISPONIBILIDAD_FONDO_VW  J where IDEPOL='$id_pol'
            GROUP BY ANOPARAM ORDER BY ANOPARAM ASC";
    $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
    $stmt2 = $pdo2->prepare($query);
    $stmt2->execute();
    $CMB_ANO = $stmt2->fetchAll();
    foreach ($CMB_ANO as $row_pf):
        $ANOPARAM = $row_pf['ANOPARAM'];
        ?>
                            //alert(b);
                            if (b== '<?php echo $ANOPARAM; ?>'){
                
        <?php
        $query_mes = "SELECT MES, MESPARAM FROM DISPONIBILIDAD_FONDO_VW J where IDEPOL='$id_pol' AND 
             ANOPARAM='$ANOPARAM' ORDER BY MESPARAM ASC";
        $pdo_mes = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt_mes = $pdo_mes->prepare($query_mes);
        $stmt_mes->execute();
        $CMB_MES = $stmt_mes->fetchAll();
        foreach ($CMB_MES as $row_mes):
            $MES = $row_mes['MES'];
            $MESPARAM = $row_mes['MESPARAM'];
            ?>
                                        document.forms.form1.mes[document.forms.form1.mes.length]= new Option("<?php echo $MES; ?>",'<?php echo $MESPARAM; ?>'); 
        <?php endforeach;
        ?>
                                
                            }             
    <?php endforeach; ?>  
                       }
<?php endforeach; ?>
 
                   document.getElementById('mes').disabled=false;
               }
 

               function fechas_mes(a,y)
               {
<?php if (((fmod($ano2, 4) == 0) and (fmod($ano2, 100) != 0)) or (fmod($ano2, 400) == 0)) {
    $bi = 1;
} else {
    $bi = 0;
} ?>
            if (a=='0'){
                document.forms.form1.inicio.value="01-1-"+y;
                document.forms.form1.fin.value="31-12-"+y;
            }

            if (a=='01'){
                document.forms.form1.inicio.value="1-1-"+y;
                document.forms.form1.fin.value="31-1-"+y;
            }
            if (a=='02'){
                document.forms.form1.inicio.value="1-2-"+y;
                if(<?php echo $bi ?>==1){ document.forms.form1.fin.value="29-2-"+y;}
                else{ document.forms.form1.fin.value="28-2-"+y;}
       
            }
            if (a=='03'){
                document.forms.form1.inicio.value="1-3-"+y;
                document.forms.form1.fin.value="31-3-"+y;
            }
      
            if (a=='04'){
                document.forms.form1.inicio.value="1-4-"+y;
                document.forms.form1.fin.value="30-4-"+y;
            }
            if (a=='05'){
                document.forms.form1.inicio.value="1-5-"+y;
                document.forms.form1.fin.value="31-5-"+y;
            }
            if (a=='06'){
                document.forms.form1.inicio.value="1-06-"+y;
                document.forms.form1.fin.value="30-6-"+y;
            }
            if (a=='07'){
                document.forms.form1.inicio.value="1-7-"+y;
                document.forms.form1.fin.value="31-7-"+y;
            }
            if (a=='08'){
                document.forms.form1.inicio.value="1-8-"+y;
                document.forms.form1.fin.value="31-8-"+y;
            }
            if (a=='09'){
                document.forms.form1.inicio.value="1-9-"+y;
                document.forms.form1.fin.value="30-9-"+y;
            }
            if (a=='10'){
                document.forms.form1.inicio.value="1-10-"+y;
                document.forms.form1.fin.value="31-10-"+y;
            }
            if (a=='11'){
                document.forms.form1.inicio.value="1-11-"+y;
                document.forms.form1.fin.value="30-11-"+y;
            }
            if (a=='12'){
                document.forms.form1.inicio.value="1-12-"+y;
                document.forms.form1.fin.value="31-12-"+y;
            }
        }
</script>
