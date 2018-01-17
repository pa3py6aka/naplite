<?php

namespace core\entities;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%kitchens}}".
 *
 * @property int $id
 * @property string $name
 */
class Kitchen extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%kitchens}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
