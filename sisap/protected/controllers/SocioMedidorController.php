<?php

class SocioMedidorController extends AweController {

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
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array(''),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('encabezadofactura', 'detallefactura', 'imprimir_factura', 'imprimir_recibo', 'lista_socios_pdf', 'lista_socios_excel', 'lista_socios_word', 'lista_socios', 'derecho_agua', 'factura', 'exportarMedidas', 'importarExcel', 'cambiarPropietario', 'traspaso', 'cambiar', 'buscar_x_socio', 'admin', 'delete', 'create', 'update', 'view', 'reporte'),
                'expression' => '!Yii::app()->user->isGuest && Usuario::model()->findByPk(Yii::app()->user->id)->esAdministrador()',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionEncabezadofactura() {
        header('Content-type: application/json');
        if (!isset($_GET['ajax'])) {
            $query = 'call generar_factura_encabezado(' . $_POST['socio'] . ')';
            $command = Yii::app()->db->createCommand($query);
            $datos = $command->queryAll();
            echo CJSON::encode($datos);
        }
    }

    public function actionDetallefactura() {
        header('Content-type: application/json');
        if (!isset($_GET['ajax'])) {
            $query = 'call generar_factura_detalle(' . $_POST['socio'] . ')';
            $command = Yii::app()->db->createCommand($query);
            $datos = $command->queryAll();
            echo CJSON::encode($datos);
        }
    }

    public function actionFactura() {
        $model = new SocioMedidor;
        $this->performAjaxValidation($model, 'socio-medidor-form-factura');

        if (isset($_POST['SocioMedidor']) and isset($_POST['item'])) {
            $detalles = $_POST['item'];

            foreach ($detalles as $detalle) {
                $ids_detalles = explode('-', $detalle);
                $id_detalle = $ids_detalles[0];    //ID DEL DETALLE               
                $model_detalle = Detalle::model()->findByPk($id_detalle);
                $model_detalle->COD_USUARIO = Yii::app()->getSession()->get('id_usu_sismedic');
                $model_detalle->ESTADO = 1; //CAmbia a estado pagado
                if (isset($model_detalle)) {
                    if ($model_detalle->save()) {                       
                    }
                }
            }
            //   REDIRECCIONAMOS A  IMPRIMIR El estado ya esta cambiado toca crear otro procedimiento apra la impresion
               $this->redirect(array('imprimir_factura', 'id' => $model_detalle->iDFACTURA->iDMEDIDORSOCIO->CODIGO_SOCIO));
        }
        $this->render('factura', array(
            'model' => $model,
        ));
    }

    public function actionImprimir_recibo($id) {
        $this->layout = 'imprimir';

        $query = 'call generar_factura_encabezado(' . $id . ')';
        $command = Yii::app()->db->createCommand($query);
        $un_dato = $command->queryRow();

        $query = 'call generar_factura_detalle_pagado(' . $id . ')';
        $command = Yii::app()->db->createCommand($query);
        $datos = $command->queryAll();
       
            $mensajeConfirmandoRegistro = 'Se cobro correctamente al socio: '.$un_dato['APELLIDO'];
        Yii::app()->user->setFlash('success', $mensajeConfirmandoRegistro);
                      
        
        $this->render('imprimir_recibo', array(
            //'model' => $model, // SOCIO_MEDIDOR                        
            'datos' => $datos,
            'un_dato' => $un_dato,
        ));
         
    }

    public function actionImprimir_factura($id) {
        $this->layout = 'imprimir';
        $model_socio = Socio::model()->findByPk($id);
        $query = 'call generar_factura_encabezado(' . $id . ')';
        $command = Yii::app()->db->createCommand($query);
        $un_dato = $command->queryRow();

        $query = 'call generar_factura_detalle_pagado(' . $id . ')';
        $command = Yii::app()->db->createCommand($query);
        $datos = $command->queryAll();
        
        $this->render('imprimir_factura', array(
            //'model' => $model, // SOCIO_MEDIDOR                        
            'datos' => $datos,
            'un_dato' => $un_dato,
            'model_socio' => $model_socio,
        ));
        
    }

    public function actionLista_socios_pdf() {
        $model_socios = Socio::model()->findAllBySql('select s.* '
                . ' from socio as s'
                . ' inner join socio_medidor as sm'
                . ' on s.CODIGO = sm.CODIGO_SOCIO'
                . ' where sm.INACTIVO=0'
                . ' order by APELLIDO');
        $mpdf = Yii::app()->ePdf->mpdf('utf-8', 'A4', '', '', 15, 15, 35, 25, 9, 9, 'P');
        $mpdf->useOnlyCoreFonts = true;
        $mpdf->SetTitle("LISTA");
        $mpdf->SetAuthor("SISAP");
        $mpdf->SetWatermarkText("``SISAP " . date(Y) . "``");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($this->renderPartial('lista_socios_pdf', array(
                    'model_socios' => $model_socios,
                        ), true));
        $mpdf->Output('Lista de socios activos ' . date('d M Y') . '.pdf', 'I');
        exit;
    }

