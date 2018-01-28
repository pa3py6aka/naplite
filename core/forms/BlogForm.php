<?php

namespace core\forms;


use core\entities\Blog\Blog;
use yii\base\Model;

class BlogForm extends Model
{
    public $title;
    public $categoryId;
    public $content;

    public function __construct(Blog $blog = null, array $config = [])
    {
        if ($blog) {
            $this->title = $blog->title;
            $this->categoryId = $blog->category_id;
            $this->content = $blog->content;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title', 'categoryId', 'content'], 'required'],
            ['title', 'string', 'max' => 255],
            ['categoryId', 'integer'],
            ['content', 'string', 'max' => 5000],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'categoryId' => 'Раздел',
            'content' => 'Текст поста',
        ];
    }
}