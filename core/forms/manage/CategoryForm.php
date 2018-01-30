<?php

namespace core\forms\manage;


use core\entities\Recipe\Category;
use core\validators\SlugValidator;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


class CategoryForm extends Model
{
    public $name;
    public $slug;
    public $title;
    public $description;
    public $seoText;
    public $parentId;
    public $image;
    public $icon;

    private $_category;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->seoText = $category->seo_text;
            $this->parentId = $category->parent ? $category->parent->id : null;
            $this->_category = $category;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['parentId'], 'integer'],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            [['description', 'seoText'], 'string'],
            ['slug', SlugValidator::class],
            [['slug'], 'unique', 'targetClass' => Category::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null],
            ['image', 'image', 'extensions' => 'jpg'],
            ['icon', 'image', 'extensions' => 'png'],
        ];
    }

    public function beforeValidate()
    {
        $this->image = UploadedFile::getInstance($this, 'image');
        $this->icon = UploadedFile::getInstance($this, 'icon');
        return parent::beforeValidate();
    }

    public function saveImage()
    {
        if ($this->image instanceof UploadedFile) {
            /* @var $image UploadedFile */
            $image = $this->image;
            $name = Yii::getAlias('@uploads') . '/cat-' . $this->slug . '.jpg';
            $image->saveAs($name);
            Yii::$app->photoSaver->fitBySize($name, 570, 400);
        }
    }

    public function saveIcon()
    {
        if ($this->icon instanceof UploadedFile) {
            /* @var $icon UploadedFile */
            $icon = $this->icon;
            $name = Yii::getAlias('@uploads') . '/ico_cat-' . $this->slug . '.png';
            $icon->saveAs($name);
        }
    }

    public static function parentCategoriesList($withRoot = true)
    {
        $cats = ArrayHelper::map(Category::find()->orderBy('lft')->asArray()->all(), 'id', function (array $category) {
            return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth'] - 1) . ' ' : '') . $category['name'];
        });

        if (!$withRoot) {
            $value = reset($cats);
            $key   = key($cats);
            unset($cats[$key]);
        }

        return $cats;
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'slug' => 'Алиас',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'seoText' => 'Сеошный текст',
            'parentId' => 'Родительская категория',
            'image' => 'Картинка',
            'icon' => 'Иконка',
        ];
    }
}