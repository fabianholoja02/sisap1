<?php

class RubroController extends AweController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
    public $layout = '//layouts/column2';

public function filters() {
	return array(
			'accessControl', 
			);
}

public function accessRules() {
	return array(
			array('allow',
				'actions'=>array(''),
				'users'=>array('*'),
				),
			array('allow', 
				'actions'=>array(),
				'users'=>array('@'),
				),
			array('allow', 
				'actions'=>array('aplicar_a','no_aplicar_a','aplicar_a_todos','quitar_a_todos','buscarRecibos','buscarFacturas','view', 'create','update','admin','delete'),
				 'expression' => '!Yii::app()->user->isGuest && Usuario::model()->findByPk(Yii::app()->user->id)->esAdministrador()',
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
        public function actionAplicar_a ($id)
        {

            $model = Rubro::model()->findByPk($id);
            // +++ APLICAR A USUARIO
            $model_asignar_detalle = new Detalle();

             if (isset($_POST['Detalle'])) {
                    $model_asignar_detalle->attributes = $_POST['Detalle'];

                    // EN ID_FACTURA .- Es el Codigo de socio
                    $socio = $model_asignar_detalle->ID_FACTURA;
                    //BUSCAR EL RECIBO DADO EL CODIGO DEL USUARIO
        //             $connection = Yii::app()->db;
                    if ($model->TIPO == 1) //FACTURA
                    {   $model_factura = Factura::model()->findAllBySql("CALL `buscar_factura_x_socio`(".$socio.", 1)"); }
                    else
                    {   $model_factura = Factura::model()->findAllBySql("CALL `buscar_factura_x_socio`(".$socio.", 2)"); };
                        foreach ($model_factura as $factura)
                        {
                            $codigo_recibo = $factura->ID;
                        }
                        if(isset($codigo_recibo) and $codigo_recibo>0)
                        {
                                $model_asignar_detalle->ID_FACTURA = $codigo_recibo;
                                $model_asignar_detalle->ID_RUBRO = $model->ID;
                                if($model_asignar_detalle->CANTIDAD>0)
                                {}
                                else
                                {
                                    $model_asignar_detalle->CANTIDAD = 1;
                                }
                                 if($model_asignar_detalle->V_UNITARIO>0)
                                {}
                                else
                                {
                                    $model_asignar_detalle->V_UNITARIO = $model->V_UNITARIO;
                                }
                                $model_asignar_detalle->V_TOTAL = $model_asignar_detalle->CANTIDAD * $model_asignar_detalle->V_UNITARIO;
                                $model_asignar_detalle->ESTADO=0;

                             if ($model_asignar_detalle->save()) {
                                 $model_asignar_detalle = new Detalle();
                                 $this->redirect(array('aplicar_a', 'id' => $id));
                             } 
                        }
                        else
                        {
                            $mensajeError = "<h2>El usuario no tiene deuda pendiente, comuniquese con el administrador</h2>";
                            Yii::app()->user->setFlash('error',$mensajeError);
                            $this->redirect(array('aplicar_a', 'id' => $id));                    
                        }
                }
            // +++ FIN APLICAR A USUARIO


            //DETALLES 
                      $model_detalles = Detalle::model()->findAllBySQL('SELECT *
                                                      FROM `detalle`
                                                      WHERE ID_RUBRO = '.$id.'
                                                      GROUP BY ID_FACTURA');

                        $this->render('aplicar_a', array(
                                'model' => $model,
                                'model_detalles' => $model_detalles,
                                'model_asignar_detalle' => $model_asignar_detalle
                        ));

        }
        public function actionAplicar_a_todos($id)
        {   $connection = Yii::app()->db;
            $model_rubro = $this->loadModel($id);
         //APLICAR A TODOS EL SIGUIENTE RUBRO
                if ($model_rubro->TIPO == 1)  //FACTURA
                { $sql = "CALL cobros_rubro_a_todos(".$id.",1)"; }
                else //NOTA DE VENTA
                { $sql = "CALL cobros_rubro_a_todos(".$id."),2"; };
                $command = $connection->createCommand($sql);
                $rows = $command->execute(); 
                 echo "<script>javascript:history.go(-1)</script>";
        }
         public function actionQuitar_a_todos($id)
        {   $connection = Yii::app()->db;
            $model_rubro = $this->loadModel($id);
         //APLICAR A TODOS EL SIGUIENTE RUBRO
                $sql = "CALL cobros_quitar_rubro_a_todos(".$id.")";                
                $command = $connection->createCommand($sql);
                $rows = $command->execute(); 
                 echo "<script>javascript:history.go(-1)</script>";
        }
        
	public function actionView($id)
	{
            $model_detalles = Detalle::model()->findAllBySql('select * from detalle where ID_RUBRO='.$id);
		$this->render('view', array(
			'model' => $this->loadModel($id),
                        'model_detalles' => $model_detalles
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
             $connection = Yii::app()->db;
		$model = new Rubro;

        $this->performAjaxValidation($model, 'rubro-form');

        if(isset($_POST['Rubro']))
		{
			$model->attributes = $_POST['Rubro'];
			if($model->save()) {
                            //Crear facturas y recibos faltantes para el mes actual
                                $sql = "CALL generar_factura_recibo_del_mes_actual()";
                                $command = $connection->createCommand($sql);
                                $rows = $command->execute(); 
                        $this->redirect(array('view', 'id' => $model->ID));
                    }
		}

		$this->render('create',array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
                $tipo_inicial = $model->TIPO; //1.- Factura, 2.- Recibo
        $this->performAjaxValidation($model, 'rubro-form');

		if(isset($_POST['Rubro']))
		{
			$model->attributes = $_POST['Rubro'];
			if($model->save()) {
                            //CAMBIO DE RECIBO A FACTURA O VICEBERSA
                            $tipo_cambiado = $model->TIPO;
                            if($tipo_inicial != $tipo_cambiado)
                            {
                               //Falta cambiar todos los detalles de la factura al recibo o vicebersa
                               
                            }
                            ////////////////////////////////////
				$this->redirect(array('view','id' => $model->ID));
            }
		}

		$this->render('update',array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Rubro');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Rubro('search');
		$model->unsetAttributes(); // clear any default values
		if(isset($_GET['Rubro']))
			$model->attributes = $_GET['Rubro'];

		$this->render('admin', array(
			'model' => $model,
		));
	}
        public function actionBuscarFacturas()
	{
		$model = new Rubro('search');
		$model->unsetAttributes(); // clear any default values
		if(isset($_GET['Rubro']))
			$model->attributes = $_GET['Rubro'];

		$this->render('buscarFacturas', array(
			'model' => $model,
		));
	}

        public function actionBuscarRecibos()
	{
		$model = new Rubro('search');
		$model->unsetAttributes(); // clear any default values
		if(isset($_GET['Rubro']))
			$model->attributes = $_GET['Rubro'];

		$this->render('buscarRecibos', array(
			'model' => $model,
		));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id, $modelClass=__CLASS__)
	{
		$model = Rubro::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model, $form=null)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'rubro-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
