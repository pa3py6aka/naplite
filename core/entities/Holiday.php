<?php

namespace core\entities;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%holidays}}".
 *
 * @property int $id
 * @property string $name
 */
class Holiday extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%holidays}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Название',
        ];
    }
}
