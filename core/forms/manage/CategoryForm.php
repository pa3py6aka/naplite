<?php

namespace core\forms\manage;


use core\entities\Category;
use core\validators\SlugValidator;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoryForm extends Model
{
    public $name;
    public $slug;
    public $title;
    public $description;
    public $parentId;

    private $_category;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
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
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            [['description'], 'string'],
            ['slug', SlugValidator::class],
            [['slug'], 'unique', 'targetClass' => Category::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null]
        ];
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
            'parentId' => 'Родительская категория',
        ];
    }
}