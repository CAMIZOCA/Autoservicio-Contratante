<?php
use_helper('Number');
use_helper('Date');
?> 
<?php $sf_user->setCulture('es_VE') ?>
<?php
error_reporting(E_ALL & ~E_NOTICE);
?>  

<div id="mainContentSector"><!--end innerwrap--> 
    <div id="innerwrap"> 
        <div id="sideBar">
            <!-- MODULO ACTIVO -->
            <?php //include('_modActivo.php');  ?>
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
                        <li><a href="#">Siniestros</a></li>
                        <li class="last"><?php
            if ($clase_lis == 1) {
                echo "Reclamos por tipo de servicio";
            } elseif ($clase_lis == 2 or $clase_lis == 3) {
                echo "Listado de Proveedores";
            } elseif ($tipo_lis == 3) {
                echo "Listado de Patologías";
            } elseif ($clase_lis == 4 or $clase_lis == 5) {
                echo "Listado de Patologías";
            } elseif ($tipo_lis == 3) {
                echo "Listado de Patologías";
            }
            ?></li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">Consulta Reclamo</h1>
                <div class="articleBox">
                    <!-- INICIO -->
                    <div class="clear" style="padding-bottom:30px;"></div>


                    <div id="showTable" name="show" > 
                        <!-- INICIO PANTALLAS BACKEND -->

                        <?php
                        foreach ($SINIESTRALIDAD_VW_tabla_inicial as $row_tabla):

                            $id_prov = $row_tabla['COD_BEN_PAGO'];
                            $nombre_prov = $row_tabla['BEN_PAGO'];
                            $ci_paciente = $row_tabla['CI_PACIENTE'];
                            $paciente = $row_tabla['PACIENTE'];
                            $PARENTESCO = $row_tabla['PARENTESCO'];
                            $CONTRATANTE = $row_tabla['CONTRATANTE'];

                            $tipo_des = $row_tabla['TIPO_DES'];
                            $CI_TITULAR = $row_tabla['CI_TITULAR'];
                            $TITULAR = $row_tabla['TITULAR'];
                            $rif = $row_tabla['RIF'];
                            $FECOCURR = date('d/m/Y', strtotime($row_tabla['FECOCURR']));
                            $FECNOTIF = date('d/m/Y', strtotime($row_tabla['FECNOTIF']));
                            $INDEMNIZADO = $row_tabla['INDEMNIZADO'];
                            $facturado = $row_tabla['FACTURADO'];
                            $TIPO_PLAN = $row_tabla['TIPO_PLAN'];
                            $enfermedad = $row_tabla['ENFERMEDAD'];
                            $tratamiento = $row_tabla['TRATAMIENTO'];
                            $COD_BEN_PAGO = $row_tabla['COD_BEN_PAGO'];
                            $BEN_PAGO = $row_tabla['BEN_PAGO'];

                        /* SELECT COD_BEN_PAGO, INITCAP(BEN_PAGO) as BEN_PAGO, INITCAP(CONTRATANTE) as CONTRATANTE, CI_PACIENTE, PACIENTE, INITCAP(TIPO_DES) as TIPO_DES,INITCAP(PARENTESCO) as PARENTESCO, 
                          CI_TITULAR,INITCAP(TITULAR) as TITULAR, RIF, FECOCURR, INDEMNIZADO, COD_BEN_PAGO, INITCAP(BEN_PAGO) AS BEN_PAGO, INITCAP(ENFERMEDAD) AS ENFERMEDAD,
                          INITCAP(TRATAMIENTO) AS TRATAMIENTO, FACTURADO, INITCAP(COBER_SIN) AS TIPO_PLAN,FECNOTIF */

                        endforeach;
                        ?> 
                        <!-- INICIO GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->

                        <!-- FIN-->   
                        <?php
                        ob_start();
                        ?>
                        <table class="tableSector" >

                            <tbody> 
                                <tr class="titulo_detalle">
                                <td colspan="6" class="titulo_detalle"  ><div style="color:#ffffff;">CONTRATANTE</div></td>
                                </tr>
                                <tr>
                                <td colspan="6"><?php echo $CONTRATANTE; ?></td>
                                </tr >

                                <tr>
                                <td colspan="6">&nbsp;</td>
                                </tr>
                                <tr class="titulo_detalle">
                                <td colspan="6" class="titulo_detalle"><div style="color:#ffffff;">TITULAR</div></td>
                                </tr>
                                <tr>
                                <td class="titulo_menor_detalle">Cédula/ Rif:</td>
                                <td ><?php echo $CI_TITULAR; ?></td>
                                <td  class="titulo_menor_detalle" >Nombre:</td>
                                <td colspan="3"><?php echo utf8_decode($TITULAR); ?></td>
                                </tr>
                                <tr>
                                <td colspan="6">&nbsp;</td>
                                </tr>
                                <tr class="titulo_detalle">
                                <td colspan="6" class="titulo_detalle"><div style="color:#ffffff;">AFILIADO</div></td>
                                </tr>
                                <tr>
                                <td class="titulo_menor_detalle">Cédula/ Rif:</td>
                                <td><?php echo $ci_paciente; ?></td>
                                <td class="titulo_menor_detalle">Nombre:</td>
                                <td colspan="3"  ><?php echo $paciente; ?></td>

                                </tr>
                                <tr>
                                <td class="titulo_menor_detalle">Parentesco:</td>
                                <td><?php echo $PARENTESCO; ?></td>
                                <td class="titulo_menor_detalle">Estatus:</td>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                <td colspan="6">&nbsp;</td>
                                </tr>
                                <tr class="titulo_detalle" >
                                <td colspan="6" class="titulo_detalle" ><div style="color:#ffffff;">DATOS DEL RECLAMO</div></td>
                                </tr>

                                <tr>
                                <td class="titulo_menor_detalle">Nº del Reclamo:</td>
                                <td>&nbsp;</td>
                                <td class="titulo_menor_detalle">Nº Servicio</td>
                                <td>&nbsp;</td>
                                <td class="titulo_menor_detalle" >Tipo Servicio:</td>
                                <td width="30" ><?php echo $tipo_des; ?></td>
                                </tr>
                                <tr>
                                <td class="titulo_menor_detalle"  >Tipo de Plan:</td>
                                <td><?php echo $TIPO_PLAN; ?></td>
                                <td class="titulo_menor_detalle" width="30" >Nº Aval/Clave </td>
                                <td>&nbsp;</td>
                                <td class="titulo_menor_detalle" >Forma de Pago:</td>
                                <td>&nbsp;</td>
                                </tr>
                                <tr>
                                <td class="titulo_menor_detalle" >Beneficiario Pago:</td>
                                <td><?php echo $BEN_PAGO; ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                <td class="titulo_menor_detalle" >Descripción:</td>
                                <td><?php echo $BEN_PAGO; ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                <td class="titulo_menor_detalle" >Centro Clínico:</td>
                                <td><?php echo $BEN_PAGO; ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                <td class="titulo_menor_detalle" >Fecha Recepción:</td>
                                <td><?php echo $FECNOTIF; ?></td>
                                <td class="titulo_menor_detalle" width="70"  >Fecha Ocurrencia:</td>
                                <td><?php echo $FECOCURR; ?></td>
                                <td width="119" class="titulo_menor_detalle" >Fecha Ingreso:</td>
                                <td width="173"><?php echo $FECOCURR; ?></td>
                                </tr>
                                <tr>
                                <td class="titulo_menor_detalle" >Fecha Egreso:</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                <td colspan="6">&nbsp;</td>
                                </tr>
                                <tr class="titulo_detalle">
                                <td colspan="6" class="titulo_detalle"><div style="color:#ffffff;">DATOS DE LA PATOLOGÍA</div></td>
                                </tr>
                                <tr>
                                <td class="titulo_menor_detalle">Nombre de la Patología:</td>
                                <td><?php echo $enfermedad; ?></td>
                                <td class="titulo_menor_detalle">Tratamiento:</td>
                                <td colspan="3"><?php echo $tratamiento; ?></td>

                                </tr>
                                <tr class="">
                                <td colspan="6" class="">&nbsp;</td>
                                </tr>
                                <tr class="titulo_detalle">
                                <td colspan="6" class="titulo_detalle"><div style="color:#ffffff;">MONTOS DEL RECLAMO</div></td>
                                </tr>

                                <tr>
                                <td class="titulo_menor_detalle" >Monto Facturado:</td>
                                <td class="alignRight"><?php echo format_number($facturado); ?></td>
                                <td class="titulo_menor_detalle" >Gastos no Amparados:</td>
                                <td width="50" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td class="titulo_menor_detalle" >Total Elegible:</td>
                                <td width="50" class="alignRight"  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                <td class="titulo_menor_detalle" >Deducible:</td>
                                <td class="alignRight"><?php echo format_number($INDEMNIZADO); ?></td>
                                <td class="titulo_menor_detalle" >Sub-Total:</td>
                                <td class="alignRight">&nbsp;</td>
                                <td class="titulo_menor_detalle" >% de Reembolso:</td>
                                <td>&nbsp;&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                <td class="titulo_menor_detalle" >Total a pagar:</td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td class="titulo_menor_detalle" >Desc. Neto:</td>
                                <td class="alignRight">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td class="titulo_menor_detalle" >Monto Pagado:</td>
                                <td class="alignRight">&nbsp;</td>
                                </tr>
                                <tr>
                                <td >&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr class="titulo_detalle">
                                <td colspan="6" class="titulo_detalle" ><div style="color:#ffffff;">GASTOS NO AMPARADOS</div></td>
                                </tr>  
                                <tr>
                                <td colspan="6"  style="color:#ffffff; min-width:500;" >GASTOS NO AMPARADOSGASTOS NO AMPARADOSGASTOS NO AMPARADOSGASTOS NO AMPARADOSGASTOS NO AMPARADOS</td>
                                </tr>


                            </tbody>
                        </table>
                        <!-- GUARDAR VALOR DE HTML GENERADO PARA EL PDF-->
                        <?php
                        echo $var = ob_get_clean();

                        $num = rand(1, 10);
                        $dir = 'pdf/index?1=' . $num;
                        ?> 

                        <!--FIN-->  
                        <!-- Formulario oculto para crear pdf-->
                        <form method="post" id="targetpdf" action="<?php echo url_for($dir) ?>" target="_blank" hidden="hidden">
                            <input id="titulo_pdf"  name="titulo_pdf" type="text" value="Consulta Reclamo" />
                            <textarea id="text_pdf" name="text" rows="2" cols="20"  >
