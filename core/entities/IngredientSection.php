<?php

namespace core\entities;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%ingredient_sections}}".
 *
 * @property string $id
 * @property string $name
 *
 * @property Ingredient[] $ingredients
 */
class IngredientSection extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ingredient_sections}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['section_id' => 'id']);
    }
}
