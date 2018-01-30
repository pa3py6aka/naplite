<?php

namespace core\entities\Recipe;

use core\entities\Recipe\Recipe;
use core\entities\User\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%photo_reports}}".
 *
 * @property int $id
 * @property int $recipe_id
 * @property int $user_id
 * @property string $file
 * @property int $created_at
 * @property int $updated_at
 *
 * @property string $imageUrl
 *
 * @property Recipe $recipe
 * @property User $user
 */
class PhotoReport extends ActiveRecord
{
    public static function create($recipeId, $userId): PhotoReport
    {
        $report = new self();
        $report->recipe_id = $recipeId;
        $report->user_id = $userId;
        $report->file = null;
        return $report;
    }

    public function getImageUrl($thumb = true, $forCP = false)
    {
        return ($forCP ? Yii::$app->params['frontendHostInfo'] : '')
            . '/uploads/reports/'
            . ($thumb ? 'sm_' : '') . $this->file;
    }

    public static function tableName(): string
    {
        return '{{%photo_reports}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules(): array
    {
        return [
            [['recipe_id', 'user_id'], 'required'],
            [['recipe_id', 'user_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['recipe_id'], 'exist', 'skipOnError' => false, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'id']],
            //[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'recipe_id' => 'Рецепт',
            'user_id' => 'Пользователь',
            'file' => 'Файл',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
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
