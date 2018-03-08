<?php

namespace core\forms\manage;


use core\entities\Article\Article;
use core\entities\Article\ArticleCategory;
use core\entities\Ingredient\Ingredient;
use core\entities\Ingredient\IngredientCategory;
use yii\base\Model;
use yii\web\UploadedFile;

class IngredientManageForm extends Model
{
    public $title;
    public $categoryId;
    public $prevText;
    public $content;
    public $image;
    public $show;

    const SCENARIO_CREATE = 'create';

    public function __construct(Ingredient $ingredient = null, array $config = [])
    {
        if ($ingredient) {
            $this->title = $ingredient->title;
            $this->categoryId = $ingredient->category_id;
            $this->prevText = $ingredient->prev_text;
            $this->content = $ingredient->content;
            $this->show = $ingredient->show;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['title', 'categoryId', 'prevText', 'content'], 'required'],
            ['title', 'string', 'max' => 255],
            ['categoryId', 'integer'],
            ['categoryId', 'exist', 'targetClass' => IngredientCategory::class, 'targetAttribute' => 'id', 'filter' => ['<>', 'id', 1], 'message' => 'Выберите категорию'],
            [['prevText', 'content'], 'string'],
            ['image', 'required', 'on' => self::SCENARIO_CREATE],
            ['image', 'image', 'extensions' => 'jpg, jpeg, png, gif'],
            ['show', 'boolean'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['title', 'categoryId', 'prevText', 'content', 'image', 'show'];
        return $scenarios;
    }

    public function beforeValidate()
    {
        $this->image = UploadedFile::getInstance($this, 'image');
        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'categoryId' => 'Категория',
            'prevText' => 'Превью-текст',
            'content' => 'Контент',
            'image' => 'Изображение',
            'show' => 'Отображать на странице ингредиентов',
        ];
    }
}