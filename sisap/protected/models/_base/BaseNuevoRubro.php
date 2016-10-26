<?php

/**
 * This is the model base class for the table "nuevo_rubro".
 * DO NOT MODIFY THIS FILE! It is automatically generated by AweCrud.
 * If any changes are necessary, you must set or override the required
 * property or method in class "NuevoRubro".
 *
 * Columns in table "nuevo_rubro" available as properties of the model,
 * followed by relations of table "nuevo_rubro" available as properties of the model.
 *
 * @property string $COD_RUBRO
 * @property string $RUBRO
 * @property string $FECHA_CREACION
 * @property integer $APLICA
 * @property string $VALOR
 * @property integer $ID_USUARIO
 * @property string $FECHA_ACTUALIZACION
 * @property string $COD_JUNTA
 * @property string $ANIO_COBRO
 * @property integer $APLICAR_X_AREA_TOTAL
 *
 * @property NuevoDetalle[] $nuevoDetalles
 */
abstract class BaseNuevoRubro extends AweActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'nuevo_rubro';
    }

    public static function representingColumn() {
        return 'RUBRO';
    }

    public function rules() {
        return array(
            array('RUBRO', 'required'),
            array('APLICA, ID_USUARIO, COD_JUNTA, APLICAR_X_AREA_TOTAL', 'numerical', 'integerOnly'=>true),
            array('RUBRO', 'length', 'max'=>200),
            array('VALOR', 'length', 'max'=>6),
            array('ANIO_COBRO', 'length', 'max'=>4),
            array('FECHA_CREACION', 'safe'),
            array('FECHA_CREACION, APLICA, VALOR, ID_USUARIO, COD_JUNTA, ANIO_COBRO, APLICAR_X_AREA_TOTAL', 'default', 'setOnEmpty' => true, 'value' => null),
            array('COD_RUBRO, RUBRO, FECHA_CREACION, APLICA, VALOR, ID_USUARIO, FECHA_ACTUALIZACION, COD_JUNTA, ANIO_COBRO, APLICAR_X_AREA_TOTAL', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
            'nuevoDetalles' => array(self::HAS_MANY, 'NuevoDetalle', 'COD_RUBRO'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'COD_RUBRO' => Yii::t('app', 'Rubro N°'),
                'RUBRO' => Yii::t('app', 'Rubro'),
                'FECHA_CREACION' => Yii::t('app', 'Fecha de creación'),
                'APLICA' => Yii::t('app', 'Aplica junta local'), //0.-Junta general, 1.-Junta Local 
                'VALOR' => Yii::t('app', 'Valor'),
                'ID_USUARIO' => Yii::t('app', 'Modificado por'),
                'FECHA_ACTUALIZACION' => Yii::t('app', 'Modificado el'),
                'COD_JUNTA' => Yii::t('app', 'Junta Local'),
                'ANIO_COBRO' => Yii::t('app', 'Año de cobro'),
                'APLICAR_X_AREA_TOTAL' => Yii::t('app', 'Aplicar por área de terreno'),
                'nuevoDetalles' => null,
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('COD_RUBRO', $this->COD_RUBRO, true);
        $criteria->compare('RUBRO', $this->RUBRO, true);
        $criteria->compare('FECHA_CREACION', $this->FECHA_CREACION, true);
        $criteria->compare('APLICA', $this->APLICA);
        $criteria->compare('VALOR', $this->VALOR, true);
        $criteria->compare('ID_USUARIO', $this->ID_USUARIO);
        $criteria->compare('FECHA_ACTUALIZACION', $this->FECHA_ACTUALIZACION, true);  
        $criteria->compare('APLICAR_X_AREA_TOTAL', $this->APLICAR_X_AREA_TOTAL);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    public function searchLocal() {
        
        $criteria = new CDbCriteria;
        $criteria->compare('COD_RUBRO', $this->COD_RUBRO, true);
        $criteria->compare('RUBRO', $this->RUBRO, true);
        $criteria->compare('FECHA_CREACION', $this->FECHA_CREACION , true);
        $criteria->compare('APLICA', $this->APLICA); //0.-Junta general, 1.-Junta Local
        $criteria->compare('VALOR', $this->VALOR, true);    
         $criteria->compare('COD_JUNTA', Yii::app()->getSession()->get('junta_local'), true); //Solo rubros de junta local
        $criteria->compare('ANIO_COBRO', date('Y'), true);
        $criteria->compare('APLICAR_X_AREA_TOTAL', $this->APLICAR_X_AREA_TOTAL);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array_merge(array(
        ), parent::behaviors());
    }
}