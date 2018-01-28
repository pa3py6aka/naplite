<?php

namespace core\entities\User;

use core\entities\Recipe;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_recipes}}".
 *
 * @property int $user_id
 * @property int $recipe_id
 *
 * @property Recipe $recipe
 * @property User $user
 */
class UserRecipe extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_recipes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'recipe_id'], 'required'],
            [['user_id', 'recipe_id'], 'integer'],
            [['user_id', 'recipe_id'], 'unique', 'targetAttribute' => ['user_id', 'recipe_id']],
            //[['recipe_id'], 'exist', 'skipOnError' => false, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'id']],
            //[['user_id'], 'exist', 'skipOnError' => false, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'recipe_id' => 'Recipe ID',
        ];
    }

    public function getRecipe(): ActiveQuery
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
