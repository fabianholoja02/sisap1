<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Autenticar',
);
?>

<!--<h1>Autenticar</h1>-->

<div class="container">
    <ol class="breadcrumb btn-success">
        <center>
            <li><strong>SISTEMA DE AGUA POTABLE DE LA COMUNIDAD DE COYOCTOR</strong></li>
        </center>
    </ol>
    <ol class="breadcrumb btn-default">
        <marquee>  
            <img src="<?php echo Yii:: app()->baseUrl . '/images/coyoctor/logo_coyoctor.jpg' ?>" width="50%">
        </marquee>
    </ol>
</div>
<div class="panel panel-info">
    <!-- Default panel contents -->
    <div class="panel-heading"><center>Ingrese sus credenciales</center></div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <div class="col-md-2 col-md-offset-5">
            <div class="row-fluid  text-right">
                <?php //echo $form->labelEx($model, 'Usuario'); ?>
                <?php //echo $form->textFieldRow($model, 'username', array('class' => 'span5', 'maxlength' => 50)) ?>
                <?php echo '<b> </b>' . $form->textField($model, 'username', array('class' => '', 'placeholder' => "Usuario.", 'value' => '', 'maxlength' => 100)); ?>
                <br>
                <?php echo $form->error($model, 'username'); ?>
            </div>
        </div>
        <div class="col-md-2 col-md-offset-5">
            <div class="row-fluid text-right">
                <?php //echo $form->labelEx($model, 'Clave'); ?>
                <?php echo '<b>    </b>' . $form->passwordField($model, 'password', array('class' => '', 'placeholder' => "Clave de seguridad", 'value' => '', 'maxlength' => 100)); ?>
                <br>
                <?php echo $form->error($model, 'password'); ?> 
                <p class="hint">
                    <!-- Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.-->
                </p>
            </div>
        </div>
<!--        <div class="col-md-2 col-md-offset-5">
            <div class="row row-fluid span12">
                <?php // echo $form->checkBox($model, 'rememberMe').$form->label($model, 'rememberMe'); ?>
                <?php // echo $form->error($model, 'rememberMe'); ?>
            </div>
        </div>-->
        <div class="col-md-5 col-md-offset-4">
            <div class="row buttons">
                <?php echo CHtml::submitButton('Autenticar', array("class" => "btn btn-lg btn-primary btn-block")); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>












