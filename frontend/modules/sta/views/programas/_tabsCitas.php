<?php
echo \common\widgets\spinnerWidget\spinnerWidget::widget();
?>
<h4><span class="fa fa-calendar"></span><?='   '.\yii\helpers\Html::encode(yii::t('sta.labels','Programar Alumno')).'-'.$model->codalu ?></h4>
<div class="box box-success">
<div class="box body">
<?php  
 use kartik\tabs\TabsX;
?>
<?php

 echo $this->render('/alumnos/auxiliares/_form_view_alu_basico',
               ['model'=>$model,
                ]);

?>
<?php 
 echo TabsX::widget([
     'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
            'label' =>'<i class="glyphicon glyphicon-hourglass"></i> '.yii::t('base.names','Citas'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_tab_citas',['codperiodo'=>$codperiodo,'dataProvider'=>$dataProvider]),
//'content' => $this->render('detalle',['form'=>$form,'orden'=>$this->context->countDetail(),'modelDetail'=>$modelDetail]),
            'active' => true,
             'options' => ['id' => 'tnID3'],
        ],
        [
            'label' =>'<i class="glyphicon glyphicon-calendar"></i> '. yii::t('base.names','Programación'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_tab_calendario',['codperiodo'=>$codperiodo,'idalu'=>$model->id,'modelPsico'=>$modelPsico,  'items'=>[['name'=>$codalu,'color'=>$color]],'citasPendientes'=>$citasPendientes,'model'=>$modelPsico]),
//'content' => $this->render('detalle',['form'=>$form,'orden'=>$this->context->countDetail(),'modelDetail'=>$modelDetail]),
            'active' => false,
             'options' => ['id' => 'myy6nID4'],
        ],
      [
            'label' =>'<i class="glyphicon glyphicon-calendar"></i> '. yii::t('base.names','Documentos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_tab_documentos',['model'=>$modelTallerdet]),
//'content' => $this->render('detalle',['form'=>$form,'orden'=>$this->context->countDetail(),'modelDetail'=>$modelDetail]),
            'active' => false,
             'options' => ['id' => 'mxx4ID4'],
        ],
    ],
]); 
    ?> 
</div>
    </div>