<?php

namespace core\services\manage;


use core\entities\Recipe\Category;
use core\forms\manage\CategoryForm;
use core\repositories\CategoryRepository;

class CategoryManageService
{
    private $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function create(CategoryForm $form)
    {
        $parent = $this->categories->get($form->parentId);
        $category = Category::create(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            $form->seoText
        );
        $category->appendTo($parent);
        $this->categories->save($category);
        $form->saveImage();
        $form->saveIcon();

        return $category;
    }

    public function edit($id, CategoryForm $form)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        $category->edit(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            $form->seoText
        );

        if ($form->parentId !== $category->parent->id) {
            $parent = $this->categories->get($form->parentId);
            $category->appendTo($parent);
        }

        $this->categories->save($category);
        $form->saveImage();
        $form->saveIcon();
    }
    public function remove($id)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        $this->categories->remove($category);
    }

    private function assertIsNotRoot(Category $category)
    {
        if ($category->isRoot()) {
            throw new \DomainException('Нельзя редактировать системную категорию.');
        }
    }
}