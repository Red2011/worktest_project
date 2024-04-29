<?php

use app\models\SensorData;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Sensor Datas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sensor-data-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Sensor Data', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sensor_id',
            'time',
            'range',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SensorData $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'sensor_id' => $model->sensor_id, 'time' => $model->time]);
                 }
            ],
        ],
    ]); ?>


</div>
