<?php

namespace core\repositories;


use core\entities\Recipe\Collection\Collection;
use core\entities\Recipe\Recipe;
use yii\data\ActiveDataProvider;

class CollectionRepository
{
    public function get($id): Collection
    {
        if (!$collection = Collection::findOne($id)) {
            throw new NotFoundException('Подборка не найдена.');
        }
        return $collection;
    }

    public function getBySort($count = 7)
    {
        return Collection::find()->where(['status' => Collection::STATUS_ACTIVE])->orderBy(['sort' => SORT_ASC])->limit($count)->all();
    }

    public function getBySlug($slug): Collection
    {
        if (!$collection = Collection::find()->where(['slug' => $slug])->limit(1)->one()) {
            throw new NotFoundException('Подборка не найдена.');
        }
        return $collection;
    }

    public function getCollectionsProvider(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Collection::find(),
            'pagination' => false,
            'sort' => ['defaultOrder' => ['sort' => SORT_ASC]]
        ]);
    }

    public function getRecipesProvider(Collection $collection): ActiveDataProvider
    {
        if ($collection->category_id) {
            $categories = $collection->category->getDescendants()->all();
            $categoriesIds = [$collection->category_id];
            foreach ($categories as $child) {
                $categoriesIds[] = $child->id;
            }
            $query = Recipe::find()->active()->andWhere(['category_id' => $categoriesIds]);
        } else {
            $query = $collection->getRecipes();
        }
        $query->with('author');

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 3, 'defaultPageSize' => 3], //ToDO: Количество статей на странице подборки
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
    }

    public function save(Collection $collection)
    {
        if (!$collection->save()) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function remove(Collection $collection)
    {
        if (!$collection->delete()) {
            throw new \RuntimeException('Ошибка при удалении из базы.');
        }
    }
}