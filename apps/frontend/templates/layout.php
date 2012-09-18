<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <meta charset="UTF-8">
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="favicon.ico" />
        <?php include_stylesheets() ?>
        <link rel="stylesheet" href="/css/print.css" type="text/css" media="print" />
        <?php include_javascripts() ?>

    </head>
    <body>
        <?php
        //$sf_user->setCulture('es_VE') 
        //$sf_user->clearCredentials();
        
        if (in_array("ADMINISTRADOR", $sf_user->getCredentials())) {        
            $this->perfil = "ADMINISTRADOR";
            
        } elseif (in_array("HMOSEGURIDAD", $sf_user->getCredentials())) {
            $this->perfil = "HMOSEGURIDAD";
            
        } elseif (in_array("HMOSUPERUSUARIO", $sf_user->getCredentials())) {
            $this->perfil = "HMOSUPERUSUARIO";
            
        } elseif (in_array("HMOVENTAS", $sf_user->getCredentials())) {
            $this->perfil = "HMOVENTAS";
            
        } elseif (in_array("CNE", $sf_user->getCredentials())) {
            $this->perfil = "CNE";
            
        } elseif (in_array("ALCALDIACCS", $sf_user->getCredentials())) {
            $this->perfil = "ALCALDIACCS";
            
        } else {
            $this->perfil = "ANONIMO";
            
        }
         //  echo  $this->perfil ;
        ?>
        <div id="background">
            <div id="wrapperDashboard"> 
                <div id="hZone">
                    <img src="/images/logohmo.png" alt="HMO SERVISALUD" />
                    <div class="flashHeader">    

                        <object data="swf/headerFlash.swf" type="application/x-shockwave-flash"  width="600" height="100">
                            <param name="movie" value ="swf/headerFlash.swf" />
                        </object>

                    </div>
                </div>
                <div id="globalMenuSector">
                    <ul>

                        <!-- BOTON: HOME -->
                        
                            <li class="btnAll <?php if ('maindashboard' == $sf_context->getModuleName()) : echo 'active';
                            endif; ?>"><a href="<?php echo url_for('maindashboard/index') ?>">Inicio</a></li>
                        
                        
                        
                        <!-- BOTON: POBLACION -->
                        <?php if ($this->perfil == 'ADMINISTRADOR'  ||
                                  $this->perfil == 'HMOSUPERUSUARIO'  ||
                                  $this->perfil == 'HMOVENTAS'  ||
                                  $this->perfil == 'ALCALDIACCS'  ||
                                  $this->perfil == 'CNE'
                                
                                ) { ?>
                        <li class="btnAll <?php
                        if (
                                'poblabusgen' == $sf_context->getModuleName() ||
                                'poblaconsol' == $sf_context->getModuleName() ||
                                'poblaevoluc' == $sf_context->getModuleName() ||
                                'poblarangop' == $sf_context->getModuleName() ||
                                'poblarangos' == $sf_context->getModuleName() ||
                                'poblarangot' == $sf_context->getModuleName() ||
                                'altbaevoluc' == $sf_context->getModuleName() ||
                                'altbamensua' == $sf_context->getModuleName()
                        )
                            : echo 'active';
                        endif;
                        ?>"><a href="<?php echo url_for('poblaconsol/index') ?>">Población</a></li>
                        <?php } ?>
                        
                        <!-- BOTON: SINIESTROS -->
                        <?php if ($this->perfil == 'ADMINISTRADOR'  ||
                                  $this->perfil == 'HMOSUPERUSUARIO'  ||
                                  $this->perfil == 'HMOVENTAS' ||
                                  $this->perfil == 'ALCALDIACCS'     ) { ?>
                        <li class="btnAll <?php
                        if (
                                'siniereclamtiposervic' == $sf_context->getModuleName() ||
                                'sinielistadprovee' == $sf_context->getModuleName() ||
                                'sinielistadpatolo' == $sf_context->getModuleName() ||
                                'siniedetaprove' == $sf_context->getModuleName() ||
                                'siniedetallepatolo' == $sf_context->getModuleName() ||
                                'sinielistadfrecue' == $sf_context->getModuleName() ||
                                'siniedetallfrecue' == $sf_context->getModuleName() ||
                                'siniedetallpatolo' == $sf_context->getModuleName() ||
                                'siniedetageneral' == $sf_context->getModuleName() ||
                                'siniedetalle' == $sf_context->getModuleName()
                        )
                            : echo 'active';
                        endif;
                        ?>"><a href="<?php echo url_for('siniereclamtiposervic/index') ?>">Siniestros</a></li>
                        <?php } ?>
                        
                        
                        <!-- BOTON: Siniestralidad -->
                        <?php if ($this->perfil == 'ADMINISTRADOR'    ||
                                  $this->perfil == 'HMOSUPERUSUARIO'  ||
                                  $this->perfil == 'HMOVENTAS'    ||
                                  $this->perfil == 'ALCALDIACCS'  
                                ) { ?>
                        <li class="btnAll <?php
                        if (
                                'tralidadresumehistor' == $sf_context->getModuleName() ||
                                'tralidaddisponfondo' == $sf_context->getModuleName() ||
                                'tralidadincurrvspagado' == $sf_context->getModuleName() ||
                                'tralidadincurrpagadovsrendid' == $sf_context->getModuleName() ||
                                'tralidadtablerindicaresume' == $sf_context->getModuleName() ||
                                'tralidadtipossinie' == $sf_context->getModuleName() ||
                                'tralidadparenmes'== $sf_context->getModuleName() ||
                                'tralidadlocalparentesco'== $sf_context->getModuleName() ||
                                'tralidadservimes'== $sf_context->getModuleName() ||
                                'tralidadlocalservicio'== $sf_context->getModuleName() ||                                
                                'tralidadservincucasos' == $sf_context->getModuleName() ||
                                'tralidadparenincucasos' == $sf_context->getModuleName()
                        )
                            : echo 'active';
                        endif;
                        ?>"><a href="<?php echo url_for('tralidadresumehistor/index') ?>">Siniestralidad</a></li>
                        <?php } ?>
                        
                        
                        <!-- BOTON: Listado de ranking -->
                        <?php if ($this->perfil == 'ADMINISTRADOR') { ?>
                        <li class="btnAll"><a href="#">Listado de ranking</a></li>
                        <?php } ?>
                        <!-- BOTON: Fondos -->
                        <?php if ($this->perfil == 'ADMINISTRADOR') { ?>
                        <li class="btnAll"><a href="#">Fondos</a></li>
                        <?php } ?>
                        <!-- BOTON: Ayuda -->
                        <?php if ($this->perfil == 'ADMINISTRADOR') { ?>
                        <li class="btnAll"><a href="#">Ayuda</a></li>
                        <?php } ?>
                        <!-- BOTON: Usuarios -->
                        <?php if ($this->perfil == 'ADMINISTRADOR'  ||
                                  $this->perfil == 'HMOSEGURIDAD' ) { ?>
                        <li class="btnAll"><a href="<?php echo url_for('sfGuardUser/index') ?>">Usuarios</a></li>
                        <?php } ?>
                        <!-- BOTON: Grupos -->
                        <?php if ($this->perfil == 'ADMINISTRADOR'  ||
                                  $this->perfil == 'HMOSEGURIDAD' ) { ?>
                        <li class="btnAll"><a href="<?php echo url_for('sfGuardGroup/index') ?>">Grupos</a></li>
                        <?php } ?>
                        <!-- BOTON: Credenciales -->
                        <?php if ($this->perfil == 'ADMINISTRADOR'  ||
                                  $this->perfil == 'HMOSEGURIDAD' ) { ?>
                        <li class="btnAll"><a href="<?php echo url_for('sfGuardPermission/index') ?>">Credenciales</a></li>
                        <?php } ?>
                        
                        <!-- BOTON: Salir Session -->
                        <li><?php echo link_to('Cerrar Sesión', '@sf_guard_signout') ?></li>
                    </ul>
                </div>   
                <!--                <div id="mainContentSector">end innerwrap 
                                    <div id="innerwrap"> -->

