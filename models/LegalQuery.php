<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Legal]].
 *
 * @see Legal
 */
class LegalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Legal[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Legal|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
