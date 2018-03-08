<?php

namespace core\services\manage;


use core\entities\Ingredient\Ingredient;
use core\forms\manage\IngredientManageForm;
use core\repositories\IngredientRepository;
use yii\web\UploadedFile;

class IngredientManageService
{
    private $repository;

    public function __construct(IngredientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(IngredientManageForm $form): Ingredient
    {
        $ingredient = Ingredient::create(
            $form->categoryId,
            $form->title,
            $form->prevText,
            $form->content,
            $form->show
        );
        $this->repository->save($ingredient);
        if ($form->image instanceof UploadedFile) {
            $ingredient->saveImage($form->image);
            $this->repository->save($ingredient);
        }

        return $ingredient;
    }

    public function edit($id, IngredientManageForm $form): void
    {
        $ingredient = $this->repository->get($id);
        $ingredient->edit(
            $form->categoryId,
            $form->title,
            $form->prevText,
            $form->content,
            $form->show
        );

        if ($form->image instanceof UploadedFile) {
            $ingredient->saveImage($form->image);
        }
        $this->repository->save($ingredient);
    }

    public function remove($id): void
    {
        $ingredient = $this->repository->get($id);
        $this->repository->remove($ingredient);
    }
}