<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Legal;

/* @var $this yii\web\View */
/* @var $model app\models\forms\InvoiceForm */
/* @var $form ActiveForm */
/* @var $invoicePositions \app\models\InvoicePosition[] */

 $this->title = 'Создать счет';
?>
<div class="form">

    <?php $form = ActiveForm::begin(['id' => 'invoice-form']); ?>

        <?= $form->field($model, 'vat') ?>

        <?= Html::beginTag('fieldset'), Html::tag('legend', 'Продавец'); ?>
        <?= $form->field($model, 'seller_type')->dropDownList(Legal::typeLabels()) ?>
        <?= $form->field($model, 'seller_name') ?>
        <?= $form->field($model, 'seller_address'); ?>
        <?= $form->field($model, 'seller_inn') ?>
        <?= $form->field($model, 'seller_kpp') ?>

        <?= $form->field($model, 'seller_bik') ?>
        <?= $form->field($model, 'seller_bank_name') ?>
        <?= $form->field($model, 'seller_checking_account') ?>
        <?= $form->field($model, 'seller_correspondent_account') ?>

        <?= Html::endTag('fieldset'); ?>

        <?= Html::beginTag('fieldset'), Html::tag('legend', 'Покупатель'); ?>
        <?= $form->field($model, 'buyer_type')->dropDownList(Legal::typeLabels()) ?>
        <?= $form->field($model, 'buyer_name') ?>
        <?= $form->field($model, 'buyer_address') ?>
        <?= $form->field($model, 'buyer_inn') ?>
        <?= $form->field($model, 'buyer_kpp') ?>
        <?= $form->field($model, 'buyer_bik') ?>
        <?= $form->field($model, 'buyer_bank_name') ?>
        <?= $form->field($model, 'buyer_checking_account') ?>
        <?= $form->field($model, 'buyer_correspondent_account') ?>
        <?= Html::endTag('fieldset'); ?>

    <?php DynamicFormWidget::begin(
        [
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody'      => '.container-items',
            'widgetItem'      => '.item',
            'min'             => 1,
            'insertButton'    => '.add-item',
            'deleteButton'    => '.remove-item',
            'model'           => $invoicePositions[0],
            'formId'          => 'invoice-form',
            'formFields'      => [
                'name',
                'unit',
                'count',
                'cost',
            ],
        ]
    ) ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Позиция
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i
                        class="fa fa-plus"></i>Добавить</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items">
            <?php foreach ($invoicePositions as $index => $position) : ?>
                <div class="item panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title-address">
                            Новая позиция
                        </span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs">
                            <i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">

                        <?= !$position->isNewRecord ?
                            Html::activeHiddenInput($position, "[{$index}]id") :
                            ''
                        ?>

                        <?= $form->field($position, "[{$index}]name")->textInput(); ?>

                        <?= $form->field($position, "[{$index}]unit")->textInput(); ?>

                        <?= $form->field($position, "[{$index}]count")->textInput(); ?>

                        <?= $form->field($position, "[{$index}]cost")->textInput(); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php DynamicFormWidget::end() ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
