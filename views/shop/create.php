<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Shops $shop */

$this->title = 'Создание нового магазина';
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="shops-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'shop' => $shop,
    ]) ?>

</div>