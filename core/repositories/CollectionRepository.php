<?php

namespace core\repositories;


use core\entities\Recipe\Collection\Collection;
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
        return new ActiveDataProvider([
            'query' => $collection->getRecipes()->with('author'),
            'pagination' => ['pageSize' => 1, 'defaultPageSize' => 1],
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