<?php

namespace core\repositories;


use core\entities\Article\Article;
use core\entities\Article\ArticleCategory;
use yii\data\ActiveDataProvider;

class ArticleCategoryRepository
{
    /**
     * @param $id
     * @return ArticleCategory
     */
    public function get($id): ArticleCategory
    {
        if (!$category = ArticleCategory::findOne($id)) {
            throw new NotFoundException('Категория не найдена.');
        }
        return $category;
    }

    public function getBySlug($slug): ArticleCategory
    {
        if (!$category = ArticleCategory::find()->where(['slug' => $slug])->limit(1)->one()) {
            throw new NotFoundException('Категория не найдена.');
        }
        return $category;
    }

    public static function getCategories(): array
    {
        return ArticleCategory::find()->all();
    }

    public function save(ArticleCategory $category): void
    {
        if (!$category->save()) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function remove(ArticleCategory $category): void
    {
        if (!$category->delete()) {
            throw new \RuntimeException('Ошибка при удалении из базы.');
        }
    }
}