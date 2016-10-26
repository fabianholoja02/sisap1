<div class="form">
    <?php
    /** @var MedidorController $this */
    /** @var Medidor $model */
    /** @var AweActiveForm $form */
    $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
        'id' => 'medidor-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ));
    ?>

    <p class="note">
        <?php echo Yii::t('AweCrud.app', 'Fields with') ?> <span class="required">*</span>
    <?php echo Yii::t('AweCrud.app', 'are required') ?>.    </p>

    <?php echo $form->errorSummary($model) ?>

    <?php echo $form->textFieldRow($model, 'NUMERO', array('class' => 'span3', 'maxlength' => 20)) ?>
    <?php echo $form->textFieldRow($model, 'CONSUMO_INICIAL', array('class' => 'span3')) ?>
        <?php echo $form->textFieldRow($model, 'ORDEN_RECORIDO', array('class' => 'span3')) ?>
    <div class="form-actions">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'htmlOptions' => array(
                'id' => 'botonid',
            ),
            'label' => $model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
        ));
        ?>
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            //'buttonType'=>'submit',
            'label' => Yii::t('AweCrud.app', 'Cancel'),
            'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
        ));
        ?>
    </div>

<?php $this->endWidget(); ?>
</div>