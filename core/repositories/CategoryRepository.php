<?php

namespace core\repositories;


use core\entities\Recipe\Category;
use core\entities\Recipe\Recipe;
use yii\data\ActiveDataProvider;

class CategoryRepository
{
    /**
     * @param $id
     * @return \core\entities\Recipe\Category
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
        $query = Recipe::find()->active()->with('author');

        if ($category->depth > 0) {
            $categories = $category->getDescendants()->all();
            $categoriesIds = [$category->id];
            foreach ($categories as $child) {
                $categoriesIds[] = $child->id;
            }
            $query->andWhere(['category_id' => $categoriesIds]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 3, 'defaultPageSize' => 3], //ToDO: Количество рецептов на странице
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