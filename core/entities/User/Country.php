<?php

namespace core\entities\User;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%countries}}".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 *
 * @property User[] $users
 */
class Country extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%countries}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['code'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код',
            'name' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['country_id' => 'id']);
    }
}
