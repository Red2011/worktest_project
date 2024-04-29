<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Shops $shop */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="shops-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($shop, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($shop, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($shop, 'wifi_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($shop, 'password')->passwordInput(['maxlength' => true]) ?>

<!--    --><?php //= $form->field($shop, 'create_date')->textInput(['type' => 'datetime-local']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'button-main button-save']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

