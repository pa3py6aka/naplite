<?php

namespace core\entities\Recipe;

use core\helpers\ContentHelper;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%recipe_steps}}".
 *
 * @property int $id
 * @property int $recipe_id
 * @property string $description
 * @property string $photo
 *
 * @property string|null $photoUrl
 *
 * @property Recipe $recipe
 */
class RecipeStep extends ActiveRecord
{
    public function getPhotoUrl(): ?string
    {
        if ($this->photo) {
            return Yii::$app->params['frontendHostInfo'] . '/photos/' . $this->photo;
        }
        return null;
    }

    private function removePhoto(): void
    {
        if ($this->photo) {
            $path = Yii::getAlias('@photoPath/');
            if (
                is_file($path . $this->photo)
                && !self::find()->where(['photo' => $this->photo])->andWhere(['<>', 'id', $this->id])->exists()
            ) {
                unlink($path . $this->photo);
            }
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->description = ContentHelper::optimize($this->description);
            return true;
        }
        return false;
    }

    public function afterDelete()
    {
        $this->removePhoto();
        parent::afterDelete();
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%recipe_steps}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            //[['recipe_id', 'description', 'photo'], 'required'],
            [['recipe_id'], 'integer'],
            [['description'], 'string'],
            [['photo'], 'string', 'max' => 255],
            //[['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'recipe_id' => 'Recipe ID',
            'description' => 'Description',
            'photo' => 'Photo',
        ];
    }

    public function getRecipe(): ActiveQuery
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }
}
