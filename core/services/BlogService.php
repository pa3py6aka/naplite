<?php

namespace core\services;


use core\entities\Blog\Blog;
use core\forms\BlogForm;
use core\repositories\BlogRepository;
use Yii;

class BlogService
{
    private $transaction;
    private $repository;

    public function __construct(TransactionManager $transaction, BlogRepository $repository)
    {
        $this->transaction = $transaction;
        $this->repository = $repository;
    }

    public function create(BlogForm $form): Blog
    {
        $blog = Blog::create(Yii::$app->user->id, $form->categoryId, $form->title, $form->content);
        $this->repository->save($blog);
        return $blog;
    }

    public function edit(Blog $blog, BlogForm $form): void
    {
        $blog->edit($form->categoryId, $form->title, $form->content);
        $this->repository->save($blog);
    }
}