<?php

namespace core\entities\Recipe;

use core\entities\Recipe\Recipe;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%recipe_photos}}".
 *
 * @property int $id
 * @property int $recipe_id
 * @property string $file
 * @property int $sort
 *
 * @property Recipe $recipe
 */
class Photo extends ActiveRecord
{
    private function removeImages(): void
    {
        if ($this->file) {
            $path = Yii::getAlias('@photoPath/');
            if (
                is_file($path . $this->file)
                && !self::find()->where(['file' => $this->file])->andWhere(['<>', 'id', $this->id])->exists()
            ) {
                unlink($path . $this->file);
                if (is_file($path . 'sm_' . $this->file)) {
                    unlink($path . 'sm_' . $this->file);
                }
            }
        }
    }

    public function afterDelete()
    {
        $this->removeImages();
        parent::afterDelete();
    }

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
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'id']],
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
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }
}
