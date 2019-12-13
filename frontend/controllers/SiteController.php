<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
USE common\helpers\h;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use mdm\admin\components\UserStatus;
use mdm\admin\models\searchs\User as UserSearch;
use yii\helpers\Url;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()    {       
        // $this->layout="install";       
      
        $urlBackend=str_replace('frontend','backend',yii::$app->urlManager->baseUrl);
        //if(yii::$app->user->isGuest){            
            if(\backend\components\Installer::readEnv('APP_INSTALLED')=='false'){
                          
                $this->redirect($urlBackend);             
            }else{
                
                if(yii::$app->user->isGuest){
                   // echo "holsa"; die();
                  return  $this->redirect(['site/login']);
                    
                }else{
                    
                     return $this->render('index');
                }
               
              // $this->redirect(\Yii::$app->urlManager->home);
            }
       // }else{     
          
         
           
        //}
       
        
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
     
        $this->layout="install";
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
 //Yii::info(" paracopmrobar   ", __METHOD__);  
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
                 $this->redirect(['index']);      
		// $this->redirect(['sta/default/view-profile','iduser'=>h::userId()]);           // return $this->goBack();
        } else {
          
            $model->password = '';
   
            return $this->render('loginSite', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
       $this->layout="install";
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
               if($user->status== UserStatus::INACTIVE){
                  return $this->render('waitsignup', [
                    'model' => $model,
                     ]);
                   
               }else{
                   if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                         
               }
                
                
            }
        }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

   

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout="install";
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', yii::t('base.actions','New password saved.'));

            return $this->goHome();
        }
       
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    public function actionProfile(){
        
       // echo \common\helpers\FileHelper::getUrlImageUserGuest();die();
     /* if(h::app()->hasModule('sta')){
          $this->redirect(\yii\helpers\Url::toRoute('/sta/default/profile'));
      }*/
        $model =Yii::$app->user->getProfile() ;
        $identidad=Yii::$app->user->identity;
        $identidad->setScenario($identidad::SCENARIO_MAIL);
       // var_dump($model);die();
        if ($identidad->load(Yii::$app->request->post()) && $identidad->save() &&                
                $model->load(Yii::$app->request->post()) && $model->save()) {
           // var_dump($model->getErrors()   );die();
            yii::$app->session->setFlash('success','grabo');
            return $this->redirect(['profile', 'id' => $model->user_id]);
        }else{
           // var_dump($model->getErrors()   );die();
        }

        return $this->render('profile', [
            'identidad'=>$identidad,
            'model' => $model,
        ]);
    }
    
    /*
     * Visualiza otros perfiles 
     */
     public function actionViewProfile($iduser){
         $newIdentity=h::user()->identity->findOne($iduser);
      if(is_null($newIdentity))
          throw new BadRequestHttpException(yii::t('base.errors','User not found with id '.$iduser));  
           //echo $newIdentity->id;die();
     // h::user()->switchIdentity($newIdentity);
        $profile =$newIdentity->getProfile($iduser);
        //echo $model->id;die();
        return $this->render('profileother', [
            'profile' => $profile,
            'model'=>$newIdentity,
        ]);
    }
    
     public function actionAddfavorite(){
         $this->layout="install";
        $url=Yii::$app->request->referrer;  
        
        if(!is_null($url)){
            $url=str_replace(\yii\helpers\Url::home(true),'',$url);
           
            $model= new \common\models\Userfavoritos();
            $model->setAttributes([
                            'url'=>$url,
                             'user_id'=>h::userId(),
                                ]);        
          if ($model->load(Yii::$app->request->post()) && $model->save()) {           
           return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
                }        
        return $this->render('favorites', [
            'model' => $model,
        ]);
        }else{
            return;
        }
         
    }
    
    
    public function actionClearCache(){
       
       $datos=[];
       if(h::request()->isAjax){
           if( h::app()->hasModule('bigitems')){
              h::settings()->invalidateCache();
              $datos['success']=yii::t('base.actions','
Datos de caché de configuración han sido borrados');
            }
           h::response()->format = \yii\web\Response::FORMAT_JSON;
           return $datos;
        }
    }
    
    
    public function actionRequestPasswordReset()
    {
        $this->layout="install";
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            try{
                set_time_limit(300); // 5 minutes   
                $model->sendEmail();
                Yii::$app->getSession()->setFlash('success',yii::t('base.actions','Check your email for further instructions.'));
                return $this->goHome();
            } catch (\Swift_TransportException $Ste) { 
                //echo "intenado"; die();
                Yii::$app->getSession()->setFlash('error',yii::t('base.errors', 'Sorry, we are unable to reset password for email provided.'.$Ste->getMessage()));
           }
            
           
        }

        return $this->render('requestPasswordResetToken', [
                'model' => $model,
        ]);
    }
    
    public function actionManageUsers(){
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('users', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }
    
    /*
     * Esta funcion es simlar a sign-UP
     * solo que la usa el daminsitrador de
     * de la pagina o un usuario con toles para
     * manejar RBAC
     */
       public function actionCreateUser()
    {
      // $this->layout="install";
        $model = new SignupForm();
        $model->setScenario('createx');
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {   
                 yii::$app->session->
               setFlash('success',
            yii::t('base.actions','The user has been created'));
		
                  $this->redirect('manage-users');
            }
        }
        

        return $this->render('createuser', [
            'model' => $model,
        ]);
    }
public function actionRutas(){
   echo " Url::home()  :   ".Url::home()."<br>";
   echo " Url::home('https')  :   ".Url::home('https')."<br>";
   echo " Url::base()  :   ".Url::base()."<br>";
   echo " Url::base(true)  :   ".Url::base(true)."<br>";
   echo " Url::base('https')  :   ".Url::base('https')."<br>";
   echo " Url::canonical()  :   ".Url::canonical()."<br>";
   echo " Url::current()  :   ".Url::current()."<br>";
   echo " Url::previous()  :   ".Url::previous()."<br>";
   echo " UrlManager::getBaseUrl()  :   ".yii::$app->urlManager->getBaseUrl()."<br>";
   echo " UrlManager::getHostInfo()  :   ".yii::$app->urlManager->getHostInfo()."<br>";
   echo " UrlManager::getScriptUrl()  :   ".yii::$app->urlManager->getScriptUrl()."<br>";
   //yii::$app->urlManager->setHostInfo('');
   //echo " Url::base()  :   ".Url::base()."<br>";
   //echo " UrlManager::setHostInfo()   :   ".yii::$app->urlManager->setHostInfo('http://case.itekron.com/frontend/web/sta/entregas/update?id=32')."<br>";
}


}
