<?php
/** @var FacturaController $this */
/** @var Factura $model */
$this->breadcrumbs=array(
	'Facturas'=>array('index'),
	$model->ID,
);

$this->menu=array(
    //array('label' => Yii::t('AweCrud.app', 'List') . ' ' . Factura::label(2), 'icon' => 'list', 'url' => array('index')),
    array('label' => Yii::t('AweCrud.app', 'Create') . ' ' . Factura::label(), 'icon' => 'plus', 'url' => array('create')),
	array('label' => Yii::t('AweCrud.app', 'Update'), 'icon' => 'pencil', 'url' => array('update', 'id' => $model->ID)),
    array('label' => Yii::t('AweCrud.app', 'Delete'), 'icon' => 'trash', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->ID), 'confirm' => Yii::t('AweCrud.app', 'Are you sure you want to delete this item?'))),
    array('label' => Yii::t('AweCrud.app', 'Manage'), 'icon' => 'list-alt', 'url' => array('admin')),
);
?>

<fieldset>
    <legend><?php echo Yii::t('AweCrud.app', 'View') . ' ' . Factura::label(); ?> <?php echo CHtml::encode($model) ?></legend>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data' => $model,
	'attributes' => array(
        'ID',
        array(
			'name'=>'ID_MEDIDOR_SOCIO',
			'value'=>($model->iDMEDIDORSOCIO !== null) ? CHtml::link($model->iDMEDIDORSOCIO, array('/socioMedidor/view', 'ID' => $model->iDMEDIDORSOCIO->ID)).' ' : null,
			'type'=>'html',
		),
        'CONSUMO_ANTERIOR',
        'CONSUMO_ACTUAL',
        'CONSUMO_CALCULADO',
        'MES_CONSUMO',
        'ANIO_CONSUMO',
        'ESTADO',
        array(
                'name'=>'TIPO',
                'type'=>'boolean'
            ),
	),
)); ?>
</fieldset>