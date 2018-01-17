<?php

namespace core\entities;

use Yii;

/**
 * This is the model class for table "{{%recipes}}".
 *
 * @property int $id
 * @property int $author_id
 * @property int $category_id
 * @property string $name
 * @property int $kitchen_id
 * @property int $main_photo_id
 * @property string $introductory_text
 * @property int $cooking_time
 * @property int $preparation_time
 * @property int $persons
 * @property int $complexity
 * @property string $notes
 * @property int $created_at
 * @property int $updated_at
 *
 * @property RecipePhotos[] $recipePhotos
 * @property RecipeSteps[] $recipeSteps
 * @property Users $author
 * @property Categories $category
 * @property Kitchens $kitchen
 */
class Recipe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recipes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'category_id', 'name', 'kitchen_id', 'introductory_text', 'created_at', 'updated_at'], 'required'],
            [['author_id', 'category_id', 'kitchen_id', 'main_photo_id', 'cooking_time', 'preparation_time', 'persons', 'complexity', 'created_at', 'updated_at'], 'integer'],
            [['introductory_text', 'notes'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['kitchen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kitchens::className(), 'targetAttribute' => ['kitchen_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'kitchen_id' => 'Kitchen ID',
            'main_photo_id' => 'Main Photo ID',
            'introductory_text' => 'Introductory Text',
            'cooking_time' => 'Cooking Time',
            'preparation_time' => 'Preparation Time',
            'persons' => 'Persons',
            'complexity' => 'Complexity',
            'notes' => 'Notes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipePhotos()
    {
        return $this->hasMany(RecipePhotos::className(), ['recipe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeSteps()
    {
        return $this->hasMany(RecipeSteps::className(), ['recipe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKitchen()
    {
        return $this->hasOne(Kitchens::className(), ['id' => 'kitchen_id']);
    }
}
