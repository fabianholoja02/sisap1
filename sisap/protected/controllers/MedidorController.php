<?php

class MedidorController extends AweController {

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
                'actions' => array('search'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array(''),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('historial_propietarios', 'cambiarNuevoMedidor', 'ingresar_nuevo', 'admin', 'delete', 'create', 'update', 'view'),
                'expression' => '!Yii::app()->user->isGuest && Usuario::model()->findByPk(Yii::app()->user->id)->esAdministrador()',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionHistorial_propietarios($id) {
        $model = Medidor::model()->findByPk($id);
        $socios_medidor = SocioMedidor::model()->findAllBySql('select * '
                . 'from socio_medidor '
                . 'where ID_MEDIDOR = ' . $id . ' order by ID desc');
        $this->render('historial_propietarios', array(
            'model' => $model,
            'socios_medidor' => $socios_medidor,
        ));
    }

    public function actionCambiarNuevoMedidor($id) { //resie el ID de SocioMedidor
        $model_socioMedidor = SocioMedidor::model()->findByPk($id);
        //BUSCAMOS MEDIDOR ANTERIOR
        $model_medidor_anterior = Medidor::model()->findByPk($model_socioMedidor->ID_MEDIDOR);

        //INGRESAMOS NUEVO MEDIDOR 
        $model = new Medidor;
        $model->ORDEN_RECORIDO = $model_socioMedidor->iDMEDIDOR->ORDEN_RECORIDO;
        $this->performAjaxValidation($model, 'medidor-form');

        if (isset($_POST['Medidor'])) {
            $model->attributes = $_POST['Medidor'];
            if ($model->save()) {
                //Ingresamos la relacion SocioMedidor
                $nuevo_socio_medidor = new SocioMedidor();
                $nuevo_socio_medidor->CODIGO_SOCIO = $model_socioMedidor->CODIGO_SOCIO;
                $nuevo_socio_medidor->ID_MEDIDOR = $model->ID;
                $nuevo_socio_medidor->COD_USUARIO = Yii::app()->getSession()->get('id_usuario');
                //*******
                if ($nuevo_socio_medidor->save()) {
                    //Guardamos el nueo esta del medidor anterior INACTIVO
                    //INACTIVO=1 
                    $model_socioMedidor->INACTIVO = 1;
                    if ($model_socioMedidor->save()) {
                        //VISUALIZAMOS EL CAMBIO REALIZADO
                        $this->redirect(array('socio/historial_medidores/', 'id' => $model_socioMedidor->CODIGO_SOCIO));
                    }
                }
            }
        }

        $this->render('cambiarNuevoMedidor', array(
            'model' => $model,
            'model_medidor_anterior' => $model_medidor_anterior,
            'model_socioMedidor' => $model_socioMedidor,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Medidor;

        $this->performAjaxValidation($model, 'medidor-form');

        if (isset($_POST['Medidor'])) {
            $model->attributes = $_POST['Medidor'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->ID));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionIngresar_nuevo($id) {
        $model = new Medidor;

        $this->performAjaxValidation($model, 'medidor-form');

        if (isset($_POST['Medidor'])) {
            $model->attributes = $_POST['Medidor'];
            if ($model->save()) {
                ///**** ASIGNAMOS EL MEDIDOR AL SOCIO
                $nuevo_socio_medidor = new SocioMedidor();
                $nuevo_socio_medidor->CODIGO_SOCIO = $id;
                $nuevo_socio_medidor->ID_MEDIDOR = $model->ID;
                $nuevo_socio_medidor->COD_USUARIO = Yii::app()->getSession()->get('id_usuario');
                //*******
                if ($nuevo_socio_medidor->save()) {


                    //BUSCA EL SOCIO MEDIDOR INGRESADO
                    $modelos_socio_medidor = SocioMedidor::model()->findAllBySql('SELECT *
                    FROM socio_medidor
                    WHERE `CODIGO_SOCIO` = ' . $id . ' order by ID_MEDIDOR desc limit 1');
                    $modelo_socio_medidor = new SocioMedidor();
                    foreach ($modelos_socio_medidor as $mod) {
                        $modelo_socio_medidor = $mod;
                    }
                    if (isset($modelo_socio_medidor->ID)) {
                        $nuevo_socio_medidor = new SocioMedidor();
                        $this->redirect(array('socio/ver_medidor/', 'id' => $id));
                    } else {
                        Yii::app()->user->setFlash('Buscar', 'No fue posible ingresar un medidor a nombre del usuario de agua ' . $nuevo_socio_medidor->cODIGOSOCIO->APELLIDO . ', comuniquese con el administrador');
                        $nuevo_socio_medidor = new SocioMedidor();
                        $this->redirect(array('socio/bus_ing_medidor'));
                    }
                } //Fin de ingresa socio_medidor
            }
        }

        $this->render('ingresar_nuevo', array(
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

        $this->performAjaxValidation($model, 'medidor-form');

        if (isset($_POST['Medidor'])) {
            $model->attributes = $_POST['Medidor'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->ID));
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
        $dataProvider = new CActiveDataProvider('Medidor');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Medidor('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Medidor']))
            $model->attributes = $_GET['Medidor'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $modelClass = __CLASS__) {
        $model = Medidor::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'medidor-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSearch() {
        header('Content-type: application/json');
        if (!isset($_GET['ajax'])) {
            $query = 'SELECT m.ID, m.CONSUMO_INICIAL,m.ORDEN_RECORIDO,s.APELLIDO FROM medidor AS m
                INNER JOIN socio_medidor AS sm ON m.ID = sm.ID_MEDIDOR
                INNER JOIN socio AS s ON s.CODIGO = sm.CODIGO_SOCIO
                where sm.INACTIVO= 0 and m.NUMERO="' . $_POST['numero'] . '"';
            $command = Yii::app()->db->createCommand($query);
            $datos = $command->queryAll ();
            echo CJSON::encode($datos);
        }
    }

}
