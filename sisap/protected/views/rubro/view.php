<?php
/** @var RubroController $this */
/** @var Rubro $model */
$this->breadcrumbs=array(
	'Rubros'=>array('index'),
	$model->ID,
);

$this->menu=array(
    //array('label' => Yii::t('AweCrud.app', 'List') . ' ' . Rubro::label(2), 'icon' => 'list', 'url' => array('index')),
  //  array('label' => Yii::t('AweCrud.app', 'Create') . ' ' . Rubro::label(), 'icon' => 'plus', 'url' => array('create')),
//	array('label' => Yii::t('AweCrud.app', 'Update'), 'icon' => 'pencil', 'url' => array('update', 'id' => $model->ID)),
//    array('label' => Yii::t('AweCrud.app', 'Delete'), 'icon' => 'trash', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->ID), 'confirm' => Yii::t('AweCrud.app', 'Are you sure you want to delete this item?'))),
//    array('label' => Yii::t('AweCrud.app', 'Manage'), 'icon' => 'list-alt', 'url' => array('admin')),
    array('label' =>  'APLICAR A TODOS ' , 'icon' => 'icon-ok', 'url' => array('aplicar_a_todos', 'id' => $model->ID)),
    array('label' =>  'QUITAR A TODOS ' , 'icon' => 'icon-ok', 'url' => array('quitar_a_todos', 'id' => $model->ID)),
     array('label' =>  'APLICAR A LOS SIGUIENTES ', 'icon' => 'plus', 'url' => array('aplicar_a', 'id' => $model->ID)),
     array('label' =>  'NO APLICAR A LOS SIGUIENTES ', 'icon' => 'plus', 'url' => array('no_aplicar_a', 'id' => $model->ID)),
);
?>

<fieldset>
    <legend> <?php echo CHtml::encode($model) ?></legend>


</fieldset>
<?php 

if (isset($model_detalles))
{
    $descripcion_compara= $model->DESCRIPCION;
    $descripcion_base_compara = "CONSUMO DE AGUA POTABLE";
    $posicion_encontrada = strpos($descripcion_compara,$descripcion_base_compara);
    //echo $posicion_encontrada;
    if (($posicion_encontrada !== false) and $posicion_encontrada == 0)
    { //consumo de agua potable ...... ....
?>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data' => $model,
	'attributes' => array(
     //   'ID',
       // 'DESCRIPCION',
       // 'V_UNITARIO',
       // 'PORCEN',
        'FEC_CREACION',
//            'TIPO',
	),
)); ?>
<table class="table table-condensed table-hover table-responsive table-bordered">
        <thead>
        <th>N°</th>
        <!--<th>DETALLE</th>-->
        <th>APELLIDOS Y NOMBRES</th>
        <!--<th>CANTIDAD DE TERRENOS</th>-->
        <!--<th>CANTIDAD TOTAL</th>-->
        <th>Anterior</th>
        <th>Actual</th>
        <th>Consumo</th>
        <th>VALOR A PAGAR</th>
        </thead>
        <tbody>
            <?php 
            $contador=1;
            $suma_valor=0;
            $sumador_consumo=0;
            
            foreach ($model_detalles as $detalle)
            { echo '<tr>';
                echo "<td> ".$contador++.' </td>  ';                 
                echo "<td> ".$detalle->iDFACTURA->iDMEDIDORSOCIO->cODIGOSOCIO->APELLIDO.' </td>  '; 
                echo "<td> ".$detalle->iDFACTURA->CONSUMO_ANTERIOR.' </td>  '; 
                echo "<td> ".$detalle->iDFACTURA->CONSUMO_ACTUAL.' </td>  '; 
                echo "<td> ".$detalle->iDFACTURA->CONSUMO_CALCULADO.' m³ </td>  '; 
                echo "<td> ".$detalle->V_TOTAL.' </td>  '; 
                $suma_valor = $suma_valor + $detalle->V_TOTAL;
                $sumador_consumo = $sumador_consumo + $detalle->iDFACTURA->CONSUMO_CALCULADO;
              echo '</tr>';
            }
            ?>
            <tr>
                <td colspan="4">TOTAL</td>
                <td><?php echo $sumador_consumo.'' ?></td>
                <td><?php echo $suma_valor.'' ?></td>                
            </tr>
        </tbody>
    </table>
<?php 
    } //Fin consumo de agua potable
    else
    { // Inicia para otros rubros excepto consumo de agua potable
        ?>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data' => $model,
	'attributes' => array(
     //   'ID',
       // 'DESCRIPCION',
        'V_UNITARIO',
        'PORCEN',
        'FEC_CREACION',
//            'TIPO',
	),
)); ?>
<table class="table table-condensed table-hover table-responsive table-bordered">
        <thead>
        <th>N°</th>
        <!--<th>DETALLE</th>-->
        <th>APELLIDOS Y NOMBRES</th>
        <!--<th>CANTIDAD DE TERRENOS</th>-->
        <!--<th>CANTIDAD TOTAL</th>-->
        <th>VALOR A PAGAR</th>
        </thead>
        <tbody>
            <?php 
            $contador=1;
            $suma_valor=0;
            
            foreach ($model_detalles as $detalle)
            { echo '<tr>';
                echo "<td> ".$contador++.' </td>  ';                 
                echo "<td> ".$detalle->iDFACTURA->iDMEDIDORSOCIO->cODIGOSOCIO->APELLIDO.' </td>  '; 
                echo "<td> ".$detalle->V_TOTAL.' </td>  '; 
                $suma_valor = $suma_valor + $detalle->V_TOTAL;
              echo '</tr>';
            }
            ?>
            <tr>
                <td colspan="2">TOTAL</td>
                <td><?php echo $suma_valor.'' ?></td>
            </tr>
        </tbody>
    </table>
<?php
    } //Fin para otros rubros excepto consumo de agua potable
}; // FIN si existen aplicados al rubro
?>