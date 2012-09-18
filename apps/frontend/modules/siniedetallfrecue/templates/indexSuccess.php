<?php  //echo "<h1>$greetings</h1>";
 //$temp55=$_POST['mes'];

 //echo "MIla".$sf_params->get('cliente');
    ?> 
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
                        <li><a href="#">Siniestros</a></li>
                        <li class="last"> Detalle de Listado de Frecuencias</li>
                    </ul>
                </div>
                <!-- TÍTULO DEL TEMA / TOPICO -->
                <h1 class="articleTitle">  Detalle de Listado de Frecuencias </h1>
                <div class="articleBox">
                    <form  id="form1"  action="<?php echo url_for('siniereclamtiposervic/index') ?>" method="post">
             <table>
                       <?php //echo $form; ?>
                        <tr><td>Cliente: </td><td colspan="3"><select id="cliente" name="cliente">
                                    <?php foreach ($ente_contratante_vw as $row): ?>
                                    <option value="<?php echo $row['idepol']; ?>"><?php 
                                    echo $row['producto_acsel'].' - '.$row['descripcion']; ?></option>
                                     <?php endforeach; ?>

                                </select> </td></tr>
                        <tr><td>Año: </td><td colspan="3"><select id="temp" >
                                    <option value="1">2012</option>
                                    <option value="1">2011</option>

                                </select> </td></tr>
                        <tr><td >Mes: </td><td colspan="3">
                                <select id="temp" >
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>

                                </select> </td>
                        
                        </tr>
                        <tr>
                          <td height="21" >Desde:</td>
                          <td height="21" > <input name="desde" id="desde" value="01/10/2011" readonly="true" size="10" /> 
                              <!--<input type="text" name="fecha" id="campofecha" size="12-->
</td>
                          <td  width="90">Hasta:</td>
                          <td ><input name="hasta" id="hasta" value="01/10/2011" readonly="true" size="10" /></td>
  </tr>
                        <tr>
                          <td height="21" >Dìas del Mes:</td>
                          <td height="21" > <input name="dias_mes" id="dias_mes" value="31" readonly="true" size="5" /></td>
                          <td  width="90">Dias Hàbiles:</td>
                          <td ><input name="dias_habiles" id="dias_habiles" value="21" readonly="true" size="5" /></td>
  </tr>
                        
                        <tr><td>Contratante: </td><td colspan="3"><select id="cliente">
                                    <?php foreach ($CONTRATO_POLIZA_VW as $row): ?>
                                    <option value="<?php echo $row['idepol']; ?>"><?php 
                                    echo $row['idepol'].' - '.$row['desctrocos']; ?></option>
                                     <?php endforeach; ?>

                                </select> </td></tr>
                        
                        <tr><td>Tipo de Servicio: </td><td colspan="3">
                                <select id="tipo_servicio">
                                     <option value="Todas">Todas</option>
                                    <option value="Claves de emergencia">Claves de Emergencia</option>
                                    <option value="Cartas Avales">Cartas Avales</option>
                                    <option value="Claves de emergencia">Reembolsos</option>
                                    <option value="Funerario">Funerario</option>
                                    <option value="APS - Consulta">APS - Consulta</option>
                                    <option value="APS - Laboratorio">APS - Laboratorio</option>
                                    <option value="APS - Examenes">APS - Examenes</option>
                                    <option value="Claves de emergencia">Servicio Farmacia</option>
                                    <option value="Claves de emergencia">Servicio Ambulancia</option>
                                    <option value="Claves de emergencia">Atenciòn Domiciliaria</option>
                                    <option value="Claves de emergencia">Atenciòn Prepago</option>

                                </select> </td></tr>
                        <tr>
                          <td colspan="4">
 
</td>
                        </tr>
                        <tr>
                          <td colspan="4"><input type="submit" class="btn_buscar"  value="Buscar" />&nbsp;</td>
                        </tr>
                        
                    </table>
</form>
                    <!-- INICIO -->
                    <div class="clear" style="padding-bottom:30px;"></div>
                   <div style="height:70px; margin-top:10px; margin-bottom: 30px; ">
<div style="width:300px; border:solid #007a5e 1px; margin-left:20px; float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
<div style="height:20px;padding:5px; ">
<div style="float:left; height:20px; width:160px; color:#333; font-weight:bold;">Cantidad de Proveedores:</div><div style="float:left; height:25px; margin-left:10px;">200</div>  
</div>
<div style="height:20px; border-top:solid #007a5e 1px; padding:5px;">
  <div style="float:left; height:20px;width:230px; color:#333; font-weight:bold;">Cantidad Promedio de Casos/Proveedor:</div><div style="float:left; height:20px; margin-left:10px;">10</div>
</div></div>

<!-- otra cajita --><!-- otra cajita -->
<div style="width:220px; border:solid #007a5e 1px; margin-left:20px;  float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
<div style="height:20px;padding:5px; ">
<div style="float:left; height:20px; width:100px; color:#333; font-weight:bold;">Total Reclamos:</div><div style="float:left; height:25px; margin-left:10px;">200</div>  
</div>
<div style="height:20px; border-top:solid #007a5e 1px; padding:5px;">
  <div style="float:left; height:20px;width:160px; color:#333; font-weight:bold;">Total Personas Atendidas:</div><div style="float:left; height:20px; margin-left:10px;">10</div>
