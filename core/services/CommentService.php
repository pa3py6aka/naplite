<?php

namespace core\services;


use Codeception\Exception\ConfigurationException;
use core\entities\Article\Article;
use core\entities\Article\ArticleComment;
use core\entities\Blog\Blog;
use core\entities\Blog\BlogComment;
use core\entities\Recipe\Recipe;
use core\entities\Recipe\RecipeComment;
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
     * @param Recipe|Blog|Article $entity
     * @throws ConfigurationException
     */
    public function addComment(CommentForm $form, $entity): void
    {
        if ($entity instanceof Recipe) {
            $commentEntity = RecipeComment::class;
        } else if ($entity instanceof Blog) {
            $commentEntity = BlogComment::class;
        } else if ($entity instanceof Article) {
            $commentEntity = ArticleComment::class;
        } else {
            throw new ConfigurationException("Неверная сущность");
        }

        $comment = $commentEntity::create(
            $entity->id,
            Yii::$app->user->id,
            $form->content,
            $form->replyTo ?: null
        );

        $comment->save();
    }
}