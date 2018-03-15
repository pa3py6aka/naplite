<?php

namespace core\entities;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%uoms}}".
 *
 * @property int $id
 * @property string $name
 * @property string $f2 [varchar(50)]
 * @property string $f5 [varchar(50)]
 */
class Uom extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%uoms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'f2', 'f5'], 'string', 'max' => 50],
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
            'name' => 'Форма 1',
            'f2' => 'Форма 2',
            'f5' => 'Форма 5',
        ];
    }
}