</div></div>

<!-- otra cajita --><!-- otra cajita -->

<div style="width:200px; border:solid #007a5e 1px; margin-left:20px; float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px; ">
<div style="height:20px;padding:5px; ">
<div style="float:left; height:20px; width:100px; color:#333; font-weight:bold;">Monto Total Bs:</div><div style="float:left; height:25px; margin-left:10px;">200</div>  
</div>
<div style="height:20px; border-top:solid #007a5e 1px; padding:5px;">
  <div style="float:left; height:20px;width:140px; color:#333; font-weight:bold;">Costo Promedio/Caso:</div><div style="float:left; height:20px; margin-left:10px;">10</div>
</div></div>

<!-- otra cajita --><!-- otra cajita -->
                   </div>
                   
                   
<div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#007a5e; font-weight:bold; margin-bottom:15px;" align="center"> Listado de Personas Atendidas y Frecuencia por Patologías Claves de Emergencia</div>
                  <div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#007a5e; font-weight:bold; margin-bottom:15px; height:60px;" align="center">
                      <div style="width:250px; border:solid #007a5e 1px; margin-left:20px; float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                        <div style="height:20px;padding:5px; ">
                          <div style="float:left; height:20px; width:160px; color:#333; font-weight:bold;">Total Patologías:</div>
                          <div style="float:left; height:25px; margin-left:10px;">200</div>
                        </div>
                      </div>
                      <div style="width:250px; border:solid #007a5e 1px; margin-left:20px; float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                        <div style="height:20px;padding:5px; ">
                          <div style="float:left; height:20px; width:160px; color:#333; font-weight:bold;">Total Reclamos:</div>
                          <div style="float:left; height:25px; margin-left:10px;">200</div>
                        </div>
                      </div>
                      <div style="width:250px; border:solid #007a5e 1px; margin-left:20px; float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                        <div style="height:20px;padding:5px; ">
                          <div style="float:left; height:20px; width:160px; color:#333; font-weight:bold;">Total Personas Atendidas:</div>
                          <div style="float:left; height:25px; margin-left:10px;">200</div>
                        </div>
                        
                      </div>
                    </div>
                    <!-- INICIO PANTALLAS BACKEND -->
<table class="tableSector">
                                            <thead>
                                                <tr>
                                                    <th>Tipo de Servicio</th>
                                                    <th>Total de Personas Atendidas</th>
                                                    <th>Cantidad Total de Casos Generados</th>
                                                    <th>Costo Total</th>
                                                    <th>Costo Promedio/Persona Bs</th>
                                                    <th>Número de Casos Promedio/Persona</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php //foreach ($POBLACION_CONSOLIDADA_VW as $row): ?>
                                                                                              
                                                
                                                <tr>      
                                                    
                                                    <td align="left"><input type="button" />Claves de Emergencia<?php //echo $row['mparentesco']; ?></td>
                                                    <td align="center">0<?php //echo $row['mtotal']; ?></td>
                                                    <td align="center">0<?php //echo $row['fparentesco']; ?></td>
                                                    <td align="center">0<?php //echo $row['ftotal']; ?></td>
                                                    <td align="center">0<?php //echo $row['totalgrupo']; ?></td>
                                                    <td align="center">0&nbsp;</td>
                                                </tr>
                                                 <tr>      
                                                    
                                                    <td align="left"><input type="button" />Cartas Avales<?php //echo $row['mparentesco']; ?></td>
                                                    <td align="center">0<?php //echo $row['mtotal']; ?></td>
                                                    <td align="center">0<?php //echo $row['fparentesco']; ?></td>
                                                    <td align="center">0<?php //echo $row['ftotal']; ?></td>
                                                    <td align="center">0<?php //echo $row['totalgrupo']; ?></td>
                                                    <td align="center">0&nbsp;</td>
                                                </tr>
                                                <?php 
                                                //suma de totales
                                                //$totalMasculino = $totalMasculino + $row['mtotal'];
                                               // $totalFemenino = $totalFemenino + $row['ftotal'];
                                                //$totalGrupo = $totalGrupo + $row['totalgrupo'];
                                                //endforeach; 
                                                ?>
                                            </tbody>
                                            <tbody>
                                            </tbody>
                    
                  </table> 

                    

            
                    <hr style="background-color:#E8E8E8; height:2px; border:0;" />


                    <table class="sectorBottomMenu">
                        <tr>
                            <td>
                                Exportar a: 
                            </td>
                            <td><select id="temp">
                                    <option value="1">PDF</option>
                                    <option value="2">EXCEL</option>
                                </select>
                                <input type="button" value="Descargar" /></td>
                        </tr>
                        <tr>
                            <td>Impresión: </td>
                            <td><input type="button" value="Vista Previa" /> </td>
                        </tr>
                    </table>
                    <div class="clear" style="padding-bottom:30px;"></div>
              </div>
            </div>
        </div>
    </div>
</div>
