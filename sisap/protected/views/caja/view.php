<?php
/** @var CajaController $this */
/** @var Caja $model */
$this->breadcrumbs=array(
	'Cajas'=>array('index'),
	$model->ID,
);

$this->menu=array(
    //array('label' => Yii::t('AweCrud.app', 'List') . ' ' . Caja::label(2), 'icon' => 'list', 'url' => array('index')),
    array('label' => Yii::t('AweCrud.app', 'Create') . ' ' . Caja::label(), 'icon' => 'plus', 'url' => array('create')),
	array('label' => Yii::t('AweCrud.app', 'Update'), 'icon' => 'pencil', 'url' => array('update', 'id' => $model->ID)),
    array('label' => Yii::t('AweCrud.app', 'Delete'), 'icon' => 'trash', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->ID), 'confirm' => Yii::t('AweCrud.app', 'Are you sure you want to delete this item?'))),
    array('label' => Yii::t('AweCrud.app', 'Manage'), 'icon' => 'list-alt', 'url' => array('admin')),
);
?>

<fieldset>
    <legend><?php echo Yii::t('AweCrud.app', 'View') . ' ' . Caja::label(); ?> <?php echo CHtml::encode($model) ?></legend>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data' => $model,
	'attributes' => array(
        'ID',
        'FECHA',
        array(
			'name'=>'RECAUDADOR',
			'value'=>($model->rECAUDADOR !== null) ? CHtml::link($model->rECAUDADOR, array('/usuario/view', 'id' => $model->rECAUDADOR->id)).' ' : null,
			'type'=>'html',
		),
        'FACTURA_DESDE',
        'FACTURA_HASTA',
        'TOTAL_FACTURAS',
        'RECIBO_DESDE',
        'RECIBO_HASTA',
        'TOTAL_RECIBOS',
        'TOTAL',
        'EFECTIVO',
        'TARJETAS',
        'BANCOS',
        'PENDIENTES_PAGO',
        'BASE_IMPONIBLE',
        'IVA',
        'IMPORTE_IVA',
        'MOV_CAJA_DESDE',
        'MOV_CAJA_HASTA',
        'TOTAL_INGRESOS',
        'TOTAL_SALIDAS',
        'TOTAL_CAJA',
        'RECUENTO',
        'DESCUADRE',
        'DESCRIPCION',
        'COD_USUARIO',
        'FECHA_ACTUALIZACION',
	),
)); ?>
</fieldset>