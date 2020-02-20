<?php
namespace frontend\models;

use yii\base\Model;
use mdm\admin\components\UserStatus;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
   public $status;
   

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' =>yii::t('base.errors','This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => yii::t('base.errors','This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            ['status', 'safe', 'on' => 'createx'],
            ['status', 'required', 'on' => 'createx'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        
        
        if ($this->validate()) {
           // $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            
            if($this->getScenario()=='createx'){
                 $user->status = $this->status;
                //echo "escenario->".$this->getScenario(); die();
            }else{
              $user->status = ArrayHelper::getValue(Yii::$app->params, 'user.defaultStatus', UserStatus::ACTIVE);
             
            }
           
           
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                
                 $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('r_basico');
        if(!is_null($authorRole ))
        $auth->assign($authorRole, $user->getId());
            //var_dump($user->status);die();
             
                
                
                return $user;
            }
        }
        
    }
    
   
}
