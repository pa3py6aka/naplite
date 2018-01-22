<?php

namespace core\repositories;


use core\entities\Category;
use core\entities\Recipe;
use yii\data\ActiveDataProvider;

class CategoryRepository
{
    /**
     * @param $id
     * @return Category
     */
    public function get($id): Category
    {
        if (!$category = Category::findOne($id)) {
            throw new NotFoundException('Категория не найдена.');
        }
        return $category;
    }

    public function getBySlug($slug): Category
    {
        if (!$category = Category::find()->where(['slug' => $slug])->limit(1)->one()) {
            throw new NotFoundException('Категория не найдена.');
        }
        return $category;
    }

    public function getRecipesProviderByCategory(Category $category): ActiveDataProvider
    {
        $categories = $category->getDescendants()->all();
        $categoriesIds = [$category->id];
        foreach ($categories as $child) {
            $categoriesIds[] = $child->id;
        }
        return new ActiveDataProvider([
            'query' => Recipe::find()
                ->active()
                ->where(['category_id' => $categoriesIds]),
            'pagination' => ['pageSize' => 1, 'defaultPageSize' => 1],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
    }

    public function save(Category $category)
    {
        if (!$category->save()) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function remove(Category $category)
    {
        if (!$category->delete()) {
            throw new \RuntimeException('Ошибка при удалении из базы.');
        }
    }
}