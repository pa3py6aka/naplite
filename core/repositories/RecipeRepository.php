<?php

namespace core\repositories;


use core\entities\Recipe\Category;
use core\entities\Recipe\IngredientSection;
use core\entities\Recipe\Recipe;
use core\entities\Recipe\RecipeHoliday;
use core\entities\User\UserRecipe;
use yii\data\ActiveDataProvider;

class RecipeRepository
{
    public function get($id): Recipe
    {
        if (!$recipe = Recipe::findOne($id)) {
            throw new NotFoundException('Рецепт не найден.');
        }
        return $recipe;
    }

    public function findRecipes(string $search): ActiveDataProvider
    {
        $query = Recipe::find()->active()->andWhere([
            'or',
            ['like', 'name', $search],
            ['like', 'introductory_text', $search],
            ['like', 'notes', $search]
        ]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 3, 'defaultPageSize' => 3], //ToDO: Количество рецептов на странице поиска
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
    }

    public function getUserRecipe($userId, $recipeId): ?UserRecipe
    {
        return UserRecipe::find()->where(['user_id' => $userId, 'recipe_id' => $recipeId])->limit(1)->one();
    }

    public function getUserFavoriteRecipes($userId, Category $category = null): ActiveDataProvider
    {
        $query = Recipe::find()
            ->alias('r')
            ->leftJoin(UserRecipe::tableName() . ' ur', 'ur.recipe_id=r.id')
            ->andWhere(['ur.user_id' => $userId])
            ->active('r');

        if ($category && $category->depth > 0) {
            $categories = $category->getDescendants()->all();
            $categoriesIds = [$category->id];
            foreach ($categories as $child) {
                $categoriesIds[] = $child->id;
            }
            $query->andWhere(['r.category_id' => $categoriesIds]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 3, 'defaultPageSize' => 3], //ToDO: Количество рецептов в кулинарной книге юзера
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
    }

    public function getUserRecipes($userId): ActiveDataProvider
    {
        $query = Recipe::find()
            ->alias('r')
            ->leftJoin(UserRecipe::tableName() . ' ur', 'ur.user_id=r.id')
            ->active()
            ->andWhere(['r.author_id' => $userId]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 3, 'defaultPageSize' => 3], //ToDO: Количество рецептов пользователя
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
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