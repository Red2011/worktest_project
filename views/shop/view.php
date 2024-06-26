<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use kartik\icons\Icon;

Icon::map($this, Icon::FA);

/** @var yii\web\View $this */
/** @var app\models\Shops $shop */
$this->title = $shop->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Shops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<section class="shop-block view-shop">
    <div class="control-block">
        <?= Html::button(\Yii::t('app', 'Back'), ['class' => 'button-main button-back', 'onclick' => 'history.go(-1)']) ?>
        <p>
            <!--            download - action текущего контроллера-->
            <?= Html::a(\Yii::t('app', 'Settings file'), ['download', 'token' => $shop->token, 'name' => $shop->name], ['class' => 'button-main button-info']) ?>
            <?= Html::a(\Yii::t('app', 'To change'), ['update', 'id' => $shop->id], ['class' => 'button-main button-info']) ?>
            <?=
            Html::a(\Yii::t('app', 'Delete'), ['delete', 'id' => $shop->id], [
                'class' => 'button-main button-delete ',
                'data' => [
                    'confirm' => \Yii::t('app', 'Are you sure you want to delete the shop?'),
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
    </div>
    <div class="shop-card">
        <ul class="shop-info">
            <li class="shop-name noclick-info">
                <?= \Yii::t('app', 'Shop name') ?>: <?= $shop->name ?>
            </li>
            <li class="shop-name noclick-info">
                <?= \Yii::t('app', 'Address') ?>: <?= $shop->address ?>
            </li>
            <li class="shop-name noclick-info">
                <?= \Yii::t('app', 'Name of the WIFI network') ?>: <?= $shop->wifi_name ?>
            </li>
            <li class="shop-name noclick-info">
                <?= \Yii::t('app', 'Wifi password') ?>: <?= $shop->password ?>
            </li>
            <li class="shop-name noclick-info">
                <?= \Yii::t('app', 'Date of creation') ?>: <?= Yii::$app->formatter->asDate($shop->create_date) ?>
            </li>
        </ul>
    </div>
    <table class="sensors-table">
        <thead>
            <tr>
                <th><?= \Yii::t('app', 'Device') ?></th>
                <th><?= \Yii::t('app', 'Mac - address') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($shop->sensors) < 1): ?>
                <tr>
                    <td><?= \Yii::t('app', 'No value') ?></td>
                    <td><?= \Yii::t('app', 'No value') ?></td>
                </tr>
            <?php else: ?>
                <?php foreach ($shop->sensors as $sensor): ?>
                    <tr>
                        <td><?php echo $sensor->sensor_id ?></td>
                        <td class="block-delete">
                            <p style="margin: 0"><?php echo $sensor->mac ?></p>
                            <div>

                                <!--                            принцип работы модального окна в yii2 с ипользованием JS и готового виджета Modal-->
                                <?=
                                Html::a(Html::tag('i', '', ['class' => 'fa fa-search text-primary']), FALSE, ['value' => Url::to(['view-datas', 'sensors_id' => $sensor->id]),
                                    'id' => $sensor->id . "view",
                                    'class' => 'view-sensors'])
                                ?>

                                <?php
                                Modal::begin([
                                    'id' => $sensor->id . 'modalopen',
                                    'size' => 'modal-lg',
                                    'title' => \Yii::t('app', 'Data')
                                ])
                                ?>
                                <div id="<?= $sensor->id ?>modal"></div>
                                <?php Modal::end() ?>
                                <?php
                                //модальное окно
                                $modalOpen = '#' . $sensor->id . 'modalopen';
                                //кнопка для показа окна
                                $modalButton = '#' . $sensor->id . "view";
                                //div где всё будет отображено
                                $modalID = "#" . $sensor->id . "modal";
                                //отображение в модальном окне value у Html::a
                                $js = <<<JS
                            $('$modalButton').click(function(){
                                        $('$modalID').load($(this).attr('value'));
                                        $('$modalOpen').modal('show');
                                    });
                            JS;
                                $this->registerJs($js);
                                ?>

                                <!--                        --><?php
                                //= Html::a('х', ['delete-sensor', 'sensor' => $sensor->id, 'token'=>$shop->token], [
                                //                                'class' => 'sensor-delete ms-2',
                                //                                'data' => [
                                //                                    'confirm' => 'Уверены, что хотите удалить устройство?',
                                //                                    'method' => 'post',
                                //                                ],
                                //                        ])
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!--    <div class="button-add-sensor">-->
    <!--        --><?php //= Html::a('+', FALSE, ['value' => Url::to(['add-sensor', 'token' => $shop->token]),'class' => 'inner', 'id'=>'open-modal-button'])   ?>
    <!--    </div>-->
    <!---->
    <!--    --><?php
    //Modal::begin([
    //        'id' => 'modal',
    //        'size' => 'modal-lg',
    //        'title' => 'Добавить новое устройство'
    //    ])
    ?>
    <!--    <div id="modal-content"></div>-->
    <!--    --><?php //Modal::end()   ?>
    <!--    --><?php
    //    $this->registerJs("
    //    $('#open-modal-button').click(function(){
    //        $('#modal-content').load($(this).attr('value'));
    //        $('#modal').modal('show');
    //    });
    //");
    //
    ?>

</section>

