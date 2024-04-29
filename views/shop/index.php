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
<!--<div class="shops-index">-->
<!---->
<!--   <h1>--><?php ////= Html::encode($this->title) ?><!--</h1>-->
<!---->
<!--    <p>-->
<!--        --><?php //= Html::a('Create Shops', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->
<!---->
<!---->
<!--    --><?php //= GridView::widget([
//        'dataProvider' => $dataProvider,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
//            'name',
//            'address',
//            'wifi_name',
//            'password',
//            //'token',
//            //'create_date',
//            [
//                'class' => ActionColumn::className(),
//                'urlCreator' => function ($action, Shops $model, $key, $index, $column) {
//                    return Url::toRoute([$action, 'id' => $model->id]);
//                 }
//            ],
//        ],
//    ]); ?>
<!---->
<!---->
<!--</div>-->
<section class="shop-block">
    <div class="main-block">
        <div class="control-block">
            <?= Html::a('Добавить магазин', ['create'], ['class' => 'button-main button-info']) ?>
            <?= Html::a('Отправить данные', ['send'], ['class' => 'button-main button-info']) ?>
        </div>
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
    </div>
    <div class="pagination">
        <!--            виджет не получает каждый раз для каждой страницы данные, например для меню, а делает-->
        <!--            это 1 раз и используется везде. Вызвать можно в шаблоне-->
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $dataProvider->pagination,
        ]) ?>
    </div>
</section>