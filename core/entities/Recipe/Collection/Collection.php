<?php

namespace core\entities\Recipe\Collection;

use core\entities\Recipe\Category;
use core\entities\Recipe\Recipe;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;
use Zelenin\yii\behaviors\Slug;

/**
 * This is the model class for table "{{%collections}}".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $image
 * @property int $category_id
 * @property int $sort
 * @property bool $status [tinyint(1)]
 *
 * @property Category $category
 * @property CollectionRecipe[] $collectionsRecipes
 * @property Recipe[] $recipes
 */
class Collection extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_HIDDEN = 0;

    public static function create($title, $description, $categoryId = null): Collection
    {
        $collection = new self();
        $collection->title = $title;
        $collection->description = $description;
        $collection->category_id = $categoryId;
        $collection->sort = self::find()->max('sort') + 1;
        $collection->status = self::STATUS_ACTIVE;
        return $collection;
    }

    public function edit($title, $description, $categoryId = null): void
    {
        $this->title = $title;
        $this->description = $description;
        $this->category_id = $categoryId;
    }

    public function saveImage(UploadedFile $image): void
    {
        $name = $this->id . '_' . time() . '.' . $image->extension;
        $thumbName = 'th_' . $name;
        $path = $this->getImagePath();
        if ($image->saveAs($path . $name)) {
            Yii::$app->photoSaver->fitBySize($path . $name, 530, 353, $path . $thumbName);
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
        return ($forCP ? Yii::$app->params['frontendHostInfo'] : '') . '/uploads/cols/' . ($thumb ? 'th_' : '') . $this->image;
    }

    private function getImagePath(): string
    {
        return Yii::getAlias('@uploads') . '/cols/';
    }

    public function getUrl($forCP = false)
    {
        return $forCP ?
            Yii::$app->frontendUrlManager->createAbsoluteUrl(['/collections/view', 'slug' => $this->slug]) :
            Url::to(['/collections/view', 'slug' => $this->slug]);
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
        return '{{%collections}}';
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => Slug::class,
                'slugAttribute' => 'slug',
                'attribute' => 'title',
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }

    /**
     * @inheritdoc

    public function rules()
    {
        return [
            [['title', 'slug', 'description'], 'required'],
            [['description'], 'string'],
            [['category_id', 'sort'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 40],
            [['slug'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => false, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    } */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'slug' => 'Slug',
            'description' => 'Описание',
            'image' => 'Картинка',
            'category_id' => 'Категория',
            'sort' => 'Sort',
        ];
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getCollectionsRecipes(): ActiveQuery
    {
        return $this->hasMany(CollectionRecipe::className(), ['collection_id' => 'id']);
    }

    public function getRecipes(): ActiveQuery
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])
            ->viaTable('{{%collections_recipes}}', ['collection_id' => 'id']);
    }
}
