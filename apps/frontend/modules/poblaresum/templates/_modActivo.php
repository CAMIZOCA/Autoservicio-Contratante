<div class="coursesMenuBox">
    <h2 class="title"><span>Población</a></span></h2>
    <ul>
        <li <?php if('poblaconsol' == $sf_context->getModuleName() ||  $_GET['mod'] == 'POC') : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('poblaconsol/index') ?>">Población consolidada</a></li>
        <li <?php if('poblaevoluc' == $sf_context->getModuleName() ||  $_GET['mod'] == 'PEM') : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('poblaevoluc/index') ?>">Evolución por mes</a></li>
        <li <?php if('poblarangos' == $sf_context->getModuleName() ||  $_GET['mod'] == 'PES') : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('poblarangos/index') ?>">Por rango de edad y sexo</a></li>        
        <li <?php if('poblarangop' == $sf_context->getModuleName() ||  $_GET['mod'] == 'PEP') : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('poblarangop/index') ?>">Por rango de edad, parentesco y sexo</a></li>
<!--   <li <?php if('poblabusgen' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('poblabusgen/index') ?>">Población búsqueda general</a></li>      -->
    </ul>
</div>
<div class="coursesMenuBox">
    <h2 class="title"><span>Altas y Bajas</span></h2>
        <ul>
            <li <?php if('altbamensua' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('altbamensua/index') ?>">Mensualizadas</a></li>
            <li <?php if('altbaevoluc' == $sf_context->getModuleName()) : echo 'class="current"'; endif; ?>><a href="<?php echo url_for('altbaevoluc/index') ?>">Evolución</a></li>
        </ul>
</div>