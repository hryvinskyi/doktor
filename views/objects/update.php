<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Objects */

$this->title = Yii::t('objects', 'Update {modelClass}: ', [
    'modelClass' => 'Objects',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('objects', 'Objects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('objects', 'Update');
?>
<div class="objects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
