<?PHP 
//COMPARANDO FECHAS
//$fecha_actual = date("Y-n-j");
//                        $hora_actual = date("H:i:s");
//                        $fecha_reunion = $model_reunion->FECHA;
//                            $datetime1 = date_create($fecha_reunion);
//                            $datetime2 = date_create($fecha_actual);
//                            $interval = date_diff($datetime1, $datetime2);
//                            //echo $interval->format('%R%a días'); //Da +2 dias
//                            if($interval->format('%a')==1)
//                            {
//                                echo "Fue ayer";
//                            }
//                            else
//                            {
//                            echo $interval->format('%a');
//                            }
//CON TILDES SOLO UN TEXTO DETERMINADO

                    setlocale(LC_TIME,"spanish"); 
                    $dateutf = '<td class="">' .(strftime("%A, %d de %B de %Y",strtotime($row[$letra]))). '</td>';
                    $dateutf = ucfirst(iconv("ISO-8859-1","UTF-8",$dateutf));
                    echo $dateutf;


//REFRESCA AUTOMATICAMENTE PAGINA EN PHP CADA 5 MINUTOS
$self = $_SERVER['PHP_SELF']; //Obtenemos la página en la que nos encontramos
header("refresh:300; url=$self"); //Refrescamos cada 300 segundos

?>

<?php $model = Pago::model()->findAll(array(
'condition'=>'id_conductor=:conductor AND pag_con=:concepto', 
'params'=>array(':conductor' => $conductor, ':concepto' => 'M'), 
'select'=>'id, pag_con, pag_fec_ing'
));
?>




<?php echo $form->dropDownListRow($model, 'credito%', array(
                '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10',
                '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20',
                '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30',
                '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40',
                '41' => '41', '42' => '42', '43' => '43', '44' => '44', '45' => '45', '46' => '46', '47' => '47', '48' => '48', '49' => '49', '50' => '50'
                ), array('class' => 'span1', 'maxlength' => 30)).' <b>%</b>' ?> 


// Actualizar estado de todo aagua 
UPDATE `TERRENO` SET `ESTADO`=0  WHERE  ESTADO like 'Transferido'
// 



echo "<script>javascript:history.go(-2)</script>";


<!--CODIGO  PARA EJECUTAR SENTENCIAS SQL-->
Será arrojada una excepción si ocurre un error durante la ejecución de una sentencia SQL.

$rowCount=$command->execute();   // ejecuta una sentencia SQL sin resultados
$dataReader=$command->query();   // ejecuta una consulta SQL
$rows=$command->queryAll();      // consulta y devuelve todas las filas de resultado
$row=$command->queryRow();       // consulta y devuelve la primera fila de resultado
$column=$command->queryColumn(); // consulta y devuelve la primera columna de resultado
$value=$command->queryScalar();  // consulta y devuelve el primer campo en la primer fila


<?php /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */ ?>
<!--AUTOCOMPLETAR-->
<div class="span1">
    <h4>Porcentaje del terreno:</h4>
<?php
$this->widget('bootstrap.widgets.TbTypeahead', array(
    'name' => 'PORCENTAJE',
    'options' => array(
        'source' => array(
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
        ),
        'items' => 4,
        'matcher' => "js:function(item) {
                                            return ~item.toLowerCase().indexOf(this.query.toLowerCase());
                                        }",
    ),
));
?><h3>%</h3>
</div>




<?php

$connection_agua = Yii::app()->db1;
$connection_jurechgis = Yii::app()->db;


$sql = "CALL buscaCodigoBarra( " . $Codigo_usuario_lbase . " );";
                            $command = $connection_agua->createCommand($sql);
                            //$rows = $command->execute();
                            $rows = $command->queryRow();
                            $CODIGObARRA = $rows['COD_BARRA'];
                            $Observacion = $rows['OBS'];
                            
                            
 /*******************************USANDO LOS MODELOS****************************/


$model_transporte = TTransporte::model()->findAllBySql(''
        . 'SELECT *,  TIMESTAMPDIFF(DAY,`mat_fexpir`,now()) as codificacion '
        . 'FROM `tTransporte` WHERE now()>=`mat_fexped` '
        . 'and now() <= `mat_fexpir` ORDER BY  `mat_fexpir` asc LIMIT 0, 20');
//$model_transporte->
foreach ($model_transporte as $transporte) {
    if ($transporte->codificacion > -30) {
        echo '<tr bgcolor="red">';
    } else {
        if ($transporte->codificacion > -60) {
            echo '<tr bgcolor="orange">';
        } else {
            if ($transporte->codificacion > -90) {
                echo '<tr bgcolor="yellow">';
            } else {
                echo '<tr bgcolor="green">';
            }
        }
    }
};
?>




