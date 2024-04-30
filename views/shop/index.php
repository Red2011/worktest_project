<?php

use app\models\Shops;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="shop-block">
    <div class="main-block">
        <div class="control-block">
            <?= Html::a('Добавить магазин', ['create'], ['class' => 'button-main button-info']) ?>
            <?= Html::a('Отправить данные', ['send'], ['class' => 'button-main button-info']) ?>
        </div>
        <?php if (count($dataProvider->getModels()) < 1): ?>
        <div class="shop-card" style="align-items: center">
            Данных нет
        </div>
        <?php else: ?>
            <?php foreach ($dataProvider->getModels() as $shop): ?>
                <div class="shop-card">
                    <ul class="shop-info">
                        <li class="shop-name">
                            <!--                обращаемся к контроллеру shop и его action view-->
                            Магазин:
                            <a href="<?= \yii\helpers\Url::to(['shop/view', 'id' => $shop->id]) ?>">
                                <?= $shop->name ?>
                            </a>
                        </li>
                        <li class="shop-name">
                            Дата создания: <?= Yii::$app->formatter->asDate($shop->create_date, 'php:d M Y H:i') ?>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php endif;?>
    </div>
    <div class="pagination">
        <!--            виджет не получает каждый раз для каждой страницы данные, например для меню, а делает-->
        <!--            это 1 раз и используется везде. Вызвать можно в шаблоне-->
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $dataProvider->pagination,
        ]) ?>
    </div>
</section>