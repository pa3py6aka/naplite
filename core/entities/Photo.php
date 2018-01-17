<?php

namespace core\entities;

use Yii;

/**
 * This is the model class for table "{{%recipe_photos}}".
 *
 * @property int $id
 * @property int $recipe_id
 * @property string $file
 * @property int $sort
 *
 * @property Recipes $recipe
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recipe_photos}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipe_id', 'file', 'sort'], 'required'],
            [['recipe_id', 'sort'], 'integer'],
            [['file'], 'string', 'max' => 255],
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
            'file' => 'File',
            'sort' => 'Sort',
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