    public function actionLista_socios_word() {
        $model_socios = Socio::model()->findAllBySql('select s.* '
                . ' from socio as s'
                . ' inner join socio_medidor as sm'
                . ' on s.CODIGO = sm.CODIGO_SOCIO'
                . ' where sm.INACTIVO=0'
                . ' order by APELLIDO');
        $contenido = $this->renderPartial("lista_socios_word", array('model_socios' => $model_socios), true);
        Yii::app()->request->sendFile("Socios activos" . ".xls", $contenido);
        $this->render('lista_socios_word', array(
            'model_socios' => $model_socios,
        ));
    }

    public function actionLista_socios_excel() {
        $model_socios = Socio::model()->findAllBySql('select s.* '
                . ' from socio as s'
                . ' inner join socio_medidor as sm'
                . ' on s.CODIGO = sm.CODIGO_SOCIO'
                . ' where sm.INACTIVO=0'
                . ' order by APELLIDO');
        $contenido = $this->renderPartial("lista_socios_excel", array('model_socios' => $model_socios), true);
        Yii::app()->request->sendFile("Socios activos" . ".xls", $contenido);
        $this->render('lista_socios_excel', array(
            'model_socios' => $model_socios,
        ));
    }

    public function actionLista_socios() {
        $model_socios = Socio::model()->findAllBySql('select s.* '
                . ' from socio as s'
                . ' inner join socio_medidor as sm'
                . ' on s.CODIGO = sm.CODIGO_SOCIO'
                . ' where sm.INACTIVO=0'
                . ' order by APELLIDO');
        $this->render('lista_socios', array(
            'model_socios' => $model_socios,
        ));
    }

    public function actionExportarMedidas() {
        $socio_medidor = SocioMedidor::model()->findAllBySql('CALL listar_socio_medidor()');
        $contenido = $this->renderPartial("exportarMedidas", array('socio_medidor' => $socio_medidor), true);
        Yii::app()->request->sendFile("Consumo " . gmdate('M') . " del " . gmdate('Y') . ".xls", $contenido);
        $this->render('exportarMedidas', array(
            'socio_medidor' => $socio_medidor,
        ));
    }

    public function actionImportarExcel() {
        $connection_sisap = Yii::app()->db;
        // 1.- Crea las facturas para el mes actual
        $sql = "CALL generar_factura_recibo_del_mes_actual();";
        $command = $connection_sisap->createCommand($sql);
        $rowCount = $command->execute();
        // 2.- Crear rubros básicos
        $sql = "CALL `aplicar_rubros_basicos`();";
        $command = $connection_sisap->createCommand($sql);
        $rows = $command->queryAll();
        // 3.- Aplica los rubros básicos 
        foreach ($rows as $row) {
            $sql = "CALL cobros_rubro_a_todos(" . $row['ID'] . ", " . $row['TIPO'] . ");";
            $command = $connection_sisap->createCommand($sql);
            $rowCount = $command->execute();
        }
        // 3.- Carga el consumo y calcula el valor a cancelar por consumo de agua potable en la vista
        $this->render('importarExcel');
    }

    public function actionCambiarPropietario($id) { //resie el ID de SocioMedidor
        //Socio Medidor
        $model_socioMedidor = SocioMedidor::model()->findByPk($id);
        //INGRESAMOS NUEVO SOCIOMEDIDOR 
        $model = new SocioMedidor;
        $model->ID_MEDIDOR = $model_socioMedidor->ID_MEDIDOR;
        $this->performAjaxValidation($model, 'socio-medidor-form');
        //Ingresa el nuevo socio
        if (isset($_POST['SocioMedidor'])) {
            $model->attributes = $_POST['SocioMedidor'];
            //COMPROBAR SI NO TIENE MEDIDOR ASIGNADO A SU NOMBRE
            //VALIDAR 1 SOLO MEDIDOR
            $socio_medidor_nuevo_propietario = SocioMedidor::model()->findAllBySql('select * '
                    . 'from socio_medidor '
                    . 'where INACTIVO = 0 and CODIGO_SOCIO = ' . $model->CODIGO_SOCIO);
            $sociomedidor_propietario = new SocioMedidor();
            foreach ($socio_medidor_nuevo_propietario as $aux) {
                $sociomedidor_propietario = $aux;
            }
            if (isset($sociomedidor_propietario->ID)) {
                //Ya tiene un medidor a su nombre

                Yii::app()->user->setFlash('Ya_tiene_medidor', '<b>ERROR AL REALIZAR EL TRASPASO!</b><br>'
                        . 'El usuario de agua ' . '<strong>' . $model->cODIGOSOCIO->APELLIDO . '</strong>' . ' ya tiene registrado el medidor  <strong>Nº : ' . $model_socioMedidor->iDMEDIDOR->NUMERO
                        . '</strong>' . ' a su nombre. <br> El usuario debe tener un solo medidor a su nombre. ');

                $socio_medidor_nuevo_propietario = new SocioMedidor();
                $this->refresh();
                $this->redirect(array('cambiarPropietario', 'id' => $id));
            } else {
                //Asignamos el medidor al propietario 
                $model->INACTIVO = 0;
                if ($model->save()) {
                    //Desactivamos el anterior
                    $model_socioMedidor->INACTIVO = 1;
                    if ($model_socioMedidor->save()) {
                        //VISUALIZAMOS EL CAMBIO REALIZADO
                        $this->redirect(array('medidor/historial_propietarios/', 'id' => $model_socioMedidor->ID_MEDIDOR));
                    }
                }
            }
        }
        $this->render('cambiarPropietario', array(
            'model' => $model,
            'model_socioMedidor' => $model_socioMedidor,
        ));
    }