<?php echo $sf_content ?>
                <!--
                                    </div>end innerwrap 
                                </div>end main -->

                <div id="footer">
                    <div class="footerMenu">
                        <ul>
                            <li ><a href="<?php echo url_for('maindashboard/index') ?>">Inicio</a></li>
<!--                            <li class="btnAll active"><a href="<?php echo url_for('poblaconsol/index') ?>">Población</a></li>-->
                            <!--            <li ><a href="#">Altas y bajas</a></li>-->
<!--                            <li ><a href="<?php echo url_for('siniereclamtiposervic/index') ?>">Siniestros</a></li>-->
<!--                            <li ><a href="<?php echo url_for('tralidadresumehistor/index') ?>">Siniestralidad</a></li>-->
                            <!--                            <li ><a href="#">Listado de ranking</a></li>
                                                        <li ><a href="#">Fondos</a></li>
                                                        <li ><a href="#">Mi Cuenta</a></li>
                                                        <li ><a href="#">Ayuda</a></li>-->
                        </ul>
                    </div>
                    <div class="creditsSector">
                        <a href="#">Términos y Condiciones del Servicio</a>
                        <a href="#">Políticas de Privacidad</a>
                        <a href="http://www.hmoservisalud.com.ve/PortalHMO/" target="_Blank" >HMO Servisalud</a>
                    </div>
                </div></div><!--end wrapper--> 
        </div>
    </body>
</html>
