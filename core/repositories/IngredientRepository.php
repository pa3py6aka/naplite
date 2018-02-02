<?php

namespace core\repositories;


use core\entities\Article\Article;
use core\entities\Article\ArticleCategory;
use core\entities\Ingredient\Ingredient;
use core\entities\Ingredient\IngredientCategory;
use yii\data\ActiveDataProvider;

class IngredientRepository
{
    public function get($id): Ingredient
    {
        if (!$ingredient = Ingredient::findOne($id)) {
            throw new NotFoundException('Статья не найдена.');
        }
        return $ingredient;
    }

    public function getProvider(IngredientCategory $category, $search = null): ActiveDataProvider
    {
        $query = Ingredient::find();
        if (!$category->isRoot()) {
            $categoryIds[] = $category->id;
            foreach ($category->getDescendants()->all() as $child) {
                $categoryIds[] = $child->id;
            }
            $query->andWhere(['category_id' => $categoryIds]);
        }
        if ($search) {
            $query->andWhere(['like', 'title', $search]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 3, 'defaultPageSize' => 3], //ToDO: Количество ингредиентов на странице
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
    }

    public function save(Ingredient $ingredient)
    {
        if (!$ingredient->save()) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function remove(Ingredient $ingredient)
    {
        if (!$ingredient->delete()) {
            throw new \RuntimeException('Ошибка при удалении из базы.');
        }
    }
}