    public function actionBuscar_x_socio($id) {
        //************************
        // BUSCAR ÚLTIMO MEDIDOR ASIGNADO AL SOCIO
        /* $modelos_socio_medidor = SocioMedidor::model()->findAll(
          array("condition" => array("INACTIVO =  0","CODIGO_SOCIO=$id"), "order" => "ID_MEDIDOR")); */

        $modelos_socio_medidor = SocioMedidor::model()->findAllBySql('select * '
                . ' from socio_medidor '
                . ' where  INACTIVO = 0 and CODIGO_SOCIO = ' . $id . ' order by ID_MEDIDOR desc limit 1');

        /* $socio_medidor_nuevo_propietario = SocioMedidor::model()->findAllBySql('select * '
          . 'from socio_medidor '
          . 'where INACTIVO = 0 and CODIGO_SOCIO = ' . $model->CODIGO_SOCIO); */
        $modelo_socio_medidor = new SocioMedidor();
        foreach ($modelos_socio_medidor as $mod) {
            $modelo_socio_medidor = $mod;
        }
        if (isset($modelo_socio_medidor->ID)) { //SOLO UN MEDIDOR
            //throw new CHttpException(400, 'El usuario de agua ya tiene registrado el medidor N°:'.$modelo_socio_medidor->iDMEDIDOR->NUMERO.' a su nombres');
            Yii::app()->user->setFlash('Buscar', 'El usuario de agua ' . '<strong>' . $modelo_socio_medidor->cODIGOSOCIO->APELLIDO . '</strong>' . ' ya tiene registrado el medidor ' . '<strong>N°</strong>:' . '<strong>' . $modelo_socio_medidor->iDMEDIDOR->NUMERO . '</strong>' . ' a su nombre');
            //  $this->refresh();
            $this->redirect(array('socio/bus_ing_medidor'));
        } else { //INGRESA NUEVO MEDIDOR
            $this->redirect(array('medidor/ingresar_nuevo', 'id' => $id));
        }
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
        $model = new SocioMedidor;

        $this->performAjaxValidation($model, 'socio-medidor-form');

        if (isset($_POST['SocioMedidor'])) {
            $model->attributes = $_POST['SocioMedidor'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->ID));
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

        $this->performAjaxValidation($model, 'socio-medidor-form');

        if (isset($_POST['SocioMedidor'])) {
            $model->attributes = $_POST['SocioMedidor'];
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
        $dataProvider = new CActiveDataProvider('SocioMedidor');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionCambiar() {
        $model = new SocioMedidor('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['SocioMedidor']))
            $model->attributes = $_GET['SocioMedidor'];

        $this->render('cambiar', array(
            'model' => $model,
        ));
    }

    public function actionDerecho_agua() {
        $model = new SocioMedidor('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['SocioMedidor']))
            $model->attributes = $_GET['SocioMedidor'];

        $this->render('derecho_agua', array(
            'model' => $model,
        ));
    }

    public function actionTraspaso() {
        $model = new SocioMedidor('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['SocioMedidor']))
            $model->attributes = $_GET['SocioMedidor'];

        $this->render('traspaso', array(
            'model' => $model,
        ));
    }

    public function actionAdmin() {
        $model = new SocioMedidor('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['SocioMedidor']))
            $model->attributes = $_GET['SocioMedidor'];

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
        $model = SocioMedidor::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'socio-medidor-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionReporte() {
        $sociomedidores = SocioMedidor::model()->findAll();
       $socios=  Socio::model()->with('medidor')->findAll();
        $fabianho = "Deberias contratar a Fabianho";
        //var_dump($socios);
        //Yii::app()->end();
        $this->render('reporte', array(
            "fabianho" => $fabianho,
            "socios" => $socios,
            'sociomedidores'=>$sociomedidores,
        ));
    }

}
