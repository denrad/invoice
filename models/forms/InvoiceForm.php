<?php

namespace app\models\forms;

use app\models\Invoice;
use app\models\InvoicePosition;
use app\models\Legal;
use yii\base\Model;

class InvoiceForm extends Model
{
    public $id;

    public $total_cost;

    public $vat;

    public $buyer_type;
    public $buyer_name;
    public $buyer_inn;
    public $buyer_kpp;
    public $buyer_checking_account;
    public $buyer_correspondent_account;
    public $buyer_bik;
    public $buyer_bank_name;
    public $buyer_address;

    public $seller_type;
    public $seller_name;
    public $seller_inn;
    public $seller_kpp;
    public $seller_checking_account;
    public $seller_correspondent_account;
    public $seller_bik;
    public $seller_bank_name;
    public $seller_address;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [
                [
                    'buyer_name',
                    'buyer_inn',
                    'buyer_bik',
                    'buyer_bank_name',
                    'buyer_checking_account',
                    'buyer_correspondent_account',
                    'seller_name',
                    'seller_inn',
                    'seller_bik',
                    'seller_bank_name',
                    'seller_checking_account',
                    'seller_correspondent_account',
                    'seller_address',
                    'buyer_address',
                ],
                'required'
            ],

            ['total_cost', 'number', 'min' => 0.01],
            ['vat', 'integer', 'min' => 0, 'max' => 100, 'skipOnEmpty' => false],
            [['seller_type', 'buyer_type'], 'in', 'range' => Legal::types()],
            [
                ['seller_name', 'buyer_name', 'seller_bank_name', 'buyer_bank_name'],
                'string',
                'max' => 255,
                'skipOnEmpty' => false
            ],
            [['seller_inn', 'buyer_inn'], 'integer', 'min' => 1000000000],
            [['seller_inn', 'buyer_inn'], 'string', 'min' => 10, 'max' => 12],
            [
                ['seller_kpp'],
                'string',
                'length' => 9,
                'when' => function (self $model) {
                    return $model->seller_type === Legal::TYPE_NATURAL;
                }
            ],
            [
                ['buyer_kpp'],
                'string',
                'length' => 9,
                'when' => function (self $model) {
                    return $model->buyer_type === Legal::TYPE_NATURAL;
                }
            ],
            [
                [
                    'seller_checking_account',
                    'buyer_checking_account',
                    'seller_correspondent_account',
                    'buyer_correspondent_account'
                ],
                'string',
                'length' => 20,
            ],
            [['seller_bik', 'buyer_bik'], 'integer'],
            [['seller_bik', 'buyer_bik'], 'string', 'length' => 9],
        ];
    }

    public function attributeLabels()
    {
        return [
            'total_cost' => 'Общая стоимость',
            'vat' => 'НДС%',

            'seller_type' => 'Тип продавца',
            'buyer_type' => 'Тип покупателя',
            'seller_name' => 'Название продавца',
            'buyer_name' => 'Название покупателя',
            'seller_inn' => 'ИНН продавца',
            'buyer_inn' => 'ИНН покупателя',
            'seller_kpp' => 'КПП продавца',
            'buyer_kpp' => 'КПП покупателя',
            'seller_address' => 'Адрес продавца',
            'buyer_address' => 'Адрес покупателя',
            'seller_checking_account' => 'Расчетный счет продавца',
            'buyer_checking_account' => 'Расчетный счет покупателя',
            'seller_correspondent_account' => 'Кореспондентский счет продавца',
            'buyer_correspondent_account' => 'Кореспондентский счет покупателя',
            'seller_bik' => 'БИК продавца',
            'buyer_bik' => 'БИК покупателя',
            'seller_bank_name' => 'Название банка продавца',
            'buyer_bank_name' => 'Название банка покупателя',
        ];
    }

    /**
     * @param InvoicePosition[] $positions
     * @return bool|mixed
     * @throws \Throwable
     */
    public function save(array $positions)
    {
        if (!$this->validate()) {
            return false;
        }

        // Выполняем сохранение в транзакции
        return \Yii::$app->db->transaction(function () use ($positions) {

            $buyerAttributes = [
                'type' => $this->buyer_type,
                'name' => $this->buyer_name,
                'inn' => $this->buyer_inn,
                'kpp' => $this->buyer_kpp,
                'bik' => $this->buyer_bik,
                'bank_name' => $this->buyer_bank_name,
                'checking_account' => $this->buyer_checking_account,
                'correspondent_account' => $this->buyer_correspondent_account,
                'address' => $this->buyer_address,
            ];

            $sellerAttributes = [
                'type' => $this->seller_type,
                'name' => $this->seller_name,
                'inn' => $this->seller_inn,
                'kpp' => $this->seller_kpp,
                'bik' => $this->seller_bik,
                'bank_name' => $this->seller_bank_name,
                'checking_account' => $this->seller_checking_account,
                'correspondent_account' => $this->seller_correspondent_account,
                'address' => $this->seller_address,
            ];

            // Находим покупателя с такими данными или создаем новую запись
            if (!$buyer = Legal::findOne($buyerAttributes)) {
                $buyer = new Legal($buyerAttributes);
                $buyer->save();
            }

            // Находим продавца с такими данными или создаем новую запись
            if (!$seller = Legal::findOne($sellerAttributes)) {
                $seller = new Legal($sellerAttributes);
                $seller->save();
            }

            $invoice = new Invoice();
            $invoice->seller_id = $seller->id;
            $invoice->buyer_id = $buyer->id;
            $invoice->vat = $this->vat;
            // Общая стоимость - сумма всех позиций
            $invoice->total_cost = array_sum(array_column($positions, 'total'));

            if (!$invoice->save()) {
                // Если есть ошибки - при сохранении - выводим их
                $this->addErrors($invoice->errors);
                return false;
            }

            foreach ($positions as $position) {
                /** @var InvoicePosition $position */
                $position->invoice_id = $invoice->id;
                $position->save();
            }

            $this->id = $invoice->id;

            return true;
        });
    }
}