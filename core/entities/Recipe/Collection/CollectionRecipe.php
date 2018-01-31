<?php

namespace core\entities\Recipe\Collection;

use core\entities\Recipe\Recipe;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%collections_recipes}}".
 *
 * @property int $collection_id
 * @property int $recipe_id
 *
 * @property Collection $collection
 * @property Recipe $recipe
 */
class CollectionRecipe extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%collections_recipes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['collection_id', 'recipe_id'], 'required'],
            [['collection_id', 'recipe_id'], 'integer'],
            [['collection_id', 'recipe_id'], 'unique', 'targetAttribute' => ['collection_id', 'recipe_id']],
            //[['collection_id'], 'exist', 'skipOnError' => false, 'targetClass' => Collection::className(), 'targetAttribute' => ['collection_id' => 'id']],
            //[['recipe_id'], 'exist', 'skipOnError' => false, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'collection_id' => 'Collection ID',
            'recipe_id' => 'Recipe ID',
        ];
    }

    public function getCollection(): ActiveQuery
    {
        return $this->hasOne(Collection::className(), ['id' => 'collection_id']);
    }

    public function getRecipe(): ActiveQuery
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }
}
