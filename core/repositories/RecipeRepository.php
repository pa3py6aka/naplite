<?php

namespace core\repositories;


use core\entities\Recipe;

class RecipeRepository
{
    /**
     * @param $id
     * @return Recipe
     */
    public function get($id)
    {
        if (!$recipe = Recipe::findOne($id)) {
            throw new NotFoundException('Рецепт не найден.');
        }
        return $recipe;
    }

    public function save(Recipe $recipe)
    {
        if (!$recipe->save(false)) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function remove(Recipe $recipe)
    {
        if (!$recipe->delete()) {
            throw new \RuntimeException('Ошибка при удалении из базы.');
        }
    }
}