<?php
$this->widget('zii.widgets.grid.CGridView', array(
'id' => 'DiaFeriados-grid',
 'dataProvider' => $model->search(),
 'filter' => $model,
 'columns' => array(
'fecha' => array(
'name' => 'fecha',
 'header' => 'Fecha',
 'value' => '$data->fecha',
 'htmlOptions' => array('style' => 'text-align: center', 'width' => '75px'),
 ),
 'motivo' => array(
'name' => 'motivo',
 'header' => 'Motivo',
 'value' => '$data->motivo',
 'htmlOptions' => array('style' => 'text-align: center', 'width' => '75px'),
 ),
 'repetir' => array(
'name' => 'repetir',
 'header' => 'Repetir',
 'value' => '($data->repetir==1)?"<span class="icon-ok"></span>":"Mal"',
 'htmlOptions' => array('style' => 'text-align: center', 'width' => '75px'),
 ),
 array(
'class' => 'CButtonColumn',
 ),
 ),
));

?>
//Buscar por un criterio dado
print_r(DiaFeriado::model()->findAllBySql('SELECT * FROM dia_feriado'));
?>

<?php
//////////////   SESIONES ///////////////
//CREAR SESION
Yii::app()->getSession()->add('nombre', $this->id); //pk del usuario
//UTILIZAR SESION
Yii::app()->getSession()->get('nombre');
//ELIMINAR SESION
Yii::app()->getSession()->remove('nombre');
?>
<!--/////////////////////////////////////////////////////-->
<!--Ingresar calendario desde versiones antiguas de yii framework-->
<?php echo $form->labelEx($model, 'vencimiento_garantia'); ?>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array('model' => $model,
    'attribute' => 'vencimiento_garantia',
    'language' => 'es',
    'options' => array(
        'dateFormat' => 'yy-mm-dd',
        'constrainInput' => 'false',
        'duration' => 'fast',
        'ShowAnim' => 'slide'
    ),
));
?>
<?php echo $form->error($model, 'vencimiento_garantia'); ?>
<!--*************************************************************************************************-->
<?php
//echo $form->datepickerRow($model, 'FECHA_REGISTRO', array('prepend'=>'<i class="icon-calendar"></i>')) 
echo $form->labelEx($model, 'FECHA_REGISTRO');
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name' => 'FECHA_REGISTRO',
    'model' => $model,
    'attribute' => 'FECHA_REGISTRO',
    'language' => 'es',
    'htmlOptions' => array('class' => 'span3'), //'htmlOptions' => array('readonly' => "readonly", 'class' => 'span3'),
    'options' => array(
        'autoSize' => true,
        'dateFormat' => 'yy-mm-dd',
        'buttonImage' => Yii::app()->baseUrl . '/images/pagina/calendar1.png',
        'buttonImageOnly' => true,
        'buttonText' => 'SELECCIONAR FECHA DEL REGISTRO',
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
<?php echo $form->error($model, 'FECHA_REGISTRO'); ?>
<!--////////////////////////////////////////////////////-->
<!-- Código para subir foto -->

<div class="row">
    <?php echo $form->labelEx($model, 'Foto'); ?>
    <?php echo CHtml::activeFileField($model, 'Foto'); //con esto levantamos la imagen   ?>  
    <?php echo $form->error($model, 'Foto'); ?>
</div>
<?php if ($model->isNewRecord != '1') { ?>
    <div class="row">
        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/fotos/' . $model->Foto, "Foto", array("width" => 200)); // La Imagen se muestra aquí si la página es la página de actualización  ?>  
    </div>
<?php } ?>
<!-- Termina código para subir foto -->


<!--TABLA EN HTML-->
<table  with="100%" align="center" border="1" bordercolor="#efefef">
    <TR>
        <td>

        </td>
    </TR>
</table>



<!-- DESPLEGABLES -->
 <a class="" data-toggle="collapse" href="#collapseHereditarias" aria-expanded="false" aria-controls="collapseHereditarias">
  <?php  echo  CHtml::image(Yii::app()->request->baseUrl . '/images/iconos_del_sistema/informacion.png', "..."
          , array("width" => 50)); ?>
 </a>                    
 <div class="collapse" id="collapseHereditarias">
                        <div class="well text-success row text-center fondoClaro">
                            <h4 class="alert-info"> ANTECEDENTES HEREDITARIOS </h4>
                           Causas de muerte, malformaciones congénitas, diabetes, 
                           cardiopatías, hipertensión arterial, infartos, 
                           ateroesclerosis, accidentes vasculares,
                          <br>  neuropatías, tuberculosis, artropatías, 
                           hemopatías, sida, sífilis, hemopatías, neoplasias, consanguinidad, 
                           alcoholismo, toxicomanías.
                        </div>
 </div>