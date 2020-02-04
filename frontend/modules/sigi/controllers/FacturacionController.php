<?php

namespace frontend\modules\sigi\controllers;

use Yii;
use frontend\modules\sigi\models\SigiFacturacion;
use frontend\modules\sigi\models\SigiFacturacionSearch;
use frontend\modules\sigi\models\SigiCuentasporSearch;
use frontend\modules\sigi\models\VwSigiFacturecibo;
use frontend\modules\sigi\models\VwSigiFactureciboSearch;
use frontend\modules\sigi\models\VwSigiLecturasSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * FacturacionController implements the CRUD actions for SigiFacturacion model.
 */
class FacturacionController extends baseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SigiFacturacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model=$this->findModel(66);
        $model->resolveRecibosPartidos();
        die();
        
       
          /*\Yii::$app->session->open();
        $userDirPath = Yii::$app->session->id;
        echo "Primer intento<br>";
         echo $userDirPath;echo "<br>";
        \Yii::$app->session->close();
          $userDirPath = Yii::$app->session->id;
           echo "Segundo intento<br>";
        echo $userDirPath;die();
         echo "------<br><br>";*/
        $searchModel = new SigiFacturacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SigiFacturacion model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SigiFacturacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SigiFacturacion();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SigiFacturacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
     //echo \frontend\modules\sigi\models\SigiUnidades::findOne(704)->porcWithChilds();
      //  die();
        /* 
     //echo h::gsetting('mail','servermail');die();
          $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
            $message->setSubject('Notificacion de Examen')
            ->setFrom(['jramirez@neotegnia.com'=>'JULIA RAMIREZ TENOROP'])
            ->setTo('hipogea@hotmail.com')
            ->SetHtmlBody("Buenas Tardes  ulian <br>"
                    . "La presente es para notificarle que tienes "
                    . "una examen  programado. <br> Presiona el siguiente link "
                    . "para acceder a la prueba: <br>"
                    . "    <a  href=\o\" >Presiona aquí </a>");
            
            
           
    try {
        
           $result = $mailer->send($message);
           $mensajes['success']='Se envió el correo, invitando al examen, el Alumno tiene que responder ';
            echo "exceknte r ";
    } catch (\Swift_TransportException $Ste) { 
        
         $mensajes['error']=$Ste->getMessage();
         echo "huibo un error ",$Ste->getMessage();
    }  
    
     die();   
        
      /*  
        
        
    $transport = new \Swift_SmtpTransport();
    //echo get_class($transport);die();
          $transport->setHost('mail.neotegnia.com')
            ->setPort('465')
            ->setEncryption('tls')
            ->setStreamOptions(['ssl' =>['allow_self_signed' => true,'verify_peer_name' => false, 'verify_peer' => false]] )
            ->setUsername('jramirez')
            ->setPassword('toxoplasma1');
        $mailer = new \Swift_Mailer($transport);
        $message =new  \Swift_Message();
            $message->setSubject('Test Message')
            ->setFrom(['hipogea@hotmail.com'=>'Jorge Paredes'])
            ->setTo('jramirez@neotegnia.com')
            ->setBody('Este es un test');

  
    try {
           set_time_limit(300); // 5 minutes    
        $result = $mailer->send($message);
        static::psetting('mail','servemail',$serverMail);//'mail.neotegnia.com'
          static::psetting('mail','userservermail',$userMail);//'jramirez@neotegnia.com',
          static::psetting('mail','passworduserservermail',$passwordMail);//'toxoplasma1',
           static::psetting('mail','portservermail',$portMail);// '25',*/
        
        
        
   /* } catch (\Swift_TransportException $Ste) {
      
        echo $Ste->getMessage(); die();
    }
       */ 
  /*tend\modules\sigi\models\Edificios::findOne(7);
$edificio->refreshPorcentaje();
die();*/
//$modelo=\frontend\modules\sigi\models\SigiSuministros::findOne(117);
        //var_dump($modelo->LastReadFacturable('12','2019'));DIE();
        $model = $this->findModel($id);
       /* $model->obtenerForeignClass('reporte_id');
         var_dump($model->obtenerForeignClass('reporte_id'),$model->fieldsLink(false));die();*/

          $searchModel = new SigiCuentasporSearch();
         $dataProviderCuentasPor = $searchModel->searchByFactu($model->id); 
         
         
         
         
         $searchModelPartidas = new \frontend\modules\sigi\models\SigiBasePresupuestoSearch();
         $dataProviderPartidas = $searchModelPartidas->searchByEdificio($model->edificio_id,Yii::$app->request->queryParams); 
        // $searchModelLecturas = new VwSigiTempLecturasSearch();
        //$dataProviderLecturas = $searchModelLecturas->searchByCuentasPor($model->idsToCuentasPor(),Yii::$app->request->queryParams);
         
         
          $searchModelLecturas = new \frontend\modules\sigi\models\VwSigiLecturasSearch();
         $dataProviderLecturas = $searchModelLecturas->searchByFacturacionParams($model->edificio_id,$model->mes,$model->ejercicio,Yii::$app->request->queryParams); 
         
      
         
          $dataProviderLecturasFaltan =$model->providerFaltaLecturas('101');
         if (h::request()->isAjax && $model->load(h::request()->post())) {
             
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'dataProviderCuentasPor' =>$dataProviderCuentasPor,           
            'dataProviderLecturasFaltan' =>$dataProviderLecturasFaltan,
            'searchModelPartidas' => $searchModelPartidas,
         'dataProviderPartidas' => $dataProviderPartidas,
             'searchModelLecturas' =>  $searchModelLecturas,
         'dataProviderLecturas' => $dataProviderLecturas,
        ]);
    }

    /**
     * Deletes an existing SigiFacturacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SigiFacturacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SigiFacturacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
            
    {
        if (($model = SigiFacturacion::findOne($id)) !== null) {
            return $model;
        }
        

        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
    }
   
    
    
    public function actionFacturacionMes($id){
        if (h::request()->isAjax) {
            $errores=[];
            yii::error('que pasa');
                h::response()->format = Response::FORMAT_JSON;
           $model=$this->findModel($id);
            $errores=$model->generateFacturacionMes();
           //$model->shortFactu();
            if(count($errores)>0){
               return $errores;
           }else{
               return ['success'=>'Se ha generado la facturación del mes'];
           }
       }
       
    }
    
    public function actionResetFacturacionMes($id){
        if (h::request()->isAjax) {
            //$errores=[];
                h::response()->format = Response::FORMAT_JSON;
           $model=$this->findModel($id);
           $model->resetFacturacion();
           return ['success'=>yii::t('sigi.labels','Se ha reinicado la facturación')];
       }
       
    }
    
    public function actionCrearLecturas($id){
        if (h::request()->isAjax) {
              h::response()->format = Response::FORMAT_JSON;
           $model= \frontend\modules\sigi\models\SigiCuentaspor::findOne($id);
           if(!is_null($model)){
               $model->creaRegistroLecturasTemp();
               return ['success'=>yii::t('sigi.labels','Se ha generado la plantilla de lecturas')];
           }else{
               return ['error'=>yii::t('sigi.labels','No se ha encontrado un registro para este id')]; 
           }
            
           
       }
       
    }
    
   public function actionDetalleFacturacion($id){
      $this->findModel($id);
         $searchModel = new  VwSigiFactureciboSearch();
        $dataProvider = $searchModel->search($id,Yii::$app->request->queryParams);

        return $this->render('detalle', ['id'=>$id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
   }
   
   
   public function actionLecturas(){
      
         $searchModel = new VwSigiLecturasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('lecturas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); 
   }
   /*Texto recomendacion*/
   public function actionAjaxRecomendacion($id){
       if(h::request()->isAjax){
           //$modeled=$this->findModel($id);
           $edificio=\frontend\modules\sigi\models\Edificios::findOne($id); 
         if(!is_null($edificio)){
             
             return $edificio->messageFacturacion();
             
             
         }
           
       }
   }
}
