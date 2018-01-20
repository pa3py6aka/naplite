<?php

namespace core\services;


use core\entities\Ingredient;
use core\entities\IngredientSection;
use core\entities\Photo;
use core\entities\Recipe;
use core\forms\RecipeForm;
use core\repositories\RecipeRepository;
use Yii;

class RecipeService
{
    private $transaction;
    private $repository;

    public function __construct(TransactionManager $transaction, RecipeRepository $repository)
    {
        $this->transaction = $transaction;
        $this->repository = $repository;
    }

    public function create(RecipeForm $form)
    {
        /*$this->transaction->wrap(function () use ($form) {
            $cookingTime = (((int)$form->cookingTimeHours) * 60) + ((int)$form->cookingTimeMinutes);
            $preparationTime = (((int)$form->preparationTimeHours) * 60) + ((int)$form->preparationTimeMinutes);

            $recipe = Recipe::create(
                $form->categoryId,
                $form->name,
                $form->kitchenId,
                $form->introductoryText,
                $cookingTime,
                $preparationTime,
                $form->persons,
                $form->complexity,
                $form->notes,
                $form->commentsNotify,
                $holidays,
                $steps
            );

            foreach ($form->photos as $k => $photo) {
                if (is_file(Yii::getAlias('@tmp/' . $photo))) {
                    if (copy(Yii::getAlias('@tmp/' . $photo), Yii::getAlias('@photoPath/' . $photo))) {

                    } else {
                        throw new \DomainException("Не удалось сохранить фото");
                    }
                }
            }
        });*/

        $cookingTime = (((int)$form->cookingTimeHours) * 60) + ((int)$form->cookingTimeMinutes);
        $preparationTime = (((int)$form->preparationTimeHours) * 60) + ((int)$form->preparationTimeMinutes);

        $photos = [];
        $mainPhoto = null;
        foreach ($form->photos as $k => $photo) {
            if (is_file(Yii::getAlias('@tmp/' . $photo))) {
                if (copy(Yii::getAlias('@tmp/' . $photo), Yii::getAlias('@photoPath/' . $photo))) {
                    $photos[] = ['file' => $photo, 'sort' => $k];
                    if ($form->mainPhoto == $k) {
                        $mainPhoto = $k;
                    }
                } else {
                    throw new \DomainException("Не удалось сохранить фото");
                }
            }
        }

        $steps = [];
        foreach ($form->stepDescription as $n => $stepDescription) {
            if ($stepDescription) {
                $steps[] = ['description' => $stepDescription, 'photo' => isset($form->stepPhoto[$n]) ? $form->stepPhoto[$n] : ''];
            }
        }

        $holidays = [];
        foreach ($form->holidays as $id => $holiday) {
            $holidays[] = ['holiday_id' => $id];
        }

        $recipe = Recipe::create(
            $form->categoryId,
            $form->name,
            $form->kitchenId,
            $form->introductoryText,
            $cookingTime,
            $preparationTime,
            $form->persons,
            $form->complexity,
            $form->notes,
            $form->commentsNotify,
            $photos,
            $holidays,
            $steps
        );

        $this->transaction->wrap(function () use ($form, $recipe) {
            $this->repository->save($recipe);

            $ingredientSections = [];
            foreach ($form->ingredientName as $sectionNum => $ingredients) {
                $ingredientsToSave = [];
                $notEmpty = false;
                foreach ($ingredients as $k => $ingredient) {
                    if (
                        $ingredient
                        && isset($form->ingredientQuantity[$sectionNum][$k])
                        && (float) $form->ingredientQuantity[$sectionNum][$k]
                    ) {
                        $ingredientsToSave[] = [
                            'name' => $ingredient,
                            'quantity' => (float) $form->ingredientQuantity[$sectionNum][$k],
                            'uom' => isset($form->ingredientUom[$sectionNum][$k]) ? $form->ingredientUom[$sectionNum][$k] : ''
                        ];
                        $notEmpty = true;
                    }
                }
                if ($notEmpty) {
                    $ingredientSections[] = [
                        'name' => (isset($form->ingredientSection[$sectionNum]) && $form->ingredientSection[$sectionNum]) ? $form->ingredientSection[$sectionNum] : 'Основные ингредиенты',
                        'ingredients' => $ingredientsToSave,
                    ];
                }
            }
            foreach ($ingredientSections as $section) {
                $ingredientSection = new IngredientSection([
                    'recipe_id' => $recipe->id,
                    'name' => $section['name']
                ]);
                $ingredientSection->save();
                foreach ($section['ingredients'] as $item) {
                    $ingredient = new Ingredient([
                        'section_id' => $ingredientSection->id,
                        'name' => $item['name'],
                        'quantity' => $item['quantity'],
                        'uom' => $item['uom'],
                    ]);
                    $ingredient->save();
                }
            }
        });

        if ($mainPhoto !== null) {
            if ($mainPhoto = Photo::find()->where(['file' => $form->photos[$mainPhoto]])->one()) {
                $recipe->main_photo_id = $mainPhoto->id;
                $this->repository->save($recipe);
            }
        }

        return $recipe;
    }
}