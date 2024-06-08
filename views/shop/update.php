<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Shops $shop */
$this->title = \Yii::t('app', 'Editing');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Shops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = \Yii::t('app', 'Change');
?>
<div class="shops-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'shop' => $shop,
    ])
    ?>

</div>
