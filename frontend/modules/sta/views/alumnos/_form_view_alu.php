<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Alumnos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alumnos-form">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="btn-group">
            <?php  foreach($model->periodsInRisk() as $period){   ?>
            <a href="<?=\yii\helpers\Url::toRoute(['/sta/alumnos/ver-detalles','id'=>$model->id, 'codperiodo'=>$period])?>" data-pjax="0" target="_blank" class="btn btn-warning btn-lg ">
            <i class="glyphicon glyphicon-calendar" aria-hidden="true"></i> <?=$period?>
            </a>
            <?php  }   ?>
        </div>
        
    </div>
    <?php $form = ActiveForm::begin(); ?>
      
      <div class="box-body">
        <?php //print_r($model->attributes);var_dump($model->facultad); die(); ?>

  <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
     <?= Html::label(yii::t('base.names','Facultad'),'45545rret',['class' => 'control-label']) ?>
           <?php if( $model->hasProperty('facultad')){ ?>
            <?=  Html::input('text', 'namefacu', $model->facultad->desfac,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php } else { ?>
            <?=  Html::input('text', 'namefacu', $model->desfac,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php }  ?>
 </div>
  
   <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
     <?= Html::label(yii::t('base.names','Carrera'),'4u5545rret',['class' => 'control-label']) ?>
     <?php if( $model->hasProperty('carrera')){ ?>
            <?=  Html::input('text', 'namefacxu', $model->carrera->descar,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php } else { ?>
            <?=  Html::input('text', 'namefacxu', $model->descar,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php }  ?>
                   
                  
 </div>
          
          
       
         
              <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?= $form->field($model, 'ap')->textInput(['disabled' => 'disabled']) ?>

                  </div>

                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                       <?= $form->field($model, 'am')->textInput(['disabled' => 'disabled']) ?>

                     </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                           <?= $form->field($model, 'nombres')->textInput(['disabled' => 'disabled'])?>

                              </div>
                            
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                  <img src="<?=$model->getUrlImage()?>" class="img-thumbnail">
              </div>
               
          
          
          
          
          
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                           <?php  //h::settings()->invalidateCache();  ?>
                       <?= $form->field($model, 'nombres')->textInput(['disabled' => 'disabled'])?>

                           </div>
          
          
          
          
          
 
          
            
  
          
          
  
          
          
          
          
          
          
          
          
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'dni')->textInput(['disabled' => 'disabled']) ?>

 </div>
  <div class="col-lg-3 col-md-12 col-sm-6 col-xs-12">
     <?= $form->field($model, 'domicilio')->textInput(['disabled' => 'disabled']) ?>

 </div>
   
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'celulares')->textInput(['disabled' => 'disabled']) ?>
 </div>        
          
     <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'fijos')->textInput(['disabled' => 'disabled']) ?>
 </div>        
              
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'correo')->textInput(['disabled' => 'disabled']) ?>
 </div>       
          
  
     
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
