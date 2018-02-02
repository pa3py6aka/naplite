<?php

namespace core\repositories;


use core\entities\Article\Article;
use core\entities\Article\ArticleCategory;
use core\entities\Ingredient\Ingredient;
use core\entities\Ingredient\IngredientCategory;
use yii\data\ActiveDataProvider;

class IngredientCategoryRepository
{
    /**
     * @param $id
     * @return IngredientCategory
     */
    public function get($id): IngredientCategory
    {
        if (!$category = IngredientCategory::findOne($id)) {
            throw new NotFoundException('Категория не найдена.');
        }
        return $category;
    }

    public function getBySlug($slug): IngredientCategory
    {
        if (!$category = IngredientCategory::find()->where(['slug' => $slug])->limit(1)->one()) {
            throw new NotFoundException('Категория не найдена.');
        }
        return $category;
    }

    public static function getCategories(): array
    {
        return IngredientCategory::find()->all();
    }

    public function save(IngredientCategory $category): void
    {
        if (!$category->save()) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function remove(IngredientCategory $category): void
    {
        if (!$category->delete()) {
            throw new \RuntimeException('Ошибка при удалении из базы.');
        }
    }
}