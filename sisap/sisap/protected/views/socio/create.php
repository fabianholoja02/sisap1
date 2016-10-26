<?php
/** @var SocioController $this */
/** @var Socio $model */
$this->breadcrumbs=array(
	$model->label(2) => array('index'),
	Yii::t('AweCrud.app', 'Create'),
);

$this->menu=array(
    //array('label' => Yii::t('AweCrud.app', 'List').' '.Socio::label(2), 'icon' => 'list', 'url' => array('index')),
    array('label' => Yii::t('AweCrud.app', 'Listado Socios'), 'icon' => 'list-alt', 'url' => array('admin')),
);
?>
<fieldset>
    <legend>INGRESAR DATOS DEL SOCIO NUEVO </legend>
    <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
</fieldset>