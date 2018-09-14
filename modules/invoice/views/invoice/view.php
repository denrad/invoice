<?php

use yii\helpers\Html;
use app\models\Legal;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */

$invoiceId = "Счет №{$model->id} от " . date('d.m.Y', $model->created_at);
$this->title = $invoiceId;
$this->params['breadcrumbs'][] = ['label' => 'Счета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("h1 {text-align: center}")
?>
<div class="invoice-view">

    <p>
        Продавец: <?= Html::encode($model->seller->getTypeText()) ?> <?= Html::encode($model->seller->name) ?> <br>
        Адрес: <?= Html::encode($model->seller->address) ?> <br>
        ИНН: <?= Html::encode($model->seller->inn) ?> <br>
        <?php if ($model->seller->type == Legal::TYPE_NATURAL): ?>
            КПП: <?= Html::encode($model->seller->kpp) ?> <br>
        <?php endif; ?>
        Расчетный счет: <?= Html::encode($model->seller->checking_account) ?> <br>
        Кор. счет: <?= Html::encode($model->seller->correspondent_account) ?> <br>
        БИК: <?= Html::encode($model->seller->bik) ?> <br>
        Банк: <?= Html::encode($model->seller->bank_name) ?>
    </p>

    <p>
        Покупатель: <?= Html::encode($model->buyer->getTypeText()) ?> <?= Html::encode($model->buyer->name) ?> <br>
        Адрес: <?= Html::encode($model->buyer->address) ?> <br>
        ИНН: <?= Html::encode($model->buyer->inn) ?> <br>
        <?php if ($model->buyer->type == Legal::TYPE_NATURAL): ?>
            КПП: <?= Html::encode($model->buyer->kpp) ?> <br>
        <?php endif; ?>
        Расчетный счет: <?= Html::encode($model->buyer->checking_account) ?> <br>
        Кор. счет: <?= Html::encode($model->buyer->correspondent_account) ?> <br>
        БИК: <?= Html::encode($model->buyer->bik) ?> <br>
        Банк: <?= Html::encode($model->buyer->bank_name) ?>
    </p>

    <h1><?= Html::encode($invoiceId) ?></h1>
    <table width="100%" border="1">
        <tr>
            <th>№</th>
            <th>Наименование</th>
            <th>Ед. изм.</th>
            <th>Кол-во</th>
            <th>Цена</th>
            <th>Сумма</th>
        </tr>
        <?php
        $totalCount = 0;
        foreach ($model->positions as $i => $position):
            $totalCount += $position->count;
            ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= Html::encode($position->name) ?></td>
                <td><?= Html::encode($position->unit) ?></td>
                <td><?= Html::encode($position->count) ?></td>
                <td><?= Yii::$app->formatter->asCurrency($position->cost) ?></td>
                <td><?= Yii::$app->formatter->asCurrency($position->total) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">Итого:</td>
            <td><?= $totalCount ?></td>
            <td>&nbsp;</td>
            <td><?= Yii::$app->formatter->asCurrency($model->total_cost) ?> </td>
        </tr>
    </table>

    Сумма прописью: <?= Yii::t('app', 'Сумма прописью прописью: {n, spellout}', ['n' => $model->total_cost]) ?>.
    <?= $model->vat ? 'НДС ' . (int)$model->vat . '%' : 'Без НДС' ?>

</div>
