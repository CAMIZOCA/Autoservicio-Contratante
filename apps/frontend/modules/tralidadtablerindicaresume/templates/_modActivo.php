<div class="coursesMenuBox">
    <h2 class="title"><span>Siniestralidad</span></h2>
<ul>
        <li <?php if('tralidadresumehistor' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidadresumehistor/index') ?>">Resumen Histórico</a></li>
        <li <?php if('tralidaddisponfondo' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidaddisponfondo/index') ?>">Disponibilidad del Fondo</a></li>
        <li <?php if('tralidadincurrvspagado' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidadincurrvspagado/index') ?>">Incurrido vs Pagado</a></li>
        <li <?php if('tralidadincurrpagadovsrendid' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidadincurrpagadovsrendid/index') ?>">Incurrido Pagado vs. Rendido</a></li>
        <li <?php if(('tralidadtablerindicaresume' == $sf_context->getModuleName()) and trim($tipo_reporte)=='') { echo 'class="current"'; } else{echo 'class="mas"';} ?>><a href="<?php echo url_for('tralidadtablerindicaresume/index') ?>"> Tablero Indicadores Resumen</a></li>
        <li style="margin-left:10px;" <?php if(('tralidadtablerindicaresume' == $sf_context->getModuleName()) and $tipo_reporte==1)  : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidadtablerindicaresume/index?tr=1') ?>"> Tendencia N° de Casos Por Persona </a> </li>      
        <li style="margin-left:10px;" <?php if(('tralidadtablerindicaresume' == $sf_context->getModuleName()) and $tipo_reporte==2): echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidadtablerindicaresume/index?tr=2') ?>"> Tendencia Costo Promedio por Mes</a> </li>  
        <!--<li style="margin-left:10px;" <?php if(('tralidadtablerindicaresume' == $sf_context->getModuleName()) and $tipo_reporte==3): echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidadtablerindicaresume/index?tr=3') ?>">Tendencia Ahorro Mensual</a></li> -->
       <li style="margin-left:10px;" <?php if(('tralidadtablerindicaresume' == $sf_context->getModuleName()) and $tipo_reporte==4): echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidadtablerindicaresume/index?tr=4') ?>">Tendencia  de Ahorro mensual</a></li> 
       <!--<li style="margin-left:10px;" <?php if(('tralidadtablerindicaresume' == $sf_context->getModuleName()) and $tipo_reporte==5): echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidadtablerindicaresume/index?tr=5') ?>">Tendencia Honorarios versus Incurrido total mensual</a></li>-->
        <!--<li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Comparativo Incurrido vs Fondo Estimado Teórico</a></li>-->
       <li <?php if('tralidadtipossinie' == $sf_context->getModuleName()) { echo 'class="current"'; } else{echo 'class="mas"';} ?>><a href="<?php echo url_for('tralidadtipossinie/index') ?>">Tipo de Siniestralidad</a></li>  
       <!-- <li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Por Parentesco - Mes</a></li> 
        <li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Por Parentesco - Mes + Localidad</a></li> 
        <li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Consolidado</a></li> 
         <li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Parentesco + Incurrido + N° de Casos </a></li> 
         <li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Tipo Servicio + Incurrido + N° de Casos </a></li> -->
    </ul>
</div>
