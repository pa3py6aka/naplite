<?php

namespace core\repositories;


use core\entities\IngredientSection;
use core\entities\Recipe;
use core\entities\RecipeHoliday;

class RecipeRepository
{
    public function get($id): Recipe
    {
        if (!$recipe = Recipe::findOne($id)) {
            throw new NotFoundException('Рецепт не найден.');
        }
        return $recipe;
    }

    public function save(Recipe $recipe): void
    {
        if (!$recipe->save(false)) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function saveHoliday(RecipeHoliday $recipeHoliday)
    {
        if (!$recipeHoliday->save()) {
            throw new \RuntimeException('Ошибка записи праздника в базу.');
        }
    }

    public function removeIngredientSections($recipeId): void
    {
        IngredientSection::deleteAll(['recipe_id' => $recipeId]);
    }

    public function remove(Recipe $recipe): void
    {
        if (!$recipe->delete()) {
            throw new \RuntimeException('Ошибка при удалении из базы.');
        }
    }
}