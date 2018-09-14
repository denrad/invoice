<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "legal".
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $address
 * @property string $inn
 * @property string $kpp
 * @property string $checking_account
 * @property string $correspondent_account
 * @property string $bik
 * @property string $bank_name
 *
 * @property-read string|null  $typeText
 */
class Legal extends \yii\db\ActiveRecord
{
    const TYPE_IP = 'ip';
    const TYPE_NATURAL = 'natural';

    public static function types()
    {
        return [self::TYPE_IP, self::TYPE_NATURAL];
    }

    public static function typeLabels() : array
    {
        return [
          self::TYPE_IP => 'Индивидуальный предприниматель',
          self::TYPE_NATURAL => 'Компания',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'legal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'name', 'inn', 'checking_account', 'correspondent_account', 'address', 'bik', 'bank_name'], 'required'],
            [['type'], 'string', 'max' => 32],
            [['type'], 'in', 'range' => static::types()],
            [['name', 'checking_account', 'correspondent_account', 'bank_name'], 'string', 'max' => 255],
            [['inn', 'kpp'], 'string', 'max' => 12],
            [['inn', 'bik'], 'required'],
            [['kpp'], 'required', 'when' => function (self $model) {
                return $model->type === self::TYPE_NATURAL;
            }],
            [['bik'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'name' => 'Название',
            'address' => 'Адрес',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'checking_account' => 'Расчетный счет',
            'correspondent_account' => 'Кореспондентский счет',
            'bik' => 'БИК',
            'bank_name' => 'Название банка',
        ];
    }

    /**
     * @return string|null
     */
    public function getTypeText()
    {
        return self::typeLabels()[$this->type] ?? null;
    }

    /**
     * {@inheritdoc}
     * @return LegalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LegalQuery(get_called_class());
    }
}
