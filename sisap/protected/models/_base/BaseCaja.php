<?php

/**
 * This is the model base class for the table "caja".
 * DO NOT MODIFY THIS FILE! It is automatically generated by AweCrud.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Caja".
 *
 * Columns in table "caja" available as properties of the model,
 * followed by relations of table "caja" available as properties of the model.
 *
 * @property string $ID
 * @property string $FECHA
 * @property string $RECAUDADOR
 * @property integer $FACTURA_DESDE
 * @property integer $FACTURA_HASTA
 * @property integer $TOTAL_FACTURAS
 * @property integer $RECIBO_DESDE
 * @property integer $RECIBO_HASTA
 * @property integer $TOTAL_RECIBOS
 * @property string $TOTAL
 * @property string $EFECTIVO
 * @property string $TARJETAS
 * @property string $BANCOS
 * @property string $PENDIENTES_PAGO
 * @property string $BASE_IMPONIBLE
 * @property integer $IVA
 * @property string $IMPORTE_IVA
 * @property integer $MOV_CAJA_DESDE
 * @property integer $MOV_CAJA_HASTA
 * @property string $TOTAL_INGRESOS
 * @property string $TOTAL_SALIDAS
 * @property string $TOTAL_CAJA
 * @property string $RECUENTO
 * @property string $DESCUADRE
 * @property string $DESCRIPCION
 * @property integer $COD_USUARIO
 * @property string $FECHA_ACTUALIZACION
 *
 * @property Usuario $rECAUDADOR
 * @property MovimientoCaja[] $movimientoCajas
 */
