<?php

namespace core\services\manage;


use core\entities\Article\ArticleCategory;
use core\forms\manage\ArticleCategoryForm;
use core\repositories\ArticleCategoryRepository;

class ArticleCategoryManageService
{
    private $categories;

    public function __construct(ArticleCategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function create(ArticleCategoryForm $form): ArticleCategory
    {
        $parent = $this->categories->get($form->parentId);
        $category = ArticleCategory::create(
            $form->name,
            $form->slug,
            $form->description
        );
        $category->appendTo($parent);
        $this->categories->save($category);
        $form->saveIcon();

        return $category;
    }

    public function edit($id, ArticleCategoryForm $form): void
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        $category->edit(
            $form->name,
            $form->slug,
            $form->description
        );

        if ($form->parentId != $category->parent->id) {
            $parent = $this->categories->get($form->parentId);
            $category->appendTo($parent);
        }

        $this->categories->save($category);
        $form->saveIcon();
    }

    public function remove($id): void
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        $this->categories->remove($category);
    }

    private function assertIsNotRoot(ArticleCategory $category)
    {
        if ($category->isRoot()) {
            throw new \DomainException('Нельзя редактировать системную категорию.');
        }
    }
}