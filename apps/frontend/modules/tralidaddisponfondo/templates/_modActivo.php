<div class="coursesMenuBox">
    <h2 class="title"><span>Siniestralidad</span></h2>
<ul>
        <li <?php if('tralidadresumehistor' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidadresumehistor/index') ?>">Resumen Histórico</a></li>
        <li <?php if('tralidaddisponfondo' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidaddisponfondo/index') ?>">Disponibilidad del Fondo</a></li>
        <li <?php if('tralidadincurrvspagado' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidadincurrvspagado/index') ?>">Incurrido vs Pagado</a></li>
        <li <?php if('tralidadincurrpagadovsrendid' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('tralidadincurrpagadovsrendid/index') ?>">Incurrido Pagado vs. Rendido</a></li>
        <li <?php if('tralidadtablerindicaresume' == $sf_context->getModuleName()) { echo 'class="current"'; } else{echo 'class="mas"';} ?>><a href="<?php echo url_for('tralidadtablerindicaresume/index') ?>"> Tablero Indicadores Resumen</a></li>
        <!--<li <?php if('sinielistadfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('sinielistadfrecue/index') ?>"> Tendencia N° de Casos Por Persona </a> </li>      
        <li <?php if('sinielistadfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('sinielistadfrecue/index') ?>"> Tendencia Costo Promedio por Mes</a> </li>  
        <li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Tendencia Ahorro Mensual</a></li> 
        <li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Tendencia Honorarios vs Incurrido Total</a></li> 
        <li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Comparativo Incurrido vs Fondo Estimado Teórico</a></li>-->
        <li <?php if('tralidadtipossinie' == $sf_context->getModuleName()) { echo 'class="current"'; } else{echo 'class="mas"';} ?>><a href="<?php echo url_for('tralidadtipossinie/index') ?>">Tipo de Siniestralidad</a></li>  
        <!--<li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Por Parentesco - Mes</a></li> 
        <li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Por Parentesco - Mes + Localidad</a></li> 
        <li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Consolidado</a></li> 
         <li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Parentesco + Incurrido + N° de Casos </a></li> 
         <li <?php if('siniedetallfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallfrecue/index') ?>">Tipo Servicio + Incurrido + N° de Casos </a></li> -->
    </ul>
</div>
