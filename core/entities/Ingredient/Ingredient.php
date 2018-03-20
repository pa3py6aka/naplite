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
 * @property bool $show [tinyint(1)]
 *
 * @property IngredientCategory $category
 * @property IngredientComment[] $comments
 */
class Ingredient extends ActiveRecord
{
    public static function create($categoryId, $title, $prevText, $content, $show): Ingredient
    {
        $ingredient = new self();
        $ingredient->category_id = $categoryId;
        $ingredient->title = $title;
        $ingredient->prev_text = $prevText;
        $ingredient->content = $content;
        $ingredient->show = $show;
        return $ingredient;
    }

    public function edit($categoryId, $title, $prevText, $content, $show): void
    {
        $this->category_id = $categoryId;
        $this->title = $title;
        $this->prev_text = $prevText;
        $this->content = $content;
        $this->show = $show;
    }

    public function saveImage(UploadedFile $image): void
    {
        $name = $this->id . '_' . time() . '.' . $image->extension;
        $thumbName = 'th_' . $name;
        $path = $this->getImagePath();
        if ($image->saveAs($path . $name)) {
            Yii::$app->photoSaver->fitBySize($path . $name, 4530, 353, $path . $thumbName);
            Yii::$app->photoSaver->fitBySize($path . $name, 870, 570);
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

    public function getUrl($forCP = false, $anchor = null): string
    {
        return $forCP ?
            Yii::$app->frontendUrlManager->createAbsoluteUrl(['/ingredients/view', 'id' => $this->id]) :
            Url::to(array_merge(['/ingredients/view', 'id' => $this->id], $anchor ? ['#' => $anchor] : []));
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
            'show' => 'Показывать в списке ингредиентов',
        ];
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(IngredientCategory::className(), ['id' => 'category_id']);
    }

    public function getComments(): ActiveQuery
    {
        return $this->hasMany(IngredientComment::className(), ['ingredient_id' => 'id']);
    }
}
