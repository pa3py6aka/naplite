<?php

namespace core\entities\Ingredient;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%ingredients}}".
 *
 * @property int $id
 * @property int $category_id
 * @property string $title [varchar(255)]
 * @property string $prev_text
 * @property string $content
 * @property string $image
 *
 * @property IngredientCategory $category
 */
class Ingredient extends ActiveRecord
{
    public static function create($categoryId, $title, $prevText, $content): Ingredient
    {
        $ingredient = new self();
        $ingredient->category_id = $categoryId;
        $ingredient->title = $title;
        $ingredient->prev_text = $prevText;
        $ingredient->content = $content;
        return $ingredient;
    }

    public function edit($categoryId, $title, $prevText, $content): void
    {
        $this->category_id = $categoryId;
        $this->title = $title;
        $this->prev_text = $prevText;
        $this->content = $content;
    }

    public function saveImage(UploadedFile $image): void
    {
        $name = $this->id . '_' . time() . '.' . $image->extension;
        $thumbName = 'th_' . $name;
        $path = $this->getImagePath();
        if ($image->saveAs($path . $name)) {
            Yii::$app->photoSaver->fitBySize($path . $name, 430, 280, $path . $thumbName);
            Yii::$app->photoSaver->fitBySize($path . $name, 860, 560);
            if ($this->image && $this->image != $name) {
                $this->removeImages();
            }
            $this->image = $name;
        }
    }

    private function removeImages(): void
    {
        if ($this->image) {
            $path = $this->getImagePath();
            if (is_file($path . $this->image)) {
                unlink($path . $this->image);
            }
            if (is_file($path . 'th_' . $this->image)) {
                unlink($path . 'th_' . $this->image);
            }
        }
    }

    public function getImageUrl($thumb = true, $forCP = false): ?string
    {
        if (!$this->image) {
            return null;
        }
        return ($forCP ? Yii::$app->params['frontendHostInfo'] : '') . '/uploads/ing/' . ($thumb ? 'th_' : '') . $this->image;
    }

    private function getImagePath(): string
    {
        return Yii::getAlias('@uploads') . '/ing/';
    }

    public function getUrl($forCP = false): string
    {
        return $forCP ?
            Yii::$app->frontendUrlManager->createAbsoluteUrl(['/ingredients/view', 'id' => $this->id]) :
            Url::to(['/ingredients/view', 'id' => $this->id]);
    }

    public function afterDelete()
    {
        $this->removeImages();
        parent::afterDelete();
    }

    public static function tableName(): string
    {
        return '{{%ingredients}}';
    }

    public function rules(): array
    {
        return [
            [['category_id', 'prev_text', 'content'], 'required'],
            [['category_id'], 'integer'],
            [['prev_text', 'content'], 'string'],
            [['image'], 'string', 'max' => 40],
            [['category_id'], 'exist', 'skipOnError' => false, 'targetClass' => IngredientCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'title' => 'Название',
            'prev_text' => 'Превью',
            'content' => 'Контент',
            'image' => 'Картинка',
        ];
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(IngredientCategory::className(), ['id' => 'category_id']);
    }
}
