<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Objects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="objects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <?= $form->field($model, 'type')->dropDownList(\app\models\Objects::getTypesArray()) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('objects', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
