<?php

namespace core\forms\manage;


use core\entities\Article\Article;
use core\entities\Article\ArticleCategory;
use yii\base\Model;
use yii\web\UploadedFile;

class ArticleManageForm extends Model
{
    public $title;
    public $categoryId;
    public $prevText;
    public $content;
    public $image;

    const SCENARIO_CREATE = 'create';

    public function __construct(Article $article = null, array $config = [])
    {
        if ($article) {
            $this->title = $article->title;
            $this->categoryId = $article->category_id;
            $this->prevText = $article->prev_text;
            $this->content = $article->content;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['title', 'categoryId', 'prevText', 'content'], 'required'],
            ['title', 'string', 'max' => 255],
            ['categoryId', 'integer'],
            ['categoryId', 'exist', 'targetClass' => ArticleCategory::class, 'targetAttribute' => 'id', 'filter' => ['<>', 'id', 1], 'message' => 'Выберите категорию'],
            [['prevText', 'content'], 'string'],
            ['image', 'required', 'on' => self::SCENARIO_CREATE],
            ['image', 'image', 'extensions' => 'jpg, jpeg, png, gif'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['title', 'categoryId', 'prevText', 'content', 'image'];
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
        ];
    }
}