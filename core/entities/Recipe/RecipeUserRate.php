<?php

namespace core\entities\Recipe;

use core\entities\User\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%recipe_user_rates}}".
 *
 * @property int $recipe_id
 * @property int $user_id
 * @property int $value
 *
 * @property Recipe $recipe
 * @property User $user
 */
class RecipeUserRate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recipe_user_rates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipe_id', 'user_id', 'value'], 'required'],
            [['recipe_id', 'user_id'], 'integer'],
            ['value', 'integer', 'min' => 1, 'max' => 5],
            //[['recipe_id', 'user_id'], 'unique', 'targetAttribute' => ['recipe_id', 'user_id']],
            //[['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'id']],
            //[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'recipe_id' => 'Рецепт',
            'user_id' => 'Пользователь',
            'value' => 'Значение',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
