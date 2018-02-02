<?php

namespace core\services\manage;


use core\entities\Ingredient\IngredientCategory;
use core\forms\manage\IngredientCategoryForm;
use core\repositories\IngredientCategoryRepository;

class IngredientCategoryManageService
{
    private $categories;

    public function __construct(IngredientCategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function create(IngredientCategoryForm $form): IngredientCategory
    {
        $parent = $this->categories->get($form->parentId);
        $category = IngredientCategory::create(
            $form->name,
            $form->slug,
            $form->description
        );
        $category->appendTo($parent);
        $this->categories->save($category);
        $form->saveIcon();

        return $category;
    }

    public function edit($id, IngredientCategoryForm $form): void
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

    private function assertIsNotRoot(IngredientCategory $category)
    {
        if ($category->isRoot()) {
            throw new \DomainException('Нельзя редактировать системную категорию.');
        }
    }
}