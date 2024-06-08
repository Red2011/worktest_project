<?php
    /** @var yii\web\View $this */

    /** @var Exception $exception */
    use yii\helpers\Html;

    $this->title = 'Ошибка';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="alert alert-danger">
    <?= nl2br(Html::encode('ошибка')) ?>
</div>