<?php echo $var; ?>
                            </textarea>
                        </form>
                        <!-- fin--> 

                        <!-- Formulario oculto para crear excel-->
                        <form method="post" id="targetexcel" action="<?php echo url_for('excel/index') ?>" target="_blank" hidden="hidden">
                            <input id="titulo"  name="titulo" type="text" value="Consulta Reclamo" />
                            <textarea id="text" name="text" rows="2" cols="20"  ><?php echo $var; ?></textarea>
                        </form>
                        <!-- fin-->

                    </div>                  
                </div>

                <hr style="background-color:#E8E8E8; height:2px; border:0;" />


                <table class="sectorBottomMenu">
                    <tr>
                    <td><a href="javascript:void(0)" id="url_excel">Excel</a></td>
                    <td><a href="javascript:void(0)" id="url_pdf">PDF</a></td>
                    <td><a href="javascript:void(0)" id="url_imprime">Imprimir</a></td> 
                    <?php
                    if ($clase_lis == '2') {
                        $url_atras = 'siniedetaprove/index' . '?ano=' . $ano . '&mes=' . $mes . '&cliente=' . $cliente . '&contratante=' . $contratante . '&tipo_servicio=' . $tipo_servicio . '&tipo_lis=' . $tipo_lis . '&rif=' . $rif . '&pagina=' . $pagina_ubi;
                    } elseif ($clase_lis == '1') {
                        $url_atras = 'siniedetageneral/index' . '?ano=' . $ano . '&mes=' . $mes . '&cliente=' . $cliente . '&contratante=' . $contratante . '&tipo_servicio=' . $tipo_servicio . '&servicio=' . $tipo_des . '&tipo_lis=' . $tipo_lis . '&pagina=' . $pagina_ubi;
                    } elseif ($clase_lis == '3') {
                        $url_atras = 'siniedetaprove/index' . '?ano=' . $ano . '&mes=' . $mes . '&cliente=' . $cliente . '&contratante=' . $contratante . '&tipo_servicio=' . $tipo_servicio . '&tipo_lis=' . $tipo_lis . '&pagina=' . $pagina_ubi . '&indicador=' . $indicador;
                    } elseif ($clase_lis == '5') {
                        $url_atras = 'siniedetallpatolo/index' . '?ano=' . $ano . '&mes=' . $mes . '&cliente=' . $cliente . '&contratante=' . $contratante . '&tipo_servicio=' . $tipo_servicio . '&tipo_lis=' . $tipo_lis . '&enfermedad=' . $enfermedad . '&pagina=' . $pagina_ubi . '';
                    } elseif ($clase_lis == '4') {
                        $url_atras = 'siniedetallpatolo/index' . '?ano=' . $ano . '&mes=' . $mes . '&cliente=' . $cliente . '&contratante=' . $contratante . '&tipo_servicio=' . $tipo_servicio . '&indicador=1&pagina=' . $pagina_ubi . '';
                    }
                    ?>
                    <td><a href="<?php echo $url_atras; ?>" id="url_atras">Atrás</a></td> 
                    </tr>                        
                </table>
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

    //    funcion de submit pdf
    $('#url_pdf').click(function() {
        $('#targetpdf').submit();
    }); 
    //Funcion de submit excel
    $('#url_excel').click(function() {
        $('#targetexcel').submit();
    }); 
