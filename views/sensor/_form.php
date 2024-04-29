<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Sensors $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sensors-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mac')->textInput(['maxlength' => true, 'placeholder' => 'mac', 'value'=>'0']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'button-main button-save']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
