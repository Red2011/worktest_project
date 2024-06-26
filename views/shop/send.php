<?php

use app\models\Shops;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\UploadForm $model */
$this->title = \Yii::t('app', 'Sending data');
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="shop-block" style="justify-content: center; align-items: center">
    <!--    форма для отправки файла на сервер-->
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'jsonFile')->fileInput(['id' => 'inputJson']) ?>


    <button class="button-main button-info"><?= \Yii::t('app', 'Send data') ?></button>

    <?php ActiveForm::end() ?>
</section>
