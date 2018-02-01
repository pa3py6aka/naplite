<?php

namespace core\repositories;


use core\entities\Recipe\IngredientSection;
use core\entities\Recipe\Recipe;
use core\entities\Recipe\RecipeHoliday;
use core\entities\User\UserRecipe;

class RecipeRepository
{
    public function get($id): Recipe
    {
        if (!$recipe = Recipe::findOne($id)) {
            throw new NotFoundException('Рецепт не найден.');
        }
        return $recipe;
    }

    public function getUserRecipe($userId, $recipeId): ?UserRecipe
    {
        return UserRecipe::find()->where(['user_id' => $userId, 'recipe_id' => $recipeId])->limit(1)->one();
    }

    public function save(Recipe $recipe): void
    {
        if (!$recipe->save(false)) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function saveUserRecipe(UserRecipe $userRecipe): void
    {
        if (!$userRecipe->save(false)) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function saveHoliday(RecipeHoliday $recipeHoliday)
    {
        if (!$recipeHoliday->save()) {
            throw new \RuntimeException('Ошибка записи праздника в базу.');
        }
    }

    public function updateFavoritesCount(int $recipeID): void
    {
        $count = UserRecipe::find()->where(['recipe_id' => $recipeID])->count();
        Recipe::updateAll(['favorites_count' => $count], ['id' => $recipeID]);
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