<?php
//setlocale(LC_TIME,"spanish");  
//setlocale(LC_ALL,"es_EC");
setlocale(LC_TIME, 'spanish');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <!--<![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/protected/extensions/bootstrap/assets/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/protected/extensions/bootstrap/assets/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/protected/extensions/bootstrap/assets/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" type="text/js" href="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js" />
        <?php
        //Yii::app()->clientScript->registerCoreScript('/js/bootstrap.min.js');
        //Yii::app()->clientScript->registerCoreScript('jquery.js');
        Yii::app()->getClientScript()->registerCoreScript('/js/bootstrap.min.js');
        ?>
        <?php
        echo Yii::app()->bootstrap->registerAllCss();
        echo Yii::app()->bootstrap->registerCoreScripts();
        ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="shortcut icon" href="/comunidadSVL/images/pagina/icono.ico"> </link> 
        
        
        <script>
            var html5_audiotypes = {//define list of audio file extensions and their associated audio types. Add to it if your specified audio file isn't on this list:
                "mp3": "audio/mpeg",
                "mp4": "audio/mp4",
                "ogg": "audio/ogg",
                "wav": "audio/wav"
            }

            function createsoundbite(sound) {
                var html5audio = document.createElement('audio')
                if (html5audio.canPlayType) { //check support for HTML5 audio
                    for (var i = 0; i < arguments.length; i++) {
                        var sourceel = document.createElement('source')
                        sourceel.setAttribute('src', arguments[i])
                        if (arguments[i].match(/\.(\w+)$/i))
                            sourceel.setAttribute('type', html5_audiotypes[RegExp.$1])
                        html5audio.appendChild(sourceel)
                    }
                    html5audio.load()
                    html5audio.playclip = function () {
                        html5audio.pause()
                        html5audio.currentTime = 0
                        html5audio.play()
                    }
                    return html5audio
                }
                else {
                    return {playclip: function () {
                            throw new Error("Tu navegador no soporta audio en HTML5")
                        }}
                }
            }

        //Initialize two sound clips with 1 fallback file each:

            var mouseoversound = createsoundbite("./../../audio/whistle.ogg", "./../../audio/whistle.mp3")
            var clicksound = createsoundbite("./../../audio/click.ogg", "./../../audio/click.mp3")

        </script> 
        <?php
     
    
        ?>
    </head>

    <body>
        <?php if (Yii::app()->user->id > 0) { ?>
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo Yii::app()->homeUrl; ?>" onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()">
                            <?php echo CHtml::encode(Yii::app()->name); ?>
                        </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()" 
                                   class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" 
                                   aria-expanded="false"><i class="icon-user navbar-default"></i> ADMINISTRAR SOCIO <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socio/create" ?> >
                                            <i class="icon-user"></i>
                                            Ingresar socio
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socio/admin" ?> >
                                            <i class="icon-user"></i>
                                            Listado socios
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socio/bus_ing_medidor" ?> >
                                            <i class="glyphicon-dashboard"></i>
                                            Ingresar medidor
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socioMedidor/cambiar" ?> >
                                            <i class="icon-circle-arrow-up"></i>
                                            Reemplazar medidor
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socioMedidor/traspaso" ?> >
                                            <i class="icon-flag"></i>
                                            Traspaso de derecho de agua
                                        </a></li>
                                </ul> 
                            </li>

                            <li class="dropdown">
                                <a href="#" onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()" 
                                   class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" 
                                   aria-expanded="false"><i class="icon- navbar-default"></i> ADMINISTRAR RUBROS <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socioMedidor/importarExcel" ?> >
                                            <i class="icon-upload"></i>
                                            <?php
                                            date_default_timezone_set('America/Guayaquil'); //puedes cambiar Guayaquil por tu Ciudad
                                            setlocale(LC_TIME, 'spanish');
                                            $fecha = new DateTime(gmdate('Y-m-d'));
                                            //$fecha->setISODate(2016, 1, 1);
                                            $fecha->modify('-2 month');
                                            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                                                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                                            ?>
                                            Importar datos desde excel del consumo 
                                            <?php echo $meses[($fecha->format('m')) * 1] . ' del ' . $fecha->format('Y'); ?>
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/rubro/create" ?> >
                                            <i class="icon-edit"></i>
                                            Ingresar nuevo rubro
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/rubro/buscarFacturas" ?> >
                                            <i class="icon-calendar"></i>
                                            Rubros de Factura
                                        </a></li> 
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/rubro/buscarRecibos" ?> >
                                            <i class="icon-calendar"></i>
                                            Rubros de Recibo
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/parametro/tarifa" ?> >
                                            <i class="icon-calendar"></i>
                                            Tarifas
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socioMedidor/exportarMedidas" ?> >
                                            <i class="icon-download"></i>
                                            <?php
                                            //echo strftime("%A, %d de %B del %Y  <br><b>HORA:</b> %Hh%M");
                                            ?>
                                            Exportar medidas de <?php echo strftime("%B"); ?> del <?php echo gmdate('Y'); ?>
                                        </a></li>
                                </ul> 
                            </li>

                            <li class="dropdown">
                                <a href="#" onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()" 
                                   class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" 
                                   aria-expanded="false"><i class="glyphicon-usd navbar-default"></i> COBROS <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socioMedidor/factura" ?> >
                                            <i class="glyphicon-usd"></i>
                                            Facturación
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/cuota/buscar" ?> >
                                            <i class="glyphicon-usd"></i>
                                            Cobro parcial
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socio/admin" ?> >
                                            <i class="icon-calendar"></i>
                                            Cerrar caja
                                        </a></li>                                
                                </ul> 
                            </li>

                            <li class="dropdown">
                                <a href="#" onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()" 
                                   class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" 
                                   aria-expanded="false"><i class="glyphicon-list navbar-default"></i> REPORTES <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socioMedidor/lista_socios" ?> >
                                            <i class="icon-list"></i>
                                            Lista de socios activos
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socio/buscar_historial_socio" ?> >
                                            <i class="icon-list"></i>
                                            Historial del socio
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socioMedidor/lista_medidores" ?> >
                                            <i class="icon-time"></i>
                                            Lista de medidores activos
                                        </a></li>
                                    <li><a onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()"
                                           href=<?php echo Yii:: app()->baseUrl . "/index.php/socioMedidor/factura_cortes" ?> >
                                            <i class="icon-off"></i>
                                            Corte de servicio de agua potable
                                        </a></li>
                                </ul> 
                            </li>


                        </ul>

                        <ul class="nav navbar-nav navbar-right">

                            <li><a  onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()" href=<?php echo Yii:: app()->baseUrl . "/index.php/site/logout" ?> >
                                    <i class="icon-off navbar-default"></i>        Salir (<?php echo Yii::app()->user->name ?>)    
                                </a>
                            </li>
                            <li class="dropdown ">
                                <a href="#" onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()" 
                                   class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" 
                                   aria-expanded="false"><i class="icon-user navbar-default"></i> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a  onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()" href=<?php echo Yii:: app()->baseUrl . "/index.php/usuario/cambiar_clave/" . Yii::app()->getSession()->get('id_usu_sismedic'); ?> >
                                            Cambiar clave  
                                        </a></li>
                                    <li><a  onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()" href=<?php echo Yii:: app()->baseUrl . "/index.php/usuario/update/" . Yii::app()->getSession()->get('id_usu_sismedic'); ?> >
                                            Modificar Perfil  
                                        </a></li>
                                    <li></li>

                                </ul> 
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        <?php } // Fin de esta logueado ?>
        <div class="container fondoAdmin">
            <?php echo $content; ?>
        </div>

        <!--Despues del contentido-->
        <!--BOTONES ANTERIOR Y SIGUIENTE-->

        <div class="footer text-center">
            Copyright &copy; <?php echo gmdate('Y'); ?> <br/>
            Todos los derechos reservados.<br/>
            <?php //echo "Diseñado por   ";    ?>
            <a href="http://www.presencesystem.com.ec"  TARGET="_new" onmouseover="mouseoversound.playclip()" onclick="clicksound.playclip()" >PRESENCE SYSTEM</a>
        </div><!-- footer -->
        </div>
        <!--</div> page -->

    </body>
</html>
