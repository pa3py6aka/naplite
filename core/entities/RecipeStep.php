<?php

namespace core\entities;

use Yii;

/**
 * This is the model class for table "{{%recipe_steps}}".
 *
 * @property int $id
 * @property int $recipe_id
 * @property string $description
 * @property string $photo
 *
 * @property Recipes $recipe
 */
class RecipeStep extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recipe_steps}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipe_id', 'description', 'photo'], 'required'],
            [['recipe_id'], 'integer'],
            [['description'], 'string'],
            [['photo'], 'string', 'max' => 255],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipes::className(), 'targetAttribute' => ['recipe_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recipe_id' => 'Recipe ID',
            'description' => 'Description',
            'photo' => 'Photo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipes::className(), ['id' => 'recipe_id']);
    }
}
