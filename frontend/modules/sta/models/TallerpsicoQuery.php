<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[Tallerpsico]].
 *
 * @see Tallerpsico
 */
class TallerpsicoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tallerpsico[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tallerpsico|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
