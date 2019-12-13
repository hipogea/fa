<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\selectwidget\selectWidget;
use frontend\modules\sigi\helpers\comboHelper;
use frontend\modules\sigi\models\SigiUnidades;
//use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-unidades-form">

    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField',
        'enableAjaxValidation' => true
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('sigi.labels', 'Grabar'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ComboHelper::getCboEdificios(),
               'campo'=>'edificio_id',
               'idcombodep'=>'sigiunidades-parent_id',
               /* 'source'=>[ //fuente de donde se sacarn lso datos 
                    /*Si quiere colocar los datos directamente 
                     * para llenar el combo aqui , hagalo coloque la matriz de los datos
                     * aqui:  'id1'=>'valor1', 
                     *        'id2'=>'valor2,
                     *         'id3'=>'valor3,
                     *        ...
                     * En otro caso 
                     * de la BD mediante un modelo  
                     */
                        /*Docbotellas::className()=>[ //NOmbre del modelo fuente de datos
                                        'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'codenvio'/* //cpolumna 
                                         * columna que sirve como criterio para filtrar los datos 
                                         * si no quiere filtrar nada colocwue : false | '' | null
                                         *
                        
                         ]*/
                   'source'=>[SigiUnidades::className()=>
                                [
                                        'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'nombre',//columna a mostrar 
                                        'campofiltro'=>'edificio_id'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div>       
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
     
    <?php
    $data=($model->isNewRecord)?[]:comboHelper::getCboSameUnits($model->edificio_id);
   echo  $form->field($model, 'parent_id')->
            dropDownList($data,
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
  
     </div>      
          
  <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">   
      
 <?= $form->field($model, 'codtipo')->
            dropDownList(comboHelper::getCboTipoUnidades(),
                  ['prompt'=>'--'.yii::t('base.verbs','--Seleccione un valor--')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
      
           
 <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">   
     <div class="block">
         <?=($model->isNewRecord)?Html::button('<span class="fa fa-refresh"></span>   ', ['id'=>'refresh-apo','class' => 'btn btn-success']):'' ?>
         
 <?php 
$data=($model->isNewRecord)?[]:comboHelper::getCboApoderados($model->edificio_id);
echo $form->field($model, 'codpro')->
            dropDownList($data,
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
    </div>    
 </div> 
          
     
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

 </div>     
  <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'npiso')->
            dropDownList(comboHelper::getCboPisos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div> 
 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>
  </DIV>
    
         
          
          
          
  
 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'imputable')->checkBox([]) ?>

 </div>

  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

 </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
      <?PHP IF(!$model->isNewRecord){ ?>
     <?=Html::label(yii::t('base.names','Participacion'),'45545rrxet',['class' => 'control-label']) ?>
           
            <?=  Html::textInput('45545rrxet',  $model->participacion(),['disabled'=>true,'class' => 'form-control form-group']) ?>
          
 </div>
      <?PHP } ?>
    <?php ActiveForm::end(); ?>

</div>
    </div>
<?php 
  $this->registerJs("$('#refresh-apo').on( 'click', function() { 
     // alert(this.id);
     var identidad=$('#sigiunidades-edificio_id').val();
    if(identidad==''){
                          var n = Noty('id');                      
                              $.noty.setText(n.options.id, '".yii::t('sigi.errors','Seleccione el edificio primero')."');
                              $.noty.setType(n.options.id, 'error'); 
                              return;
    }
      $.ajax({
              url: '".\yii\helpers\Url::to(['/sigi/unidades/fill-apoderados'])."', 
              type: 'get',
              data:{id:identidad},
              dataType: 'html', 
              error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(data) {
              $('#sigiunidades-codpro').html(data);
                   
                        }
                        });


             })", \yii\web\View::POS_READY);
?>