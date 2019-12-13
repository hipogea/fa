<?php
use kriss\calendarSchedule\CalendarScheduleWidget;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sta\staModule;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="borereuccess">   
  <div class="box-body">               
<?php
  IF(staModule::getCurrentPeriod()==$codperiodo){?>
    <div class="alert alert-info"><span class="fa fa-book-reader"></span><?='    '.$modelPsico->trabajador->fullName()?></div>
     
      
        
            
   <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
 
 <?PHP     
$jsRemoveCallback = <<<JS
function(title) {
  console.log('removeCallback', title);
}
JS;

$jsCreateCallback = <<<JS
function(title, color) {
  console.log('createCallback', title, color);
}
JS;
echo CalendarScheduleWidget::widget([
    'defaultEventDuration'=>$model->taller->duracioncita,
    'draggableEvents' => [
        'items' => $items,/*[
            ['name' => 'Lunes', 'color' => '#286090'],
            ['name' => 'Martes', 'color' => '#f0ad4e'],
            ['name' => 'Miercoles', 'color' => '#286090'],
            ['name' => 'Jueves', 'color' => '#f0ad4e'],
            ['name' => 'Viernes', 'color' => '#286090'],
            ['name' => 'Sabado', 'color' => '#f0ad4e'],
            
        ],*/
        'removeCallback' => new JsExpression($jsRemoveCallback)
    ],
    'createEvents' => [
        'colors' => ['#286090', '#5cb85c', '#5bc0de', '#f0ad4e', '#d9534f'],
        'createCallback' => new JsExpression($jsCreateCallback)
    ],
    'fullCalendarOptions' => [
        
       /*  'validRange'=>[
                'start'=>'2019-11-05',
                'end'=>'2019-11-19'
                ],*/
        //'formatDate'=>'dd/mm/yyyy',
         'locale'=>'es',
        
       'events' => $citasPendientes,
        
        /*'events' => [
            ['title' => 'evento 1', 'start' => date('Y-m-d 10:00:00'), 'end' => date('Y-m-d 20:00:00'), 'color' => '#286090'],
            ['title' => 'evento 2', 'start' => date('Y-m-10 10:00:00'), 'allDay' => true, 'color' => '#5bc0de'],
        ],*/
        
        
        
        'eventReceive' => new JsExpression('function(event, delta,minuteDelta, revertFunc) {
       if (confirm("'.yii::t('sta.labels','¿Confirmar que desea crear esta Cita ?').'")) {
                  var fechainicio=event.start.format("YYYY-MM-DD HH:mm:ss");
        $.ajax({ 
                    method:"get",    
                    url: "'.\yii\helpers\Url::toRoute('/sta/programas/make-cita-by-student').'",
                    delay: 250,
                        data: {id:'.$model->id.', fecha:fechainicio,codalu:event.title  },
             error:  function(xhr, textStatus, error){               
                            revertFunc();
                                }, 
              success: function(json) {  
                        var n = Noty("id");
                       if ( !(typeof json["error"]==="undefined") ) {
                       revertFunc();
                   $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-remove-sign\'></span>      "+ json["error"]);
                              $.noty.setType(n.options.id, "error"); 
                              }
                         if ( !(typeof json["success"]==="undefined") ) {
                                        $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-ok-sign\'></span>" + json["success"]);
                             $.noty.setType(n.options.id, "success");
                              } 
                               if ( !(typeof json["warning"]==="undefined") ) {
                                        $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-info-sign\'></span>" +json["warning"]);
                             $.noty.setType(n.options.id, "warning");
                              } 
                              
                      
                        },
   cache: true
  })
        }else{
      revertFunc();
      }
                             
                                    }'),
        'eventDrop' => new JsExpression('function(event, delta,minuteDelta, revertFunc) {
       if (confirm("Are you sure about this change?")) {
                  var fechainicio=event.start.format("YYYY-MM-DD HH:mm:ss");
        $.ajax({ 
                    method:"get",    
                    url: "'.\yii\helpers\Url::toRoute('/sta/programas/make-cita-by-student').'",
                    delay: 250,
                        data: {id:'.$model->id.', fecha:fechainicio,codalu:event.title  },
             error:  function(xhr, textStatus, error){               
                            revertFunc();
                                }, 
              success: function(json) {  
                        var n = Noty("id");
                       if ( !(typeof json["error"]==="undefined") ) {
                       revertFunc();
                   $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-remove-sign\'></span>      "+ json["error"]);
                              $.noty.setType(n.options.id, "error"); 
                              }
                         if ( !(typeof json["success"]==="undefined") ) {
                                        $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-ok-sign\'></span>" + json["success"]);
                             $.noty.setType(n.options.id, "success");
                              } 
                               if ( !(typeof json["warning"]==="undefined") ) {
                                        $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-info-sign\'></span>" +json["warning"]);
                             $.noty.setType(n.options.id, "warning");
                              } 
                              
                      
                        },
   cache: true
  })
        }else{
      revertFunc();
      }
                             
                                    }'),
        'eventResize' => new JsExpression('function(event, delta, revertFunc) {
                    alert(event.title + " SE MOVIO A     INICIO->" + event.start.format("YYYY-MM-DD H:m:s")+ "   FIN  -> "+event.end.format("YYYY-MM-DD HH:mm:ss") );
                    if (!confirm("Are you sure about this change?")) {
                    

                             revertFunc(); }}'),
        'eventClick' => new JsExpression('function(event) {'
                . 'if (confirm("'.yii::t('sta.labels','¿Confirmar que desea notificar ?').'")) {
                 $.ajax({ 
                    method:"get",    
                    url: "'.\yii\helpers\Url::toRoute('/sta/programas/notifica-cita').'",
                    delay: 250,
                        data: {idalu:'.$idalu.',id:'.$model->id.',idcita:event.id, psicoid:'.$modelPsico->id.',codalu:event.title  },
             error:  function(xhr, textStatus, error){               
                            revertFunc();
                                }, 
              success: function(json) {  
                        var n = Noty("id");
                       if ( !(typeof json["error"]==="undefined") ) {
                      // revertFunc();
                   $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-remove-sign\'></span>      "+ json["error"]);
                              $.noty.setType(n.options.id, "error"); 
                              }
                         if ( !(typeof json["success"]==="undefined") ) {
                                        $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-ok-sign\'></span>" + json["success"]);
                             $.noty.setType(n.options.id, "success");
                              } 
                               if ( !(typeof json["warning"]==="undefined") ) {
                                        $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-info-sign\'></span>" +json["warning"]);
                             $.noty.setType(n.options.id, "warning");
                              } 
                              
                      
                        },
   cache: true
  })
                }'
                . '}'),
    ]
]);?>
 </div>  
<?PHP
  }ELSE{ ?>
    <div class="alert alert-info"><span class="fa fa-book-reader"></span><?='    '.yii::t('sta.labels','La programación de citas sólo es posible en el periodo activo  '.staModule::getCurrentPeriod())?></div>  
 <?PHP }

?>
    
        
</div>
    </div>