abstract class BaseCaja extends AweActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'caja';
    }

    public static function representingColumn() {
        return 'FECHA_ACTUALIZACION';
    }

    public function rules() {
        return array(
            array('RECAUDADOR, FECHA_ACTUALIZACION', 'required'),
            array('FACTURA_DESDE, FACTURA_HASTA, TOTAL_FACTURAS, RECIBO_DESDE, RECIBO_HASTA, TOTAL_RECIBOS, IVA, MOV_CAJA_DESDE, MOV_CAJA_HASTA, COD_USUARIO', 'numerical', 'integerOnly'=>true),
            array('RECAUDADOR', 'length', 'max'=>11),
            array('TOTAL, EFECTIVO, TARJETAS, BANCOS, PENDIENTES_PAGO, BASE_IMPONIBLE, IMPORTE_IVA, TOTAL_INGRESOS, TOTAL_SALIDAS, TOTAL_CAJA, RECUENTO, DESCUADRE', 'length', 'max'=>8),
            array('DESCRIPCION', 'length', 'max'=>3000),
            array('FECHA', 'safe'),
            array('FECHA, FACTURA_DESDE, FACTURA_HASTA, TOTAL_FACTURAS, RECIBO_DESDE, RECIBO_HASTA, TOTAL_RECIBOS, TOTAL, EFECTIVO, TARJETAS, BANCOS, PENDIENTES_PAGO, BASE_IMPONIBLE, IVA, IMPORTE_IVA, MOV_CAJA_DESDE, MOV_CAJA_HASTA, TOTAL_INGRESOS, TOTAL_SALIDAS, TOTAL_CAJA, RECUENTO, DESCUADRE, DESCRIPCION, COD_USUARIO', 'default', 'setOnEmpty' => true, 'value' => null),
            array('ID, FECHA, RECAUDADOR, FACTURA_DESDE, FACTURA_HASTA, TOTAL_FACTURAS, RECIBO_DESDE, RECIBO_HASTA, TOTAL_RECIBOS, TOTAL, EFECTIVO, TARJETAS, BANCOS, PENDIENTES_PAGO, BASE_IMPONIBLE, IVA, IMPORTE_IVA, MOV_CAJA_DESDE, MOV_CAJA_HASTA, TOTAL_INGRESOS, TOTAL_SALIDAS, TOTAL_CAJA, RECUENTO, DESCUADRE, DESCRIPCION, COD_USUARIO, FECHA_ACTUALIZACION', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
            'rECAUDADOR' => array(self::BELONGS_TO, 'Usuario', 'RECAUDADOR'),
            'movimientoCajas' => array(self::HAS_MANY, 'MovimientoCaja', 'ID_CAJA'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'ID' => Yii::t('app', 'ID'),
                'FECHA' => Yii::t('app', 'Fecha'),
                'RECAUDADOR' => Yii::t('app', 'Recaudador'),
                'FACTURA_DESDE' => Yii::t('app', 'Factura Desde'),
                'FACTURA_HASTA' => Yii::t('app', 'Factura Hasta'),
                'TOTAL_FACTURAS' => Yii::t('app', 'Total Facturas'),
                'RECIBO_DESDE' => Yii::t('app', 'Recibo Desde'),
                'RECIBO_HASTA' => Yii::t('app', 'Recibo Hasta'),
                'TOTAL_RECIBOS' => Yii::t('app', 'Total Recibos'),
                'TOTAL' => Yii::t('app', 'Total'),
                'EFECTIVO' => Yii::t('app', 'Efectivo'),
                'TARJETAS' => Yii::t('app', 'Tarjetas'),
                'BANCOS' => Yii::t('app', 'Bancos'),
                'PENDIENTES_PAGO' => Yii::t('app', 'Pendientes Pago'),
                'BASE_IMPONIBLE' => Yii::t('app', 'Base Imponible'),
                'IVA' => Yii::t('app', 'Iva'),
                'IMPORTE_IVA' => Yii::t('app', 'Importe Iva'),
                'MOV_CAJA_DESDE' => Yii::t('app', 'Mov Caja Desde'),
                'MOV_CAJA_HASTA' => Yii::t('app', 'Mov Caja Hasta'),
                'TOTAL_INGRESOS' => Yii::t('app', 'Total Ingresos'),
                'TOTAL_SALIDAS' => Yii::t('app', 'Total Salidas'),
                'TOTAL_CAJA' => Yii::t('app', 'Total Caja'),
                'RECUENTO' => Yii::t('app', 'Recuento'),
                'DESCUADRE' => Yii::t('app', 'Descuadre'),
                'DESCRIPCION' => Yii::t('app', 'Descripcion'),
                'COD_USUARIO' => Yii::t('app', 'Cod Usuario'),
                'FECHA_ACTUALIZACION' => Yii::t('app', 'Fecha Actualizacion'),
                'rECAUDADOR' => null,
                'movimientoCajas' => null,
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('ID', $this->ID, true);
        $criteria->compare('FECHA', $this->FECHA, true);
        $criteria->compare('RECAUDADOR', $this->RECAUDADOR);
        $criteria->compare('FACTURA_DESDE', $this->FACTURA_DESDE);
        $criteria->compare('FACTURA_HASTA', $this->FACTURA_HASTA);
        $criteria->compare('TOTAL_FACTURAS', $this->TOTAL_FACTURAS);
        $criteria->compare('RECIBO_DESDE', $this->RECIBO_DESDE);
        $criteria->compare('RECIBO_HASTA', $this->RECIBO_HASTA);
        $criteria->compare('TOTAL_RECIBOS', $this->TOTAL_RECIBOS);
        $criteria->compare('TOTAL', $this->TOTAL, true);
        $criteria->compare('EFECTIVO', $this->EFECTIVO, true);
        $criteria->compare('TARJETAS', $this->TARJETAS, true);
        $criteria->compare('BANCOS', $this->BANCOS, true);
        $criteria->compare('PENDIENTES_PAGO', $this->PENDIENTES_PAGO, true);
        $criteria->compare('BASE_IMPONIBLE', $this->BASE_IMPONIBLE, true);
        $criteria->compare('IVA', $this->IVA);
        $criteria->compare('IMPORTE_IVA', $this->IMPORTE_IVA, true);
        $criteria->compare('MOV_CAJA_DESDE', $this->MOV_CAJA_DESDE);
        $criteria->compare('MOV_CAJA_HASTA', $this->MOV_CAJA_HASTA);
        $criteria->compare('TOTAL_INGRESOS', $this->TOTAL_INGRESOS, true);
        $criteria->compare('TOTAL_SALIDAS', $this->TOTAL_SALIDAS, true);
        $criteria->compare('TOTAL_CAJA', $this->TOTAL_CAJA, true);
        $criteria->compare('RECUENTO', $this->RECUENTO, true);
        $criteria->compare('DESCUADRE', $this->DESCUADRE, true);
        $criteria->compare('DESCRIPCION', $this->DESCRIPCION, true);
        $criteria->compare('COD_USUARIO', $this->COD_USUARIO);
        $criteria->compare('FECHA_ACTUALIZACION', $this->FECHA_ACTUALIZACION, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array_merge(array(
        ), parent::behaviors());
    }
}