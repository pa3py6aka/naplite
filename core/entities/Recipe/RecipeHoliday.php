<?php

namespace core\entities\Recipe;

use core\entities\Holiday;
use core\entities\Recipe\Recipe;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%recipe_holidays}}".
 *
 * @property int $recipe_id
 * @property int $holiday_id
 *
 * @property Holiday $holiday
 * @property Recipe $recipe
 */
class RecipeHoliday extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recipe_holidays}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipe_id', 'holiday_id'], 'required'],
            [['recipe_id', 'holiday_id'], 'integer'],
            [['recipe_id', 'holiday_id'], 'unique', 'targetAttribute' => ['recipe_id', 'holiday_id']],
            [['holiday_id'], 'exist', 'skipOnError' => false, 'targetClass' => Holiday::className(), 'targetAttribute' => ['holiday_id' => 'id']],
            //[['recipe_id'], 'exist', 'skipOnError' => false, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'recipe_id' => 'Recipe ID',
            'holiday_id' => 'Holiday ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHoliday()
    {
        return $this->hasOne(Holiday::className(), ['id' => 'holiday_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }
}
