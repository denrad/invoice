<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[InvoicePosition]].
 *
 * @see InvoicePosition
 */
class InvoicePositionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return InvoicePosition[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return InvoicePosition|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
