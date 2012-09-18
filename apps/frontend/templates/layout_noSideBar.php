<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <meta charset="UTF-8">
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>

        <!-- ESTILOS PROGRESSBAR DESARROLLO-->
        <link rel="stylesheet" type="text/css" href="<?php echo sfConfig::get('app_ruta_web');?>/progressBar/jqueryui1.7/development-bundle/themes/smoothness/ui.core.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo sfConfig::get('app_ruta_web');?>/progressBar/jqueryui1.7/development-bundle/themes/smoothness/ui.theme.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo sfConfig::get('app_ruta_web');?>/progressBar/jqueryui1.7/development-bundle/themes/smoothness/ui.progressbar.css" />

        <!-- SCRIPTS PROGRESSBAR DESARROLLO -->
        <script type="text/javascript" src="<?php echo sfConfig::get('app_ruta_web');?>/progressBar/jqueryui1.7/development-bundle/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="<?php echo sfConfig::get('app_ruta_web');?>/progressBar/jqueryui1.7/development-bundle/ui/ui.core.js"></script>
        <script type="text/javascript" src="<?php echo sfConfig::get('app_ruta_web');?>/progressBar/jqueryui1.7/development-bundle/ui/ui.progressbar.js"></script>


    </head>
    <body>
        
        <div id="background">
            <div id="wrapper"> 
                <div id="hZone">		
                    <img src="<?php echo sfConfig::get('app_ruta_web');?>/images/logoExperienciaDeServicio.png" alt="Experiencia de Servicio Banesco" />
                    
                    <div class="flashHeader">    		
                         <object data="swf/headerFlash.swf" type="application/x-shockwave-flash"  width="500" height="100">
                            <param name="movie" value ="swf/headerFlash.swf" />
                        </object>
                    </div>
                </div> 
                <div id="globalMenuSector">
                    <ul>
<li class="btnDashboard <?php if ('dashboard' == $sf_context->getModuleName()) : echo 'active'; endif; ?>"><a href="<?php echo url_for('maindashboard/index') ?>">Inicio</a></li>
<li class="btnCourses <?php if ('modulo' == $sf_context->getModuleName() || 'tema' == $sf_context->getModuleName() || 'contenido' == $sf_context->getModuleName()) { echo 'active'; };?>"><a href="<?php echo url_for('modulo/modselect') ?>">Módulos</a></li>
<li class="btnProfile <?php if ('profile' == $sf_context->getModuleName()) { echo 'active'; }; ?>"><a href="<?php echo url_for('profile/index') ?>">Mi Cuenta</a></li>
<li class="btnHelp <?php if ('help' == $sf_context->getModuleName()) { echo 'active'; }; ?>"><a href="<?php echo url_for('help/index') ?>">Ayuda</a></li>
<li><?php echo link_to('Cerrar Sesión', '@sf_guard_signout') ?></li>
                    </ul>
                </div> 
                <div id="mainContentSector noSideBar"><!--end innerwrap--> 
                    <div id="innerwrap"> 

                        <?php echo $sf_content ?>

                    </div><!--end innerwrap--> 
                </div><!--end main--> 
                <div id="footer">
                    <div class="footerMenu">
                        <ul>
                            <!-- <li><a href="<?php echo url_for('dashboard/index') ?>">Inicio</a> | </li>-->
                            <li><a href="<?php echo url_for('modulo/index?mod=1') ?>">Módulos</a> | </li>
                            <!--                            <li><a href="#">Mi Récord</a> | </li>-->
                            <!--                            <li><a href="#">Notificaciones</a> | </li>-->
                            <li><a href="<?php echo url_for('help/index') ?>">Ayuda</a> | </li>
                            <li><?php echo link_to('Cerrar Sesión', '@sf_guard_signout') ?></li>
                        </ul>    	
                    </div>
                    <div class="creditsSector">
                        <a href="#">Términos y Condiciones del Servicio</a>
                        <a href="#">Políticas de Privacidad</a>
                    </div>
                </div> 
            </div><!--end wrapper--> 
        </div>
        
    </body>
</html>
