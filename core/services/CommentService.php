<?php

namespace core\services;


use core\entities\Blog\Blog;
use core\entities\Blog\BlogComment;
use core\entities\Recipe;
use core\entities\RecipeComment;
use core\forms\CommentForm;
use Yii;

class CommentService
{
    /*private $transaction;

    public function __construct(TransactionManager $transaction)
    {
        $this->transaction = $transaction;
    }*/

    /**
     * @param CommentForm $form
     * @param Recipe|Blog $entity
     */
    public function addComment(CommentForm $form, $entity): void
    {
        $commentEntity = $entity instanceof Recipe ? RecipeComment::class : BlogComment::class;
        $comment = $commentEntity::create(
            $entity->id,
            Yii::$app->user->id,
            $form->content,
            $form->replyTo ?: null
        );

        $comment->save();//print_r($comment->getErrors());exit;
        /*$this->transaction->wrap(function () use ($form, $entity) {

           / ($comment->save()) {
               $commentEntity = $entity instanceof Recipe ? RecipeComment::class : BlogComment::class;
               $entity->comments_count = $commentEntity::find()->where(['recipe_id' => $recipe->id])->count();
               $recipe->save(false);
           }
        });*/
    }
}