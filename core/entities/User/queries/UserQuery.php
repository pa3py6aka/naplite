<?php

namespace core\entities\User\queries;


use core\entities\User\User;

/**
 * This is the ActiveQuery class for [[\core\entities\User\User]].
 *
 * @see \core\entities\User\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => User::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return \core\entities\User\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \core\entities\User\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
