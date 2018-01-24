<?php

namespace core\services;


use core\entities\Ingredient;
use core\entities\IngredientSection;
use core\entities\Photo;
use core\entities\Recipe;
use core\entities\RecipeHoliday;
use core\forms\RecipeForm;
use core\components\PhotoSaver;
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

    public function create(RecipeForm $form): Recipe
    {
        $cookingTime = $this->getTime($form->cookingTimeHours, $form->cookingTimeMinutes);
        $preparationTime = $this->getTime($form->preparationTimeHours, $form->preparationTimeMinutes);

        $photos = [];
        $mainPhoto = null;
        foreach ($form->photos as $k => $photo) {
            if (is_file(Yii::getAlias('@tmp/' . $photo))) {
                if (copy(Yii::getAlias('@tmp/' . $photo), Yii::getAlias('@photoPath/' . $photo))) {
                    if ($form->mainPhoto == $k) {
                        $mainPhoto = $k;
                    }
                    $photos[] = ['file' => $photo, 'sort' => $form->mainPhoto == $k ? 0 : $k + 1];
                    copy(Yii::getAlias('@tmp/sm_' . $photo), Yii::getAlias('@photoPath/sm_' . $photo));
                } else {
                    throw new \DomainException("Не удалось сохранить фото");
                }
            }
        }

        $steps = [];
        foreach ($form->stepDescription as $n => $stepDescription) {
            if ($stepDescription) {
                $isPhoto = isset($form->stepPhoto[$n]) && $form->stepPhoto[$n] && is_file(Yii::getAlias('@tmp/' . $form->stepPhoto[$n]));
                $steps[] = ['description' => $stepDescription, 'photo' => $isPhoto ? $form->stepPhoto[$n] : ''];
                if ($isPhoto) {
                    copy(Yii::getAlias('@tmp/' . $form->stepPhoto[$n]), Yii::getAlias('@photoPath/' . $form->stepPhoto[$n]));
                }
            }
        }

        $holidays = $this->getHolidaysArray($form->holidays);

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
            $this->saveIngredients($form, $recipe->id);
        });

        $this->setMainPhoto($mainPhoto, $form, $recipe);

        return $recipe;
    }

    public function edit(Recipe $recipe, RecipeForm $form): void
    {
        $cookingTime = $this->getTime($form->cookingTimeHours, $form->cookingTimeMinutes);
        $preparationTime = $this->getTime($form->preparationTimeHours, $form->preparationTimeMinutes);

        $photos = [];
        $mainPhoto = null;
        foreach ($form->photos as $k => $photo) {
            if (is_file(Yii::getAlias('@photoPath/' . $photo))) {
                $photos[] = ['file' => $photo, 'sort' => $form->mainPhoto == $k ? 0 : $k + 1];
            } else if (is_file(Yii::getAlias('@tmp/' . $photo))) {
                $this->saveTmpPhoto($photos, $mainPhoto, $photo, $k, $form->mainPhoto);
            }
        }

        $steps = [];
        foreach ($form->stepDescription as $n => $stepDescription) {
            if ($stepDescription) {
                $isOldPhoto = isset($form->stepPhoto[$n]) && $form->stepPhoto[$n] && is_file(Yii::getAlias('@photoPath/' . $form->stepPhoto[$n]));
                $isPhoto = isset($form->stepPhoto[$n]) && $form->stepPhoto[$n] && is_file(Yii::getAlias('@tmp/' . $form->stepPhoto[$n]));
                if ($isOldPhoto) {
                    $steps[] = ['description' => $stepDescription, 'photo' => $form->stepPhoto[$n]];
                } else if ($isPhoto) {
                    $steps[] = ['description' => $stepDescription, 'photo' => $form->stepPhoto[$n]];
                    copy(Yii::getAlias('@tmp/' . $form->stepPhoto[$n]), Yii::getAlias('@photoPath/' . $form->stepPhoto[$n]));
                } else {
                    $steps[] = ['description' => $stepDescription, 'photo' => ''];
                }
            }
        }

        $recipe->edit(
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
            $steps
        );

        $this->transaction->wrap(function () use ($form, $recipe) {
            $this->repository->save($recipe);

            RecipeHoliday::deleteAll(['recipe_id' => $recipe->id]);
            foreach ($form->holidays as $id => $holiday) {
                $recipeHoliday = new RecipeHoliday([
                    'recipe_id' => $recipe->id,
                    'holiday_id' => $id
                ]);
                $this->repository->saveHoliday($recipeHoliday);
            }

            $this->repository->removeIngredientSections($recipe->id);
            $this->saveIngredients($form, $recipe->id);
        });

        $this->setMainPhoto($mainPhoto, $form, $recipe);
    }

    private function getTime($hours, $minutes): int
    {
        return (((int)$hours) * 60) + ((int)$minutes);
    }

    private function saveTmpPhoto(&$photos, &$mainPhoto, $photo, $photoNum, $mainPhotoNum)
    {
        if (copy(Yii::getAlias('@tmp/' . $photo), Yii::getAlias('@photoPath/' . $photo))) {
            if ($mainPhotoNum == $photoNum) {
                $mainPhoto = $photoNum;
            }
            $photos[] = ['file' => $photo, 'sort' => $mainPhotoNum == $photoNum ? 0 : $photoNum + 1];
            copy(Yii::getAlias('@tmp/sm_' . $photo), Yii::getAlias('@photoPath/sm_' . $photo));
        } else {
            throw new \DomainException("Не удалось сохранить фото");
        }
    }

    private function getHolidaysArray($holidays): array
    {
        $result = [];
        foreach ($holidays as $id => $holiday) {
            $result[] = ['holiday_id' => $id];
        }
        return $result;
    }

    private function saveIngredients(RecipeForm $form, $recipeId): void
    {
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
                'recipe_id' => $recipeId,
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
    }

    private function setMainPhoto($mainPhoto, RecipeForm $form, Recipe $recipe): void
    {
        if ($mainPhoto !== null) {
            if ($mainPhoto = Photo::find()->where(['file' => $form->photos[$mainPhoto]])->one()) {
                $recipe->main_photo_id = $mainPhoto->id;
                $this->repository->save($recipe);
            }
        }
    }
}