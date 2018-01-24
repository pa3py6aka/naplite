<?php

namespace core\forms\manage;


use core\entities\Article\ArticleCategory;
use core\validators\SlugValidator;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


class ArticleCategoryForm extends Model
{
    public $name;
    public $slug;
    public $description;
    public $parentId;
    public $icon;

    private $_category;

    public function __construct(ArticleCategory $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->description = $category->description;
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
            [['name', 'slug'], 'string', 'max' => 255],
            [['description'], 'string'],
            ['slug', SlugValidator::class],
            [['slug'], 'unique', 'targetClass' => ArticleCategory::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null],
            ['icon', 'image', 'extensions' => 'png'],
        ];
    }

    public function beforeValidate()
    {
        $this->icon = UploadedFile::getInstance($this, 'icon');
        return parent::beforeValidate();
    }

    public function saveIcon()
    {
        if ($this->icon instanceof UploadedFile) {
            /* @var $icon UploadedFile */
            $icon = $this->icon;
            $name = Yii::getAlias('@uploads') . '/ico_art_cat-' . $this->slug . '.png';
            $icon->saveAs($name);
        }
    }

    public static function parentCategoriesList($withRoot = true)
    {
        $cats = ArrayHelper::map(ArticleCategory::find()->orderBy('lft')->asArray()->all(), 'id', function (array $category) {
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
            'description' => 'Описание',
            'parentId' => 'Родительская категория',
            'icon' => 'Иконка',
        ];
    }
}