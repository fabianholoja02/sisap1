<div class="form">
    <?php
    /** @var RubroController $this */
    /** @var Rubro $model */
    /** @var AweActiveForm $form */
    $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'id' => 'rubro-form',
    'enableAjaxValidation' => true,
    'enableClientValidation'=> false,
    )); ?>

    <p class="note">
        <?php echo Yii::t('AweCrud.app', 'Fields with') ?> <span class="required">*</span>
        <?php echo Yii::t('AweCrud.app', 'are required') ?>.    </p>

    <?php echo $form->errorSummary($model) ?>

                            <?php echo $form->textFieldRow($model, 'DESCRIPCION', array('class' => 'span5', 'maxlength' => 50)) ?>
                        <?php echo $form->textFieldRow($model, 'V_UNITARIO', array('class' => 'span5', 'placeholder' => 'Ejm: 20.50', 'maxlength' => 6)) ?>
                        <?php //echo $form->textFieldRow($model, 'PORCEN', array('class' => 'span5')) ?>
                         <?php echo $form->dropDownListRow($model, 'PORCEN', array('Seleccione: __ %', 
                                                 '1', '2', '3', '4', '5', '6', '7', '8', '9', '10',
                                                '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
                                                '21', '22', '23', '24', '25', '26', '27', '28', '29', '30',
                                                '31', '32', '33', '34', '35', '36', '37', '38', '39', '40',
                                                '41', '42', '43', '44', '45', '46', '47', '48', '49', '50',
                                                '51', '52', '53', '54', '55', '56', '57', '58', '59', '60',
                                                '61', '62', '63', '64', '65', '66', '67', '68', '69', '70',
                                                '71', '72', '73', '74', '75', '76', '77', '78', '79', '80',
                                                '81', '82', '83', '84', '85', '86', '87', '88', '89', '90',
                                                '91', '92', '93', '94', '95', '96', '97', '98', '99', '100'
                            )); ?>
                        <?php //echo $form->textFieldRow($model, 'FEC_CREACION', array('prepend'=>'<i class="icon-calendar"></i>')) 
                         echo  $form->labelEx($model,'FEC_CREACION');
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'name' => 'FEC_CREACION',
                                     'model' => $model,
                                    'attribute' => 'FEC_CREACION',
                                    'language' => 'es',
                                    'htmlOptions' => array( 'class' => 'span2'),   //'htmlOptions' => array('readonly' => "readonly", 'class' => 'span3'),
                                    'options' => array(
                                        'autoSize' => true,
                                        'dateFormat' => 'yy-mm-dd',
                                        'buttonImage' => Yii::app()->baseUrl . '/images/pagina/calendar1.png',
                                        'buttonImageOnly' => true,
                                        'buttonText' => 'SELECCIONAR FECHA DEL EVENTO O DE CREACIÓN.<br><b> NOTA:</b> El interes aplica desde esta fecha',
                                        'selectOtherMonths' => true,
                                        'showAnim' => 'slide',
                                        'showButtonPanel' => true,
                                        'showOn' => 'button',
                                        'showOtherMonths' => true,
                                        'changeMonth' => 'true',
                                        'changeYear' => 'true',
                                    ),
                                        )
                                );
                        
                        ?>
                         <?php echo $form->dropDownListRow($model, 'TIPO', array(
                             '1'=>'Factura', 
                             '2'=>'Recibo',                                                
                            )); ?>
                <div class="form-actions">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
		)); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
			//'buttonType'=>'submit',
			'label'=> Yii::t('AweCrud.app', 'Cancel'),
			'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
		)); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>