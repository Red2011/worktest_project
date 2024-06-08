<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Sensors $model */
?>
<!--модальное окно для создания устройства-->
<div class="sensors-create">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>

