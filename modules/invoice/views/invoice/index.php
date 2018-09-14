<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Счета';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать счет', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'seller.name:text:Покупатель',
            'buyer.name:text:Продавец',
            'total_cost',
            [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:d.m.Y H:i'],
            ],

            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
            ],
        ],
    ]); ?>
</div>
