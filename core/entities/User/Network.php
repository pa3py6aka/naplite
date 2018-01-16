<?php

namespace core\entities\User;

use Webmozart\Assert\Assert;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_networks}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $identity
 * @property string $network
 */
class Network extends ActiveRecord
{
    public static function create($network, $identity)
    {
        Assert::notEmpty($network);
        Assert::notEmpty($identity);
        $item = new static();
        $item->network = $network;
        $item->identity = $identity;
        return $item;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_networks}}';
    }
}
