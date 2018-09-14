<?php

namespace app\models;

/**
 * This is the model class for table "invoice_position".
 *
 * @property int $id
 * @property int $invoice_id
 * @property string $name
 * @property string $unit
 * @property int $count
 * @property string $cost
 * @property-read float $total
 * @property Invoice $invoice
 */
class InvoicePosition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice_position';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'unit', 'invoice_id', 'count', 'cost'], 'required'],
            [['invoice_id', 'count'], 'integer'],
            [['cost'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 16],

            [['invoice_id'], 'exist', 'targetRelation' => 'invoice'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Счет',
            'name' => 'Название',
            'unit' => 'Единица измерения',
            'count' => 'Количество',
            'cost' => 'Цена за единицу',
            'total' => 'Всего',
        ];
    }

    /**
     * Общая стоимость позиции
     * @return float
     */
    public function getTotal()
    {
        return $this->cost * $this->count;
    }

    /**
     * {@inheritdoc}
     * @return InvoicePositionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoicePositionQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::class, ['id' => 'invoice_id']);
    }
}
