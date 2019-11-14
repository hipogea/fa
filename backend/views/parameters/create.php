<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Centrosparametros */

$this->title = Yii::t('app', 'Create Centrosparametros');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Centrosparametros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="centrosparametros-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
