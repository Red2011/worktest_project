<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Shops $shop */
$this->title = \Yii::t('app', 'Creating a new shop');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Shops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="shops-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'shop' => $shop,
    ])
    ?>

</div>
