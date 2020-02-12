<?php
namespace frontend\modules\report\components;
use  frontend\modules\report\Module;
use yii\grid\DataColumn;
use yii\helpers\Html;
class columnGridReport extends DataColumn 
{
  public $format='raw';
  public $linkOptions=['target'=>'_blank','data-pjax'=>'0'];
  protected function renderDataCellContent($model, $key, $index)
    {
      //$options=[];  
      //if ($this->content !== null) {
        //return parent::renderDataCellContent($model, $key, $index); 
        return Html::a('<span  style="color:orange; font-size:19px;"><i class="glyphicon glyphicon-paste " aria-hidden="true"></i></span>',Module::urlReport($model->reporte_id, $model->getPrimaryKey()), $this->linkOptions);
      //}
    
    }
    
    
}
