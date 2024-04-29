<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SensorData $model */

$this->title = $model->sensor_id;
$this->params['breadcrumbs'][] = ['label' => 'Sensor Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sensor-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'sensor_id' => $model->sensor_id, 'time' => $model->time], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'sensor_id' => $model->sensor_id, 'time' => $model->time], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sensor_id',
            'time',
            'range',
        ],
    ]) ?>

</div>
