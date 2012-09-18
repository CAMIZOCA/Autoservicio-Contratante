<?php use_helper('Date'); ?>
<?php use_helper('Number') ?> 
<?php setlocale(LC_MONETARY, 'it_IT'); ?> 

<div id="noSideBar"> 
    <div id="innerwrap">  
        <div id="contentBar">
            <div class="articleContentSector">
                <!-- BREADCRUMB -->
                <div class="breadcrumbBox">
                    <ul>
                        <li><a href="<?php echo url_for('maindashboard/index') ?>">AutoServicio</a></li>
                        <li class="last">Inicio</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->

                <div class="articleBox">
                    <h1 class="articleTitle">Datos de Usuario </h1>


                    <table class="tableSector">
                        <thead>
                            <tr>
                            <th style="padding-right: 10px;padding-left: 10px;" >Usuario</th>                                    
                            <th style="padding-right: 10px;padding-left: 10px;" >Nombre</th>
                            <th style="padding-right: 10px;padding-left: 10px;" >Credencial</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td style="padding-right: 10px;padding-left: 10px;" ><?php echo $UserName ?></td>                                    
                            <td style="padding-right: 10px;padding-left: 10px;" ><?php echo $FirstName . ' ' . $LastName; ?></td>
                            <td style="padding-right: 10px;padding-left: 10px;" ><?php echo $perfil ?></td> 
                            </tr>

                    </table>




                    <?php
                    foreach ($recordset as $row):
                        ?>

                        <hr>
                        <h1 class="articleTitle">Planes de Servicio </h1>

                        <table class="tableSector" style ="width: 400px;" >
                            <thead>
                                <tr>
                                <th colspan="2">Empresa</th>
                                </tr>
                            </thead>


                            <tbody>
                                <tr>
                                <td colspan="2"><?php echo $row['NOMBRE']; ?></td>
                                </tr>  

                                <tr>
                                <td>Cod. de Cliente</td>
                                <td><?php echo $row['NUMERO_POLIZA']; ?></td>
                                </tr>  

                                <tr>
                                <td>Fecha inicio contrato</td>
                                <td class="alignRight"><?php echo $row['FECHA_INICIO_CONTRATO']; ?></td>
                                </tr>                                  

                                <td>Fecha fin contrato</td>
                                <td class="alignRight"><?php echo $row['FECHA_FIN_CONTRATO']; ?></td>
                                </tr>
                            </tbody>

                        </table>




                        <table class="tableSector" style ="width: 400px;float:  left" >
                            <thead>
                                <tr>
                                <th colspan="2">Datos del fondo</th>
                                </tr>
                            </thead>
                            <tbody>

                                <td>Aportes</td>
                                <td class="alignRight"><?php echo $row['APORTES']; ?></td>
                                </tr>

                                <td>Incurrido total teórico</td>
                                <td class="alignRight"><?php echo $row['INCURRIDO_TOTAL_TEO']; ?></td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                <th>Total Disponible</th>
                                <th class="alignRight"><?php echo $row['DATOSFONDO_TOTAL']; ?></th>
                                </tr>
                                </tfood>
                        </table>





                        <table class="tableSector" style ="width: 400px;" >
                            <thead>
                                <tr>
                                <th colspan="2">Ahorro Técnico</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                <td>Incurrido teórico </td>
                                <td class="alignRight"><?php echo $row['INCURRIDO_INDEMNIZADO_TEO']; ?></td>
                                </tr>

                                

                                <tr>
                                <td>Incurrido indemnizado (Auditado)</td>
                                <td class="alignRight"><?php echo $row['INCURRIDO_INDEMNIZADO']; ?></td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                <th>Total Ahorro Técnico  </th>
                                <th class="alignRight"><?php echo $row['AHORROTECNICO_TOTAL']; ?></th>
                                </tr>
                                </tfood>
                        </table>              











                        <table class="tableSector" style ="width: 400px;float:  left" >
                            <thead>
                                <tr>
                                <th colspan="2">Ahorro Financiero</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                <td>Total Facturado</td>
                                <td class="alignRight"><?php echo $row['TOTAL_FACTURADO']; ?></td>
                                </tr>

                                <tr>
                                <td>Total Pagado</td>
                                <td class="alignRight"><?php echo $row['TOTAL_PAGADO']; ?></td>
                                </tr>

                            </tbody>
                            
                        </table>              










            <table class="tableSector" style ="width: 400px;float:  left" >
                <thead>
                    <tr>
                    <th colspan="2">Siniestralidad</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>Incurrido total teórico (a)</td>
                    <td class="alignRight"><?php echo $row['INCURRIDO_INDEMNIZADO_TEO']; ?></td>
                    </tr>
                    <tr>
                    <td>Incurrido acumulado actual (b)</td>
                    <td class="alignRight"><?php echo $row['INCURRIDO_ACUM_ACT']; ?></td>
                    </tr>
                    <tr>
                    <td>Incurrido indemnizado (Auditado) (c)</td>
                    <td class="alignRight"><?php echo $row['INCURRIDO_INDEMNIZADO']; ?></td>
                    </tr>
                    <tr>
                    <td>Incurrido pagado (d)</td>
                    <td class="alignRight"><?php echo $row['TOTAL_PAGADO']; ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                    <th>Pendiente por pagar auditado (c) - (d) </th>
                    <th class="alignRight"><?php echo $row['SINIES_PENDAUDI']; ?></th>
                    </tr>
                    <tr>
                    <th>Total pendiente por pagar  (b) + (c) - (d) </th>
                    <th class="alignRight"><?php echo $row['SINIES_PENDPAGAR']; ?></th>
                    </tr>
                    </tfood>
            </table>              




                        <div style="clear:both"></div>

                        <?php
                    endforeach;
                    ?>

                </div>
            </div>
        </div>
    </div><!--end innerwrap--> 
</div><!--end main--> 



