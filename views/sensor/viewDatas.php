<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Sensors $model */

\yii\web\YiiAsset::register($this);
?>
<!--модальное окно для данных устройства-->
<table class="sensors-table" style="margin: 0">
    <caption class="caption-sensor-data" style="caption-side: top;">Устройство: <?php echo $model->sensor_id ?></caption>
    <thead>
    <tr>
        <th>Время</th>
        <th>Значение</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($model->sensorDatas as $data): ?>
        <tr>
            <td><?php echo $data->time ?></td>
            <td><?php echo $data->range ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