</script>
<script>
    function llenar_contratantes(a)
    {
        //alert("MIlaaaaaaaaaaaaaaaaaaaaaaaa"); 
        var n = document.forms.form1.contratante.length;

        //alert(a);
        for (var i=0; i<n;++i){      
            document.forms.form1.contratante.remove(document.forms.form1.contratante.options[i]);//eliminar lineas del 2do combo...
        }
   
        document.forms.form1.contratante[0]= new Option("Todos",'todos'); //creamos primera linea del segundo combo

 
<?php
foreach ($ente_contratante_vw as $row_c):
    $id_pol = $row_c['idepol'];
    ?> 
                                   
        	   	
                if (a== '<?php echo $id_pol; ?>'){

                    //alert("Milaaaaaaaaaaa holaaaaaaaa");
    <?php
    $valorwhere = 'idepol=' . $id_pol;
    $q = Doctrine_Query::create()
            ->from('CONTRATO_POLIZA_VW  J')
            ->where($valorwhere);
    $CONTRATO_POLIZA_VW_filtrado = $q->fetchArray();
    foreach ($CONTRATO_POLIZA_VW_filtrado as $row_pf):
        $id_pol2 = $row_pf['idepol'];
        $des_contratante = $row_pf['desctrocos'];
        ?>
                            //  echo $id_pol2."<br />";
                            document.forms.form1.contratante[document.forms.form1.contratante.length]= new Option("<?php echo $des_contratante; ?>",'<?php echo $id_pol2; ?>'); 
    <?php endforeach;
    ?>
                    
                }
<?php endforeach; ?>
 

    }
 


    function fechas_mes(a,y,diab)
    {
     
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
            if(diab==0){ document.forms.form1.fin.value="29-2-"+y;}
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