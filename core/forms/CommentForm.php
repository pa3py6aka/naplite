<?php

namespace core\forms;


use yii\base\Model;

class CommentForm extends Model
{
    //public $recipeId;
    public $replyTo;
    public $content;

    public function rules()
    {
        return [
            [[/*'recipeId',*/ 'content'], 'required', 'message' => 'Напишите ваш комментарий'],
            [[/*'recipeId',*/ 'replyTo'], 'integer'],
            ['content', 'trim'],
            ['content', 'string', 'max' => 3000],
        ];
    }

    public function attributeLabels()
    {
        return [
            //'recipeId' => 'ID рецепта',
            'replyTo' => 'Кому ответ',
            'content' => 'Комментарий',
        ];
    }
}