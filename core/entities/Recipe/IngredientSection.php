<?php

namespace core\entities\Recipe;

use core\entities\Recipe\Recipe;
use core\entities\Recipe\RecipeIngredient;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%ingredient_sections}}".
 *
 * @property string $id
 * @property int $recipe_id [int(11)]
 * @property string $name
 *
 * @property Recipe $recipe
 * @property RecipeIngredient[] $ingredients
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
    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::className(),
                'relations' => ['ingredients'],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc

    public function rules()
    {
        return [
            [['id', 'recipe_id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    } */

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
    public function getRecipe()
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasMany(RecipeIngredient::className(), ['section_id' => 'id']);
    }
}
