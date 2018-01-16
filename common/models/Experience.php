<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%experiences}}".
 *
 * @property int $id
 * @property string $name
 * @property int $rate
 * @property int $recipes
 * @property bool $system [tinyint(1)]
 *
 * @property User[] $users
 */
class Experience extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%experiences}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['rate', 'recipes'], 'integer'],
            [['name'], 'string', 'max' => 60],
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
            'name' => 'Name',
            'rate' => 'Rate',
            'recipes' => 'Recipes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['experience_id' => 'id']);
    }
}
