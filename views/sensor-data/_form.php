<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SensorData $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sensor-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sensor_id')->textInput() ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <?= $form->field($model, 'range')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
