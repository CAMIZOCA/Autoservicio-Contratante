<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <meta charset="UTF-8">
            <?php include_metas() ?>
            <?php include_title() ?>
            <link rel="shortcut icon" href="/favicon.ico" />
            <?php //include_stylesheets() ?>
            <link rel="stylesheet" type="text/css" media="screen" href="/css/loginStyles.css" />

            <?php include_javascripts() ?>



    </head>
    <body>

        <div class="mainContainer">

            <div class="contentBox">

                <div class="loginForm">
                    <h1>
                        <img alt="Autoservicio" height="29" src="/images/login_loginFormTitle.png"  />
                    </h1>
                    <div id="cuadroLogin" name="cuadroLogin" >
                        <?php echo $sf_content ?>
                    </div>


                    <div id="cuadroErrorIE" name="cuadroErrorIE"  class="messageBox alertMessage">
                        
                        <h2>Problema con su Navegador </h2>
                        <p>El navegador Internet explorer no soporta los estándares de navegacion para el sitio web, Se le recomienda que utilice la última versión Firefox</p>
                    </div>

                </div>
            </div>
        </div>

        <script>
            var browser=navigator.appName;
            //alert(browser);
            if (browser=="Netscape"){                    
                // mozilla, netscape, chrome, ...
                $('#cuadroLogin').show();
                $('#cuadroErrorIE').hide();
            }
            else {
                // Internet Explorer 4 or Opera with IE user agent
        
                $('#cuadroLogin').hide();
                $('#cuadroErrorIE').show();
                    
            }    
            //document.getElementById('cuadroLogin').style.display = 'block';
        
        
        </script>
    </body>
</html>