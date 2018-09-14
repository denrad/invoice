<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property int $buyer_id
 * @property int $seller_id
 * @property string $total_cost
 * @property int $vat
 * @property int $created_at
 *
 * @property Legal $seller
 * @property Legal $buyer
 * @property InvoicePosition[] $positions
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
          [
              'class' => TimestampBehavior::class,
              'updatedAtAttribute' => false,
          ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['buyer_id', 'seller_id', 'total_cost'], 'required'],
            [['buyer_id', 'seller_id', 'vat'], 'integer'],
            [['total_cost'], 'number', 'min' => 0.01],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'buyer_id' => 'Покупатель',
            'seller_id' => 'Продавец',
            'total_cost' => 'Общая стоимость',
            'vat' => 'НДС',
            'created_at' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Legal::class, ['id' => 'seller_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyer()
    {
        return $this->hasOne(Legal::class, ['id' => 'buyer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositions()
    {
        return $this->hasMany(InvoicePosition::class, ['invoice_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return InvoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceQuery(get_called_class());
    }
}
