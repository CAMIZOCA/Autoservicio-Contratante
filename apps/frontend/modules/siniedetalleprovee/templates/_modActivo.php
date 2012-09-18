<div class="coursesMenuBox">
    <h2 class="title"><span>Siniestros</span></h2>
    <ul>
        <li <?php if('siniereclamtiposervic' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniereclamtiposervic/index') ?>">Reclamo por tipo de servicio</a></li>
        <li <?php if('sinielistadprovee' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('sinielistadprovee/index') ?>">Listado por proveedor</a></li>
        <li <?php if('siniedataprove' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedataprove/index') ?>">Detalle por proveedor</a></li>
        <li <?php if('sinielistadpatolo' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('sinielistadpatolo/index') ?>">Listado por patología</a></li>
        <li <?php if('siniedetallpatolo' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('siniedetallpatolo/index') ?>">Detalle por patología</a></li>
        <!--<li <?php if('sinielistadfrecue' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('sinielistadfrecue/index') ?>">Listado de Frecuencia</a></li>-->      
        
    </ul>
</div>
