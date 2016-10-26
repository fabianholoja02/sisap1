<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    
    
    
    
    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('about', 'reloj', 'actions', 'contact', 'autenticar', 'login', 'index', 'error', 'presenceSystem', 'mision_vision'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('indexSecretaria','actions','indexAutenticado', 'indexMedico', 'desarrollando', 'logoutCambiarClave', 'logout'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('', '', '', '', ''),
                //'users'=>array('@'),
                'expression' => '!Yii::app()->user->isGuest && Usuario::model()->findByPk(Yii::app()->user->id)->esAdministrador()',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

 
//    public function actions()
//{
//    return array(
//        'eyui'=>array(
//            'class'=>'EYuiAction',
//        ),
//    );
//}
    
    public function actionPresenceSystem() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('presenceSystem');
    }
     public function actionReloj() {
            $this->layout = 'vacio';
        $this->render('reloj');
    }

    public function actionIndexAutenticado() {
        //***** AUMENTADO PARA LA BUSQUEDA DE SOCIOS
        $model = new Socio('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Socio']))
            $model->attributes = $_GET['Socio'];

        $this->render('indexAutenticado', array(
            'model' => $model,
                //            'model_inspeccion' => $model_inspeccion
        ));
    }
    public function actionIndexMedico() {
        $id=Yii::app()->getSession()->get('id_referencia');
        //aumentar para no tener problemas al renderizar el modelo
        if (!Yii::app()->user->isGuest && Usuario::model()->findByPk(Yii::app()->user->id)->esAdministrador())
        {
            $this->redirect(array('indexAutenticado'));    
        }
        if  (!Yii::app()->user->isGuest && Usuario::model()->findByPk(Yii::app()->user->id)->esSecretaria()){
            $this->redirect(array('indexSecretaria'));   
        }
         //fin aumentar para no tener problemas al renderizar el modelo
        if($id>0)
        {
            $model = TMedico::model()->findByPk($id);
            $this->render('indexMedico', array(
                    //	'model_transporte' => $model_transporte,
                    //            'model_inspeccion' => $model_inspeccion
                 'model' => $model,
            ));
        }
        else
        {
            $this->render('indexMedico', array(
                'model' => $model,
           ));
        } 
    }

      public function actionIndexSecretaria() {
          //Toca crear un modelo para ingresar empleado de tipo secretaria
//        $id=Yii::app()->getSession()->get('id_referencia');
//        if($id>0)
//        {
//            $model = TEmpleado::model()->findByPk($id);
//            $this->render('indexSecretaria', array(
//                    //	'model_transporte' => $model_transporte,
//                    //            'model_inspeccion' => $model_inspeccion
//                 //'model' => $model,
//            ));
//        }
//        else
//        {
            $this->render('indexSecretaria', array(
               // 'model' => $model,
           ));
//        } 
    }

    public function actionAutenticar() {
        $this->layout = 'columnJT';
      //  $this->beginContent('//layouts/main');
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('autenticar', array('model' => $model));
        // $this->endContent();
    }

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
      //    $this->redirect("http://www.uasgadquero.com.ec/");

        //Destruir las variables de session q 
        //iniciamos en el Active Record del Usuario, que se encuentra en el modelo del mismo

        Yii::app()->getSession()->remove('tipo_usu');
        Yii::app()->getSession()->remove('id_usu');
        Yii::app()->getSession()->remove('nombre_usuario');
        Yii::app()->getSession()->remove('id_referencia');
        Yii::app()->getSession()->remove('foto');
        Yii::app()->getSession()->remove('bandera_audio');
    }
     public function actionLogoutCambiarClave() {
         $usu = Yii::app()->user->id;
        Yii::app()->user->logout();
        //$this->redirect(Yii::app()->homeUrl);
        $this->redirect(array('usuario/cambiar_Clave/'.$usu));
    }

}
