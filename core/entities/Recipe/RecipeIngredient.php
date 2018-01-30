<?php

namespace core\entities\Recipe;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%ingredients}}".
 *
 * @property int $id
 * @property string $section_id
 * @property string $name
 * @property double $quantity
 * @property string $uom
 *
 * @property IngredientSection $section
 */
class RecipeIngredient extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recipe_ingredients}}';
    }

    /**
     * @inheritdoc

    public function rules()
    {
        return [
            [['section_id', 'name', 'quantity', 'uom'], 'required'],
            [['section_id'], 'integer'],
            [['quantity'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['uom'], 'string', 'max' => 50],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => IngredientSection::className(), 'targetAttribute' => ['section_id' => 'id']],
        ];
    } */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section_id' => 'Раздел',
            'name' => 'Название',
            'quantity' => 'Количество',
            'uom' => 'Ед. измерения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(IngredientSection::className(), ['id' => 'section_id']);
    }
}
