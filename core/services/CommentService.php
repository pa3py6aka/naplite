<?php

namespace core\services;


use core\entities\Recipe;
use core\entities\RecipeComment;
use core\forms\CommentForm;
use Yii;

class CommentService
{
    private $transaction;

    public function __construct(TransactionManager $transaction)
    {
        $this->transaction = $transaction;
    }

    public function addComment(CommentForm $form, Recipe $recipe)
    {
        $this->transaction->wrap(function () use ($form, $recipe) {
            $comment = RecipeComment::create(
                $recipe->id,
                Yii::$app->user->id,
                $form->content,
                $form->replyTo ?: null
            );
            if ($comment->save()) {
                $recipe->comments_count = RecipeComment::find()->where(['recipe_id' => $recipe->id])->count();
                $recipe->save(false);
            }
        });
    }
}