<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Objects;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('objects', 'Objects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objects-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('objects', 'Create Objects'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => function($model) {
                    /** @var $model Objects */
                    return strip_tags($model->description);
                }
            ],
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($model) {
                    /** @var $model Objects */
                    return $model->typeName;
                }
            ],
            [
                'attribute' => 'company_id',
                'format' => 'raw',
                'value' => function($model) {
                    /** @var $model Objects */
                    if (isset($model->company_id)) {
                        return $model->company->name;
                    }
                    return '';
                }
            ],
            [
                'attribute' => 'file',
                'format' => 'raw',
                'value' => function($model) {
                    /** @var $model Objects */
                    return Html::a(
                        'Download File',
                            $model->getUploadUrl('file'),
                            [
                                'download' => true,
                                'data' => ['pjax' => 0]
                            ]
                    );
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
