<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('message', 'Sent');
$this->params['breadcrumbs'][] = $this->title;

rmrevin\yii\fontawesome\AssetBundle::register($this);

?>
<h4><?=Yii::t('message', 'Sent')?></h4>
<div class="box box-succes">
 <div class="box-body">  
<div class="message-index">

    <?= $this->render('_actions'); ?>

    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'headerOptions' => ['style' => 'width: 200px;'],
                'attribute' => 'to',
                'format' => 'raw',
                'value' => function ($message) {
                    if ($message->recipient) {
                        if (isset(Yii::$app->getModule('message')->userProfileRoute)) {
                            return Html::a($message->recipient->username, array_merge(
                                    Yii::$app->getModule('message')->userProfileRoute, ['id' => $message->to]), ['data-pjax' => 0]);
                        } else {
                            return $message->recipient->username;
                        }
                    }
                },
                'filter' => $users,
            ],
            [
                'headerOptions' => ['style' => 'width: 200px;'],
                'attribute' => 'created_at',
                'format' => 'datetime',
            ],
            [
                'attribute' => 'title',
                'format' => 'raw', // do not use 'format' => 'html' because the 'data-pjax=0' gets swallowed.
                'value' => function ($data) {
                    return Html::a($data->title, ['view', 'hash' => $data->hash], ['data-pjax' => 0]);
                },
            ],
        ],
    ]); ?>
</div>
 </div></div>