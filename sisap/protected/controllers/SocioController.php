<?php

class SocioController extends AweController {

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
                'actions' => array('ejemplo1', 'ejemplo1recibe', 'ejemplo2', 'ejemplo2recibe', 'search'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('historial','buscar_historial_socio','ver_medidor','listarSocios', 'historial_medidores', 'view', 'bus_ing_medidor', 'admin', 'delete', 'create', 'update'),
                //'users'=>array('@'),
                'expression' => '!Yii::app()->user->isGuest && Usuario::model()->findByPk(Yii::app()->user->id)->esAdministrador()',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

     public function actionHistorial($id) {
        $model = $this->loadModel($id);
        $mpdf = Yii::app()->ePdf->mpdf('utf-8', 'A4', '', '', 15, 15, 35, 25, 9, 9, 'P');
        $mpdf->useOnlyCoreFonts = true;
        $mpdf->SetTitle("LISTA");
        $mpdf->SetAuthor("SISAP");
        $mpdf->SetWatermarkText("``SISAP " . date(Y) . "``");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($this->renderPartial('historial', array(
                    'model' => $model,
                        ), true));
        $mpdf->Output('Historial al ' . date('d-M-Y') .' '.$model->APELLIDO . ' .pdf', 'I');
        exit;
    }
    
    
    
    
       public function actionBuscar_historial_socio()
	{
		 $model = new Socio;
        $this->performAjaxValidation($model, 'socio-form');
        if (isset($_POST['Socio'])) {
            $model->attributes = $_POST['Socio'];
            $socio =$_POST['Socio']['CODIGO'];
//            var_dump($socio);
//            Yii::app()->end();
            if ($socio > 0) {
                $this->redirect(array('historial', 'id' => $socio));
            }
        }
        $this->render('buscar_historial_socio', array(
            'model' => $model,
        ));
	}
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionListarSocios($term) {
        $criteria = new CDbCriteria;
        $criteria->condition = "LOWER(CI) like LOWER(:term) or LOWER(APELLIDO) like LOWER(:term)
 or (COD_BARRA) like LOWER(:term)";
        $criteria->params = array(':term' => '%' . $_GET['term'] . '%');
        $criteria->limit = 30;
        $models = Socio::model()->findAll($criteria);
        $arr = array();
        foreach ($models as $model) {
            $arr[] = array(
                'label' => ('CI: ' . $model->CI . ', ( ' . $model->APELLIDO . ')  ' . ''), // label for dropdown list
                'value' => $model->APELLIDO, // value for input field
//     'value'=>$model->ci_cli, // value for input field
                //    'attribute'=> $model->APELLIDO,
                'id' => $model->CODIGO, // return value from autocomplete
            );
        }
        echo CJSON::encode($arr);
    }

    public function actionHistorial_medidores($id) {
        $model = $this->loadModel($id);
        $nuevo_medidor = new Medidor();
        //************************
        // BUSCAR ÚLTIMO MEDIDOR ASIGNADO AL SOCIO
        $modelos_socio_medidor = SocioMedidor::model()->findAllBySql('SELECT *
            FROM socio_medidor
            WHERE `CODIGO_SOCIO` = ' . $id . ' order by ID_MEDIDOR desc');
        $modelo_socio_medidor = new SocioMedidor();
        foreach ($modelos_socio_medidor as $mod) {
            $modelo_socio_medidor = $mod;
        }
        //************************
        //INGRESAR NUEVO MEDIDOR DEL SOCIO
        if (isset($_POST['Medidor'])) {
            $nuevo_medidor->attributes = $_POST['Medidor'];
            if ($nuevo_medidor->save()) {
                ///**** ASIGNAMOS EL MEDIDOR AL SOCIO
                $nuevo_socio_medidor = new SocioMedidor();
                $nuevo_socio_medidor->CODIGO_SOCIO = $id;
                $nuevo_socio_medidor->ID_MEDIDOR = $nuevo_medidor->ID;
                $nuevo_socio_medidor->COD_USUARIO = Yii::app()->getSession()->get('id_usuario');
                //*******
                if ($nuevo_socio_medidor->save()) {
                    $nuevo_socio_medidor = new SocioMedidor();
                    $nuevo_medidor = new Medidor();
                    $this->redirect(array('view', 'id' => $id)); // Regresamos a este mismo lugar
                }
            }
        }
        //************************
        $this->render('historial_medidores', array(
            'model' => $model,
            'modelos_socio_medidor' => $modelos_socio_medidor,
            'modelo_socio_medidor' => $modelo_socio_medidor,
            'nuevo_medidor' => $nuevo_medidor,
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
        $nuevo_medidor = new Medidor();
        //************************
        // BUSCAR ÚLTIMO MEDIDOR ASIGNADO AL SOCIO
        $modelos_socio_medidor = SocioMedidor::model()->findAllBySql('SELECT *
            FROM socio_medidor
            WHERE `CODIGO_SOCIO` = ' . $id . ' order by ID_MEDIDOR desc limit 1');
        $modelo_socio_medidor = new SocioMedidor();
        foreach ($modelos_socio_medidor as $mod) {
            $modelo_socio_medidor = $mod;
        }
        //************************
        //INGRESAR NUEVO MEDIDOR DEL SOCIO
        if (isset($_POST['Medidor'])) {
            $nuevo_medidor->attributes = $_POST['Medidor'];
            if ($nuevo_medidor->save()) {
                ///**** ASIGNAMOS EL MEDIDOR AL SOCIO
                $nuevo_socio_medidor = new SocioMedidor();
                $nuevo_socio_medidor->CODIGO_SOCIO = $id;
                $nuevo_socio_medidor->ID_MEDIDOR = $nuevo_medidor->ID;
                $nuevo_socio_medidor->COD_USUARIO = Yii::app()->getSession()->get('id_usuario');
                //*******
                if ($nuevo_socio_medidor->save()) {
                    $nuevo_socio_medidor = new SocioMedidor();
                    $nuevo_medidor = new Medidor();
                    $this->redirect(array('view', 'id' => $id)); // Regresamos a este mismo lugar
                }
            }
        }
        //************************
        $this->render('view', array(
            'model' => $model,
            'modelo_socio_medidor' => $modelo_socio_medidor,
            'nuevo_medidor' => $nuevo_medidor,
        ));
    }
     public function actionVer_medidor($id) {
        $nuevo_medidor = Medidor::model()->findByPk($id);
        
        // BUSCAR ÚLTIMO MEDIDOR ASIGNADO AL SOCIO
        $modelos_socio_medidor = SocioMedidor::model()->findAllBySql('SELECT *
            FROM socio_medidor
            WHERE `CODIGO_SOCIO` = ' . $id . ' order by ID_MEDIDOR desc limit 1');
        $modelo_socio_medidor = new SocioMedidor();
        foreach ($modelos_socio_medidor as $mod) {
            $modelo_socio_medidor = $mod;
        }
        //************************
       $model = $this->loadModel($modelo_socio_medidor->CODIGO_SOCIO);
        $this->render('ver_medidor', array(
             'model' => $model,
            'modelo_socio_medidor' => $modelo_socio_medidor,
            'nuevo_medidor' => $nuevo_medidor,
        ));
    }

    public function actionEjemplo1() {
        $this->render('ejemplo1');
    }

    public function actionEjemplo1recibe() {
        echo date('d/m/Y H:i:s');
    }

    public function actionEjemplo2() {
        $this->render('ejemplo2');
    }

    public function actionEjemplo2recibe_() {
        sleep(4);
        echo date('d/m/Y H:i:s');
    }

    public function actionSearch() {
        $socio=array();
        header('Content-type: application/json');
        if (!isset($_GET['ajax'])) {
            
            //$parametro = $_POST['cedula'];
            $modelos_socio = Socio::model()->findAllBySql('select * from socio where CI="' . $_POST['cedula'] . '"');
            if (isset($modelos_socio)) {
                $arr = array();
                foreach ($modelos_socio as $mod) {
                    $arr[] = array(
                        'CODIGO' => $mod->CODIGO,
                        'CI' => $mod->CI,
                        'APELLIDO' => $mod->APELLIDO,
                        'GENERO' => $mod->GENERO,
                        'DIRECCION' => $mod->DIRECCION,
                        'TELEFONO' => $mod->TELEFONO,
                        'CELULAR' => $mod->CELULAR,
                        'EMAIL' => $mod->EMAIL,
                    );
                    $socio=$arr[0];
                }
            } else {
                $socio = 0;
            }
            echo CJSON::encode($socio);
        } else {
            echo 'no llega la cedula al controlador';
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Socio;

        $this->performAjaxValidation($model, 'socio-form');

        if (isset($_POST['Socio'])) {
            $model->attributes = $_POST['Socio'];
            $model->COD_USUARIO = Yii::app()->getSession()->get('id_usu');
            $model->FECHA_INGRESO = date('Y-n-j');
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->CODIGO));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model, 'socio-form');

        if (isset($_POST['Socio'])) {
            $model->attributes = $_POST['Socio'];
            $model->COD_USUARIO = Yii::app()->getSession()->get('id_usu');
            $model->FECHA_ACTUALIZACION = date('Y-n-j G:i:s');
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->CODIGO));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Socio');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Socio('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Socio']))
            $model->attributes = $_GET['Socio'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionBus_ing_medidor() {
        $model = new Socio('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Socio']))
            $model->attributes = $_GET['Socio'];

        $this->render('bus_ing_medidor', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $modelClass = __CLASS__) {
        $model = Socio::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'socio-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
