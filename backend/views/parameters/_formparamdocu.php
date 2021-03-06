<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use common\models\config\Parametros;
/* @var $this yii\web\View */
/* @var $model common\models\masters\Centrosparametros */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
use common\helpers\ComboHelper;
?>
<div class="centrosparametros-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
       <?= $form->field($model, 'codocu')->
            dropDownList(ComboHelper::getCboDocuments(),
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
    
       
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?php 
  // $necesi=new Parametros;
    echo \common\widgets\selectwidget\selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codparam',
            //'foreignskeys'=>[1,2,3],
        ]);  ?>
    </div>
   
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
