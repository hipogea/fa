<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>

    
   
  
     <div class="box-body">
   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    
    
<?php
//var_dump($grupo_id);die();
$idPjax="pjax_colector_".$grupo_id;
   

$gridColumns = [
                     [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function($url, $model) use ($idPjax){   
                        $url= \yii\helpers\Url::to(['edita-concepto-tree','id'=>$model->id,'gridName'=>$idPjax,'idModal'=>'buscarvalor']);
                        $options = [
                            'title' => Yii::t('base.verbs', 'Editar'), 
                            'class'=>'botonAbre',
                            'data-pjax'=>'0'
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                         'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                        
                    ]
                ],
               
                
                'cargo.codcargo',
                'cargo.descargo',
                ['attribute' => 'tasamora',],
                     [
                          'attribute' => 'regular',
                         'format' => 'raw',
                            'value' => function ($model) {
                            return \yii\helpers\Html::checkbox('regular[]', $model->regular, [ 'disabled' => true]);
                                   },
                      ],
                                           [
                          'attribute' => 'montofijo',
                         'format' => 'raw',
                            'value' => function ($model) {
                            return \yii\helpers\Html::checkbox('montofijo[]', $model->montofijo, [ 'disabled' => true]);
                                   },
                      ],
                                           [
                          'attribute' => 'individual',
                         'format' => 'raw',
                            'value' => function ($model) {
                            return \yii\helpers\Html::checkbox('individual[]', $model->individual, [ 'disabled' => true]);
                                   },
                      ],
                                           
            ]   ;

    
  ?>
   <div> 
  <?php
   Pjax::begin(['id'=>$idPjax]);
 echo GridView::widget([
    'id' => 'mygrilla',
    'dataProvider' => (new frontend\modules\sigi\models\SigiCargosedificioSearch())->searchByGrupo($grupo_id),
   'columns' => $gridColumns, // check the configuration for grid columns by clicking button above
    
    'pjax' => true, // pjax is set to always true for this demo
   'responsive' => TRUE,
    
]);
 
?>
   <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>$idPjax,
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?> 
 <?php
 $url= \yii\helpers\Url::to(['agrega-concepto-tree','id'=>$grupo_id,'gridName'=>$idPjax,'idModal'=>'buscarvalor']);
   echo \yii\helpers\Html::button(yii::t('base.verbs','Nuevo'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Agrupacion'),'id'=>'btn_grupos_edixr', 'class' => 'botonAbre btn btn-success']); 
 Pjax::end();
   
   ?>   

    </div>
</div>

  
       

