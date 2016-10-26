<?php 
header('Cache-Control: no-store, no-cache, must-revalidate');     // HTTP/1.1

?>
<?php /*
 * ANALIZAMOS, DISE�AMOS Y PROGRAMAMOS TUS IDEAS  
 *    EN SISTEMAS INFORM�TICOS PARA LA WEB
 *            Ing. Juan Tierra
 *            PRESENCE SYSTEM

 */ 
$this->breadcrumbs=array(
	$model->label(2) => array('index'),
	Yii::t('app', $model->ID) => array('view', 'id'=>$model->ID),
	Yii::t('AweCrud.app', 'facturar'),
);
?>

<fieldset>
<?php echo $this->renderPartial('_form_factura', array('model' => $model)); ?>
<?php echo $this->renderPartial('_calculadora', array('model' => $model)); ?>
    <?php if (Yii::app()->user->hasFlash('success')): ?>
                        <div class="info panel-title alert-success info" id="flashmensaje">
                            <h3>¡Bien echo!</h3>
                            <?php echo Yii::app()->user->getFlash('success'); ?>
                        </div>
                    <?php endif; ?>
    <?php 
    Yii::app()->clientScript->registerScript(
            'flashmensaje',
            '$(".info").animate({opacity: 1.0}, 9000).fadeOut("slow");',
            CClientScript::POS_READY            
            )
    
    ?>
</fieldset>

