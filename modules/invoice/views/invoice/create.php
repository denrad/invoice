<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $invoicePositions \app\models\InvoicePosition[] */

$this->title = 'Create Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//echo \Yii::t('app', 'Число {n,number} прописью: {n, spellout}', ['n' => 42]);

?>
<div class="invoice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('model', 'invoicePositions')) ?>

</div>
