<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = array(
    'Autenticado',
);

?>
<div class="page-header">
    <div class="container">
        <ol class="breadcrumb btn-success">
            <center>
                <li>BIENVENIDO <?php echo Yii::app()->getSession()->get('nombre_usuario_sismedic'); ?>  AL SISTEMA DE AGUA POTABLE COMUNIDAD: <strong><i>COYOCTOR</i></strong></li>
            </center>

        </ol>
    </div>
</div>

<div class="container theme-showcase" role="main">
    <div class="jumbotron">
        <h3>Sistema de Agua Potable de la Comunidad de Coyoctor</h3>
        <p align="justify">
            El Municipio Comunitario de El Tambo ha priorizado como obra importante para la comunidad de Coyoctor la construcción del sistema de agua potable, cuya inversión será de aproximadamente 250.000 dólares. El proyecto será financiado con un crédito del Banco del Estado.

            En días anteriores, técnicos municipales, funcionarios del Banco del Estado y Roberto Ochoa, consultor del proyecto, hicieron un recorrido del área donde se implementará esta obra, que beneficiará a más de 120 familias de ésta comunidad. El sistema comprende desde la captación que está ubicada en el sector “Visisinga”, que se encuentra dentro del Parque Nacional Sangay, cuya conducción comprende alrededor de ocho kilómetros hasta el lugar donde se construirá la planta de tratamiento.

            La obra será emplazada en un terreno que será donado por un miembro de la comunidad a nombre del Municipio, esto se encuentra en trámite. 
        </p>
    </div>
</div>

