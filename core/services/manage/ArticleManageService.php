<?php

namespace core\services\manage;


use core\entities\Article\Article;
use core\forms\manage\ArticleManageForm;
use core\repositories\ArticleRepository;
use yii\web\UploadedFile;

class ArticleManageService
{
    private $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ArticleManageForm $form): Article
    {
        $user = \Yii::$app->user;
        $article = Article::create(
            $user->id,
            $form->categoryId,
            $form->title,
            $form->prevText,
            $form->content
        );
        $this->repository->save($article);
        if ($form->image instanceof UploadedFile) {
            $article->saveImage($form->image);
            $this->repository->save($article);
        }

        return $article;
    }

    public function edit($id, ArticleManageForm $form): void
    {
        $article = $this->repository->get($id);
        $article->edit(
            $form->categoryId,
            $form->title,
            $form->prevText,
            $form->content
        );

        if ($form->image instanceof UploadedFile) {
            $article->saveImage($form->image);
        }
        $this->repository->save($article);
    }

    public function remove($id): void
    {
        $article = $this->repository->get($id);
        $this->repository->remove($article);
    }
}